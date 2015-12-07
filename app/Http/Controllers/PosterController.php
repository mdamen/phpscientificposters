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
    /**
     * @param PosterRepositoryInterface $repository
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index(PosterRepositoryInterface $repository)
    {
        $posters = $repository->getPosters(15);
        
        return view('poster.list', compact('posters'));
    }
    
    /**
     * @param UrlGenerator $urlgenerator
     * @param Poster       $poster
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function details(UrlGenerator $urlgenerator, Poster $poster)
    {
        $url = $urlgenerator->full();
        
        return view('poster.details', compact('poster', 'url'));
    }
    
    /**
     * @param PosterRepositoryInterface $repository
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function create(PosterRepositoryInterface $repository)
    {
        return view('poster.create');
    }
    
    /**
     * @param Request $request
     * @param Poster  $poster
     *
     * @return \Illuminate\Contracts\View\Factory
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
        // retrieve authors
        $authors = array_filter($request->input('authors'));
        
        // check if input is array
        if (!is_array($authors)) {
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
        
        // add authors
        $repository->addAuthorsByName($poster, $authors);
        
        // flash message to session
        $request->session()->flash('success', 'Poster successfully added');
        
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
        
        // remove authors not present in database
        $authors_to_process = $repository->removeAuthorsByName($poster, array_filter($request->input('authors')));
        
        // add authors not present anymore in database
        $repository->addAuthorsByName($poster, $authors_to_process);
        
        // flash message to session
        $request->session()->flash('success', 'Poster successfully updated');
        
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
        $request->session()->flash('error', 'Poster removed');
        
        return redirect(route('poster.list'));
    }
}