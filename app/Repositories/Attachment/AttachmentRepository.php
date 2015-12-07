<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function deleteAttachment(Attachment $attachment) {
        $attachment->delete();
    }
}