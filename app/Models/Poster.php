<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Sofa\Eloquence\Eloquence;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * @property int $id
 * @property string $title
 * @property string $conference
 * @property date $conference_at
 * @property string $contact_email
 * @property string $abstract
 * @property Collection $authors
 * @property Collection $attachments
 */
class Poster extends Model
{
    use SoftDeletes;
    use Eloquence;
    use RevisionableTrait;
    
    protected $fillable = ['title', 'conference', 'conference_at', 'contact_email', 'abstract'];
    protected $table = 'posters';
    protected $dates = ['deleted_at'];
    
    /**
     * Get the attachments for the poster.
     */
    public function attachments()
    {
        return $this->hasMany('App\Models\Attachment');
    }
    
    /**
     * Get the authors for the poster.
     */
    public function authors()
    {
        return $this->hasMany('App\Models\Author');
    }
    
    /**
     * @param int $max
     *
     * Returns a text representation of max $max authors
     */
    public function authorline($max)
    {
        // temp variable to store author names
        $authornames = array();
        
        // find the authors to include
        $authors_to_include = array_slice($this->authors->all(), 0, $max);
        
        // find the names of the included authors
        foreach($authors_to_include as $author_to_include) {
            $authornames[] = $author_to_include->name;
        }
        
        // construct author line
        $authorline = implode(", ", $authornames);
        if($this->authors->count() > $max) {
            $authorline .= " et al.";
        }
        
        return $authorline;
    }
}
