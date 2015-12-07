<?php

namespace App\Http\Controllers;

use App\Models\Poster;

use App\Repositories\Poster\PosterRepositoryInterface;
use App\Repositories\Attachment\AttachmentRepositoryInterface;

/**
 * Class RecycleBinController
 *
 * @package App\Http\Controllers
 */
class RecycleBinController extends Controller
{
    /**
     * @param PosterRepositoryInterface          $posterRepository
     * @param AttachmentRepositoryInterface $attachmentRepository
     *
     * @return Illuminate\View\View
     */
    public function index(PosterRepositoryInterface $posterRepository, AttachmentRepositoryInterface $attachmentRepository)
    {
        $posters = $posterRepository->getDeletedPosters(15);
        $attachments = $attachmentRepository->getDeletedAttachments(15);
        
        return view('recyclebin.index', compact('posters', 'attachments'));
    }
}