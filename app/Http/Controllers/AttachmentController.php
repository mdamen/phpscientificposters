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
        $request->session()->flash('error', trans('attachment.flash.deleted'));
        
        return redirect(route('poster.details', [$posterid]));
    }
    
    /**
     * @param Request                       $request
     * @param AttachmentRepositoryInterface $repository
     * @param Attachment                    $attachment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request, AttachmentRepositoryInterface $repository, Attachment $attachment)
    {
        $repository->restoreAttachment($attachment);
        
        // flash message to session
        $request->session()->flash('error', trans('attachment.flash.restored'));
        
        return redirect()->back();
    }
    
    /**
     * @param Request                       $request
     * @param AttachmentRepositoryInterface $repository
     * @param Attachment                    $attachment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forcedelete(Request $request, AttachmentRepositoryInterface $repository, Attachment $attachment)
    {
        //retrieve file location
        $attachmentPath = 'uploads/' . $attachment->poster->id . '/' . $attachment->id . '.' . $attachment->extension;
        
        // delete database record
        $repository->forceDeleteAttachment($attachment);
        
        // delete file
        Storage::delete($attachmentPath);
        
        // flash message to session
        $request->session()->flash('error', trans('attachment.flash.deleted_permanently'));
        
        return redirect()->back();
    }

    /**
     * @param Request   $request
     * @param Poster    $poster
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, Poster $poster)
    {
        // get file from request
        $file = $request->file('file');
        
        // setting up rules
        $rules = array('file' => 'required',);
        
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make(array('file' => $file), $rules);
        
        if ($validator->fails()) {
            return response()->json('error', 400);
        } else {
            // checking file is valid.
            if ($file->isValid()) {                
                // create new file object and save
                $attachment = new Attachment([
                    'filename'  => $file->getClientOriginalName(), 
                    'extension' => $file->getClientOriginalExtension(), 
                    'mime'      => $file->getClientMimeType()
                ]);
                $poster->attachments()->save($attachment);
                
                // store file
                $destination = 'uploads/' . $poster->id . '/' . $attachment->id . '.' . $attachment->extension;
                Storage::disk('local')->put($destination,  \Illuminate\Support\Facades\File::get($file));
                
                return response()->json('success', 201);
            } else {
                return response()->json('error', 400);
            }
        }
    }
}
