<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use App\Models\Attachment;
use App\Repositories\Attachment\AttachmentRepositoryInterface;

use Input;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;


/**
 * Class AttachmentController
 *
 * @package App\Http\Controllers
 */
class AttachmentController extends Controller
{
    /**
     * @param Attachment $attachment
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Attachment $attachment)
    {
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $attachmentPath = $storagePath . 'uploads/' . $attachment->poster->id . '/' . $attachment->id . '.' . $attachment->extension;
        
        return response()->download($attachmentPath, $attachment->filename);
    }
    
    /**
     * @param Poster    $poster
     *
     * @return Illuminate\View\View
     */
    public function add(Poster $poster)
    {
        return view('attachment.add', compact('poster'));
    }
    
    /**
     * @param Request                       $request
     * @param AttachmentRepositoryInterface $repository
     * @param Attachment                    $attachment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, AttachmentRepositoryInterface $repository, Attachment $attachment)
    {
        $posterid = $attachment->poster->id;
        $repository->deleteAttachment($attachment);
        
        // flash message to session
        $request->session()->flash('error', 'Attachment deleted');
        
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
                $attachment = new Attachment([
                    'filename' => $originalFilename, 
                    'extension' => $originalExtension, 
                    'mime' => $originalMime
                ]);
                $poster->attachments()->save($attachment);
                
                // move uploaded file
                $destination = 'uploads/' . $poster->id . '/' . $attachment->id . '.' . $originalExtension;
                Storage::disk('local')->put($destination,  \Illuminate\Support\Facades\File::get($file));
                
                return response()->json('success', 201);
            } else {
                return response()->json('error', 400);
            }
        }
    }
}
