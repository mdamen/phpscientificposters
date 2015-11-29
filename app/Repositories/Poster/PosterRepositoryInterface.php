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
     * @return Collection
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
	public function updatePoster(Poster $account);
	
    /**
	 * @param Poster $poster
	 */
	public function deletePoster(Poster $poster);
}


?>