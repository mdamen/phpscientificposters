<?php

namespace App\Http\Controllers;

use Illuminate\Routing\UrlGenerator;
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
     * @return \Illuminate\View\View
     */
    public function index(PosterRepositoryInterface $repository)
    {
        $posters = $repository->getPosters();
        
        return view('poster.list', compact('posters'));
    }
    
    /**
     * @param UrlGenerator $urlgenerator
     * @param Poster       $poster
     *
     * @return \Illuminate\View\View
     */
    public function details(UrlGenerator $urlgenerator, Poster $poster)
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
     * @param Poster $poster
     *
     * @return \Illuminate\View\View
     */
    public function edit(Poster $poster)
    {
        return view('poster.edit', compact('poster'));
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
        
        // retrieve authors
        $authors = array_filter($request->input('authors'));
        
        // add authors
        $repository->addAuthorsByName($poster, $authors);
        
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
        if (!is_array($authors_to_process)) {
            throw new \RuntimeException('$authors_to_process must be an array.');
        }
        
        // set poster properties and update
        $poster->title          = $request->input('title');
        $poster->conference     = $request->input('conference');
        $poster->conference_at  = $request->input('conference_at');
        $poster->contact_email  = $request->input('contact_email');
        $poster->abstract       = $request->input('abstract');
        $repository->updatePoster($poster);
        
        // temp variable to find which authors to still process after detaching
        $authors_to_process = $request->input('authors');
        
        // remove authors not present anymore in form
        foreach($poster->authors as $author) {
            if(!in_array($author->name, $request->input('authors'))) {
                $repository->detachAuthor($poster, $author);
            }
            
            $authors_to_process = array_diff($authors_to_process, [$author->name]);
        }
        
        // add authors not present anymore in database
        $repository->addAuthorsByName($poster, $authors_to_process);
        
        return redirect(route('poster.details', [$poster->id]));
    }

    /**
     * @param PosterRepositoryInterface $repository
     * @param Poster                    $poster
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PosterRepositoryInterface $repository, Poster $poster)
    {
        $repository->deletePoster($poster);
        
        return redirect(route('poster.list'));
    }
}