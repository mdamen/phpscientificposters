<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $poster_id
 * @property string $name
 * @property Poster $poster
 */
class Author extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name'];
    protected $table = 'authors';
    protected $dates = ['deleted_at'];
    
    /**
     * Get the poster that the author created.
     *
     * @return Poster
     */
    public function poster()
    {
        return $this->belongsTo('App\Models\Poster');
    }
}
