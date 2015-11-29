<?php

namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use App\Models\Poster;
use App\Http\Requests\PosterFormRequest;
use App\Repositories\Poster\PosterRepositoryInterface;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class PosterController extends Controller
{	
	/**
	 * @param PosterRepositoryInterface $repository
	 *
	 * @return \Illuminate\View\View
	 */
	public function index(PosterRepositoryInterface $repository)
	{
		$posters = $repository->getPosters();
		
		return view('poster.list', compact('posters'));
	}
	
	/**
	 * @param PosterRepositoryInterface $repository
	 * @param Poster					$poster
	 *
	 * @return \Illuminate\View\View
	 */
	public function details(PosterRepositoryInterface $repository, UrlGenerator $urlgenerator, Poster $poster)
	{
		$url = $urlgenerator->full();
		
		return view('poster.details', compact('poster', 'url'));
	}
	
	/**
	 * @param PosterRepositoryInterface $repository
	 *
	 * @return \Illuminate\View\View
	 */
	public function create(PosterRepositoryInterface $repository)
	{
		return view('poster.create');
	}
	
	/**
	 * @param PosterRepositoryInterface $repository
	 * @param Poster					$poster
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit(PosterRepositoryInterface $repository, Poster $poster)
	{
		return view('poster.edit', compact('poster'));
	}
	
	/**
	 * @param PosterFormRequest			$request
	 * @param PosterRepositoryInterface $repository
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function add(PosterFormRequest $request, PosterRepositoryInterface $repository)
	{
		$posterdata = [
			'title'			=> $request->input('title'),
			'conference'	=> $request->input('conference'),
			'conference_at' => $request->input('conference_at'),
			'contact_email'	=> $request->input('contact_email'),
			'abstract'		=> $request->input('abstract')
		];
		
		$poster = $repository->storePoster($posterdata);
		
		return redirect(route('poster.details', [$poster->id]));
	}
	
	/**
	 * @param PosterFormRequest		  	$request
	 * @param PosterRepositoryInterface $repository
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(PosterFormRequest $request, PosterRepositoryInterface $repository, Poster $poster)
	{
		$poster->title 			= $request->input('title');
		$poster->conference 	= $request->input('conference');
		$poster->conference_at 	= $request->input('conference_at');
		$poster->contact_email 	= $request->input('contact_email');
		$poster->abstract		= $request->input('abstract');
		
		$repository->updatePoster($poster);
		
		return redirect(route('poster.details', [$poster->id]));
	}

	/**
	 * @param PosterRepositoryInterface $repository
	 * @param Poster					$poster
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete(PosterRepositoryInterface $repository, Poster $poster)
	{
		$repository->deletePoster($poster);
		
		return redirect(route('poster.list'));
	}
}

#$url = "http://www.tweakers.net";
#$qrcode = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($url) . "&choe=UTF-8";
#<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fwww.google.com%2F&choe=UTF-8" title="Link to Google.com" />

#return "<img src=" . $qrcode . " />";