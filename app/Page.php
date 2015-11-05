<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'user_id', 'enabled'];

    /**
     * Get the blocks belonging to the current page
     */
    public function blocks()
    {
    	return $this->hasMany('App\Block');
    }

    /**
     * Get only enabled blocks
     */
    public function enabledBlocks()
    {
        return $this->hasMany('App\Block')->enabled();
    }
}
