<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'block';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'slug', 'content', 'enabled'];

    /**
     * Get the page that owns the block
     */
    public function page()
    {
    	return $this->belongsTo('App\Page');
    }

    /**
     * Get the serialized content
     */
    public function getContentAttribute($value)
    {
        return json_decode($value);
    }
}
