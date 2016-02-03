<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;

interface AttachmentRepositoryInterface
{
   /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAttachments($max = 0);
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeletedAttachments($max = 0);
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function deleteAttachment(Attachment $attachment);
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function restoreAttachment(Attachment $attachment);
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function forceDeleteAttachment(Attachment $attachment);
}