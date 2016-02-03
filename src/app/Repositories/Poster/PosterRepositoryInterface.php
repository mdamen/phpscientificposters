<?php

namespace App\Repositories\Poster;

use App\Models\Poster;
use App\Models\Author;

interface PosterRepositoryInterface
{
    /**
     * @return int
     */
    public function countPosters();
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPosters($max = 0);
    
    /**
     * @param string $query
     * @param int    $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchPosters($query, $max = 0);
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeletedPosters($max = 0);
    
    /**
     * @param array $data
     *
     * @return Poster
     */
    public function storePoster(array $data);
    
    /**
     * @param Poster $poster
     *
     * @return Poster
     */
    public function updatePoster(Poster $poster);
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function deletePoster(Poster $poster);
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function restorePoster(Poster $poster);
    
    /**
     * @param Poster $poster
     *
     * @return void
     */
    public function forceDeletePoster(Poster $poster);
    
    /**
     * @param Poster $poster
     * @param array  $authornames
     *
     * @return void
     */
    public function syncAuthorsByName(Poster $poster, array $authornames);
    
    /**
     * @param Poster    $poster
     * @param Author $author
     *
     * @return void
     */
    public function attachAuthor(Poster $poster, Author $author);
    
    /**
     * @param Poster $poster
     * @param Author $author
     *
     * @return void
     */
    public function detachAuthor(Poster $poster, Author $author);
}