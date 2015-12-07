<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;

interface AttachmentRepositoryInterface
{
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function deleteAttachment(Attachment $attachment);
}