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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPosters() {
        return Poster::all();
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
     * param array $authornames
     *
     * @return void
     */
    function addAuthorsByName(array $authornames) {
        foreach($authornames as $authorname) {
            $this->attachAuthor($poster, new Author([
                'name' => $authorname
            ]));
        }
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