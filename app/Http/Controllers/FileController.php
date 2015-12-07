<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use App\Models\File;
use App\Repositories\File\FileRepositoryInterface;

use Input;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


/**
 * Class FileController
 *
 * @package App\Http\Controllers
 */
class FileController extends Controller
{
    /**
     * @param File      $file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(File $file)
    {
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filePath = $storagePath . 'uploads/' . $file->poster->id . '/' . $file->id . '.' . $file->extension;
        
        return response()->download($filePath, $file->filename);
    }
    
    /**
     * @param Poster    $poster
     *
     * @return Illuminate\View\View
     */
    public function add(Poster $poster)
    {
        return view('file.add', compact('poster'));
    }
    
    /**
     * @param Request                   $request
     * @param FileRepositoryInterface   $repository
     * @param File                      $file
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, FileRepositoryInterface $repository, File $file)
    {
        $posterid = $file->poster->id;
        $repository->deleteFile($file);
        
        // flash message to session
        $request->session()->flash('error', 'File deleted');
        
        return redirect(route('poster.details', [$posterid]));
    }

    /**
     * @param Request   $request
     * @param Poster    $poster
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, Poster $poster)
    {
        // getting all of the post data
        $filevalidate = array('file' => Input::file('file'));
        
        // setting up rules
        $rules = array('file' => 'required',);
        
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($filevalidate, $rules);
        
        if ($validator->fails()) {
            return response()->json('error', 400);
        } else {
            // checking file is valid.
            if (Input::file('file')->isValid()) {
                // get file
                $file = $request->file('file');
                
                // get original filename
                $originalFilename   = $file->getClientOriginalName();
                $originalExtension  = $file->getClientOriginalExtension();
                $originalMime       = $file->getClientMimeType();
                
                // create new file object and save
                $file_obj = new File([
                    'filename' => $originalFilename, 
                    'extension' => $originalExtension, 
                    'mime' => $originalMime
                ]);
                $poster->files()->save($file_obj);
                
                // move uploaded file
                $destination = 'uploads/' . $poster->id . '/' . $file_obj->id . '.' . $originalExtension;
                Storage::disk('local')->put($destination,  \Illuminate\Support\Facades\File::get($file));
                
                return response()->json('success', 201);
            } else {
                return response()->json('error', 400);
            }
        }
    }
}
