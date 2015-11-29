<?php

namespace App\Repositories\File;

use App\Models\File;

interface FileRepositoryInterface
{
	/**
	 * @param File $file
	 *
	 * @return void
	 */
	public function deleteFile(File $file);
}


?>