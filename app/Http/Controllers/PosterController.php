<?php

namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Models\Author;
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
    private $pagination_count = 10;
    
    /**
     * @param Request                   $request
     * @param PosterRepositoryInterface $repository
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request, PosterRepositoryInterface $repository)
    {
        if ($request->has('query'))
            $posters = $repository->searchPosters($request->get('query'), $this->pagination_count);
        else
            $posters = $repository->getPosters($this->pagination_count);
        
        return view('poster.list', compact('posters'));
    }
    
    /**
     * @param UrlGenerator $urlgenerator
     * @param Poster       $poster
     *
     * @return Illuminate\View\View
     */
    public function details(UrlGenerator $urlgenerator, Poster $poster)
    {
        $url = $urlgenerator->full();
        
        return view('poster.details', compact('poster', 'url'));
    }
    
    /**
     * @param Request $request
     *
     * @return Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (!empty($request->old('authors'))) {
            $authors = old('authors');
        } else {
            $authors = array('', '', '');
        }
        
        return view('poster.create', compact('authors'));
    }
    
    /**
     * @param Request $request
     * @param Poster  $poster
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request, Poster $poster)
    {
        if (!empty($request->old('authors'))) {
            $authors = old('authors');
        } else {
            $authors = array();
            
            foreach($poster->authors as $author) {
                $authors[] = $author->name;
            }
        }
        
        return view('poster.edit', compact('poster', 'authors'));
    }
    
    /**
     * @param PosterFormRequest         $request
     * @param PosterRepositoryInterface $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(PosterFormRequest $request, PosterRepositoryInterface $repository)
    {
        // check if input is array
        if (!is_array($request->input('authors'))) {
            throw new \RuntimeException('$authors must be an array.');
        }
        
        // set poster properties and save
        $posterdata = [
            'title'         => $request->input('title'),
            'conference'    => $request->input('conference'),
            'conference_at' => $request->input('conference_at'),
            'contact_email' => $request->input('contact_email'),
            'abstract'      => $request->input('abstract')
        ];
        $poster = $repository->storePoster($posterdata);
        
        // sync authors
        $repository->syncAuthorsByName($poster, array_filter($request->input('authors')));
        
        // flash message to session
        $request->session()->flash('success', trans('poster.flash.added'));
        
        return redirect(route('poster.details', [$poster->id]));
    }
    
    /**
     * @param PosterFormRequest         $request
     * @param PosterRepositoryInterface $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PosterFormRequest $request, PosterRepositoryInterface $repository, Poster $poster)
    {
        // check if input is array
        if (!is_array($request->input('authors'))) {
            throw new \RuntimeException('$authors_to_process must be an array.');
        }
        
        // set poster properties and update
        $poster->title          = $request->input('title');
        $poster->conference     = $request->input('conference');
        $poster->conference_at  = $request->input('conference_at');
        $poster->contact_email  = $request->input('contact_email');
        $poster->abstract       = $request->input('abstract');
        $repository->updatePoster($poster);
        
        // sync authors
        $repository->syncAuthorsByName($poster, array_filter($request->input('authors')));
        
        // flash message to session
        $request->session()->flash('success', trans('poster.flash.updated'));
        
        return redirect(route('poster.details', [$poster->id]));
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param PosterRepositoryInterface $repository
     * @param Poster                    $poster
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, PosterRepositoryInterface $repository, Poster $poster)
    {
        // delete poster
        $repository->deletePoster($poster);
        
        // flash message to session
        $request->session()->flash('error', trans('poster.flash.removed'));
        
        return redirect(route('poster.list'));
    }
    
    /**
     * @param \Illuminate\Http\Request      $request
     * @param PosterRepositoryInterface  $repository
     * @param Poster                                      $poster
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forcedelete(Request $request, PosterRepositoryInterface $repository, Poster $poster)
    {
        // delete poster
        $repository->forceDeletePoster($poster);
        
        // flash message to session
        $request->session()->flash('error', trans('poster.flash.removed_permanently'));
        
        return redirect()-back();
    }
    
    /**
     * @param \Illuminate\Http\Request  $request
     * @param PosterRepositoryInterface $repository
     * @param Poster                    $poster
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request, PosterRepositoryInterface $repository, Poster $poster)
    {
        // delete poster
        $repository->restorePoster($poster);
        
        // flash message to session
        $request->session()->flash('error', trans('poster.flash.restored'));
        
        return redirect()->back();
    }
}