<?php namespace codicastudio\sluggable\Tests\Models;

use Illuminate\Support\Str;


/**
 * Class PostWithCustomMethod
 *
 * @package codicastudio\sluggable\Tests\Models
 */
class PostWithCustomMethod extends Post
{

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'method' => function ($string, $separator) {
                    return strrev(Str::slug($string, $separator));
                }
            ]
        ];
    }
}
