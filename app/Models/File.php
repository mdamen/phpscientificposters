<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
	
    protected $fillable = ['filename', 'extension'];
	protected $table = 'files';
	protected $dates = ['deleted_at'];
	
	/**
     * Get the poster that owns the file.
     */
    public function poster()
    {
        return $this->belongsTo('App\Models\Poster');
    }
}