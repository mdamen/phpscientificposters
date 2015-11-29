<?php

namespace App\Repositories\File;

use App\Models\File;

class FileRepository implements FileRepositoryInterface
{
	/**
	 * @param File $file
	 *
	 * @return void
	 */
	public function deleteFile(File $file) {
		$file->delete();
	}
}

?>