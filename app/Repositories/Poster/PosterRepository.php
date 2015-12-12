<?php

namespace App\Repositories\Poster;

use App\Models\Poster;
use App\Models\Author;

class PosterRepository implements PosterRepositoryInterface
{
    /**
     * @return int
     */
    public function countPosters() {
        return Poster::all()->count();
    }
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPosters($max = 0) {
        $posters = Poster::orderBy('conference_at', 'desc')->orderBy('id', 'desc');
        
        if (!empty($max))
            return $posters->paginate($max);
        else
            return $posters->get();
    }
    
    /**
     * @param string $query
     * @param int    $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchPosters($query, $max = 0) {
        $posters = Poster::search($query, ['title' => 50, 'conference' => 40, 'authors.name' => 30, 'abstract' => 10], true, 5);

        if (!empty($max))
            return $posters->paginate($max);
        else
            return $posters->get();
    }
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeletedPosters($max = 0) {
        if (empty($max))
            return Poster::onlyTrashed()->orderBy('deleted_at', 'desc');
        else
            return Poster::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($max);
    }
    
    /**
     * @param array $data
     *
     * @return Poster
     */
    public function storePoster(array $data) {
        $poster = new Poster(
            [
                'title'         => $data['title'],
                'conference'    => $data['conference'],
                'conference_at' => $data['conference_at'],
                'contact_email' => $data['contact_email'],
                'abstract'      => $data['abstract']
            ]
        );        
        $poster->save();
        
        return $poster;
    }
    
    /**
     * @param Poster $poster
     *
     * @return Poster
     */
    public function updatePoster(Poster $poster) {
        $poster->save();
        
        return $poster;
    }
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function deletePoster(Poster $poster) {
        $poster->delete();
    }
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function restorePoster(Poster $poster) {
        $poster->restore();
    }
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function forceDeletePoster(Poster $poster) {
        $poster->forceDelete();
    }
    
    /**
     * @param Poster $poster
     * @param array  $authornames
     *
     * @return void
     */
    public function syncAuthorsByName(Poster $poster, array $authornames) {
        $authors_to_process = $this->removeAuthorsByName($poster, $authornames);
        $this->addAuthorsByName($poster, $authors_to_process);
    }
    
    /**
     * @param Poster $poster
     * @param array  $authornames
     *
     * @return void
     */
    private function addAuthorsByName(Poster $poster, array $authornames) {
        foreach($authornames as $authorname) {
            $this->attachAuthor($poster, new Author([
                'name' => $authorname
            ]));
        }
    }
    
    /**
     * @param Poster $poster
     * @param array  $authornames
     *
     * @return array
     */
    private function removeAuthorsByName(Poster $poster, array $authornames) {
        $authors_to_process = $authornames;
        
        // remove authors not present anymore in form
        foreach($poster->authors as $author) {
            if(!in_array($author->name, $authornames)) {
                $this->detachAuthor($poster, $author);
            }
            
            $authors_to_process = array_diff($authors_to_process, [$author->name]);
        }
        
        return $authors_to_process;
    }
    
    /**
     * @param Poster $poster
     * @param Author $author
     *
     * @return void
     */
    public function attachAuthor(Poster $poster, Author $author) {
        $poster->authors()->save($author);
    }
    
    /**
     * @param Poster $poster
     * @param Author $author
     *
     * @return void
     */
    public function detachAuthor(Poster $poster, Author $author) {
        $author->delete();
    }
}