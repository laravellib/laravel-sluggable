<?php

namespace codicastudio\sluggable\Tests\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Author.
 *
 * A test model used for the relationship tests.
 *
 *
 * @property int id
 * @property string name
 */
class Author extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name');
}
