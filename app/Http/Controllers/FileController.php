<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use App\Models\File;
use App\Repositories\File\FileRepositoryInterface;
use Input;
use Validator;
use Request;
use Response;

/**
 * Class FileController
 *
 * @package App\Http\Controllers
 */
class FileController extends Controller
{	
	/**
	 * @param Poster	$poster
	 *
	 * @return \Illuminate\View\View
	 */
	public function add(Poster $poster)
	{
		return view('file.add', compact('poster'));
	}
	
	/**
	 * @param File	$file
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete(FileRepositoryInterface $repository, File $file)
	{
		$posterid = $file->poster->id;
		$repository->deleteFile($file);
		
		return redirect(route('poster.details', [$posterid]));
	}

	/**
	 * @param Request 	$request
	 * @param Poster	$poster
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function upload(Request $request, Poster $poster)
	{
		// getting all of the post data
		$file = array('file' => Input::file('file'));
		
		// setting up rules
		$rules = array('file' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
		
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		
		if ($validator->fails()) {
			return Response::json('error', 400);
		} else {
			// checking file is valid.
			if (Input::file('file')->isValid()) {
				// get original filename
				$originalFilename = Input::file('file')->getClientOriginalName();
				$originalExtension = Input::file('file')->getClientOriginalExtension();
				
				// create new file object and save
				$file_obj = new File(['filename' => $originalFilename, 'extension' => $originalExtension]);
				$poster->files()->save($file_obj);
				
				// move uploaded file
				$destinationPath = 'uploads/' . $poster->id; // upload path
				$fileName = $file_obj->id . '.' . $originalExtension; // renameing image
				Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
				
				return Response::json('success', 200);
			} else {
				return Response::json('error', 400);
			}
		}
	}
	
	/**
	 * @param Request 	$request
	 * @param File		$file
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function download(Request $request, File $file)
	{
		$filePath = public_path() . "/uploads/" . $file->poster->id . "/" . $file->id . "." . $file->extension;
		return Response::download($filePath, $file->filename);
	}
}

?>