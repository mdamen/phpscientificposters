<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $conference
 * @property date $conference_at
 * @property string $contact_email
 * @property string $text
 */
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
    
    /**
     * Get the authors for the poster.
     */
    public function authors()
    {
        return $this->hasMany('App\Models\Author');
    }
}
