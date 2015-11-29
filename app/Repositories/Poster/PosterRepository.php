<?php

namespace App\Repositories\Poster;

use App\Models\Poster;

class PosterRepository implements PosterRepositoryInterface
{
	/**
	 * @return int
	 */
	public function countPosters() {
		return Poster::all()->count();
	}
	
	/**
	 * @return Collection
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
				'title'			=> $data['title'],
				'conference'	=> $data['conference'],
				'conference_at'	=> $data['conference_at'],
				'contact_email'	=> $data['contact_email'],
				'abstract'		=> $data['abstract']
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
	 */
	public function deletePoster(Poster $poster) {
		$poster->delete();
	}
}

?>