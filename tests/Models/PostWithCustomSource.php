<?php

namespace codicastudio\sluggable\Tests\Models;

/**
 * Class PostWithCustomSource.
 *
 * A test model that uses a custom suffix generation method.
 */
class PostWithCustomSource extends Post
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
                'source' => 'subtitle',
            ),
        );
    }
}
