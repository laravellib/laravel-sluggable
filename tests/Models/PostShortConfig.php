<?php

namespace codicastudio\sluggable\Tests\Models;

/**
 * Class PostShortConfig.
 */
class PostShortConfig extends Post
{
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return array(
            'slug',
        );
    }
}
