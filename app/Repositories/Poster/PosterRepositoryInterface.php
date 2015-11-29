<?php

namespace App\Repositories\Poster;

use App\Models\Poster;

interface PosterRepositoryInterface
{
    /**
     * @return int
     */
    public function countPosters();
    
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPosters();
    
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
}


?>