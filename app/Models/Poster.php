<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poster extends Model
{
    use SoftDeletes;
	
    protected $fillable = ['title', 'conference', 'conference_at', 'contact_email', 'abstract'];
	protected $table = 'posters';
	protected $dates = ['deleted_at'];
	
	/**
     * Get the files for the poster.
     */
    public function files()
    {
        return $this->hasMany('App\Models\File');
    }
}
