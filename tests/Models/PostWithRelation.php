<?php

namespace codicastudio\sluggable\Tests\Models;

/**
 * Class PostWithRelation.
 *
 * A test model used for the relationship tests.
 *
 *
 * @property \codicastudio\sluggable\Tests\Models\Author author
 */
class PostWithRelation extends Post
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
                'source' => array('author.name', 'title'),
            ),
        );
    }

    /**
     * Relation to Author model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
