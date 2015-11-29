<?php

namespace App\Repositories\File;

use App\Models\File;

interface FileRepositoryInterface
{
	/**
	 * @param File $file
	 */
	public function deleteFile(File $file);
}


?>