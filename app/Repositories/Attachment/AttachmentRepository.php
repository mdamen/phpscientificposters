<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAttachments($max = 0) {
        if (empty($max))
            return Attachment::all();
        else
            return Attachment::paginate($max);
    }
    
    /**
     * @param int $max
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDeletedAttachments($max = 0) {
        if (empty($max))
            return Attachment::onlyTrashed();
        else
            return Attachment::onlyTrashed()->paginate($max);
    }
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function deleteAttachment(Attachment $attachment) {
        $attachment->delete();
    }
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function restoreAttachment(Attachment $attachment) {
        $attachment->restore();
    }
    
    /**
     * @param Attachment $attachment
     *
     * @return void
     */
    public function forceDeleteAttachment(Attachment $attachment) {
        $attachment->forceDelete();
    }
}