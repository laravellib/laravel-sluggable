<?php

namespace codicastudio\sluggable\Tests\Models;

/**
 * Class PostWithOnUpdate.
 *
 * A test model that uses the onUpdate functionality.
 */
class PostWithOnUpdate extends Post
{
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return array(
            'slug' => array(
                'source' => 'title',
                'onUpdate' => true,
            ),
        );
    }
}
