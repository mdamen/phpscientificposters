<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $poster_id
 * @property string $filename
 * @property string $extension
 * @property string $mime
 * @property Poster $poster
 */
class File extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['filename', 'extension'];
    protected $table = 'files';
    protected $dates = ['deleted_at'];
    
    /**
     * Get the poster that owns the file.
     *
     * @return Poster
     */
    public function poster()
    {
        return $this->belongsTo('App\Models\Poster');
    }
}
