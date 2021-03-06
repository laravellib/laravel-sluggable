<?php

namespace codicastudio\sluggable\Tests\Models;

use Cocur\Slugify\Slugify;

/**
 * Class PostCustomEngine2.
 *
 * A test model that customizes the Slugify engine with other custom rules.
 */
class PostWithCustomEngine2 extends Post
{
    /**
     * @param \Cocur\Slugify\Slugify $engine
     * @param string $attribute
     * @return \Cocur\Slugify\Slugify
     */
    public function customizeSlugEngine(Slugify $engine, $attribute)
    {
        return new Slugify(array('regexp' => '|[^A-Za-z0-9/]+|'));
    }
}
