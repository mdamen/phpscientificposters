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
        if (empty($max))
            return Poster::all();
        else
            return Poster::paginate($max);
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
     * @param array  $authornames
     *
     * @return void
     */
    public function addAuthorsByName(Poster $poster, array $authornames) {
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
    public function removeAuthorsByName(Poster $poster, array $authornames) {
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

?>