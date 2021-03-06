<?php

namespace codicastudio\sluggable\Tests;

use codicastudio\sluggable\Tests\Models\Post;
use codicastudio\sluggable\Tests\Models\PostWithOnUpdate;

/**
 * Class OnUpdateTests.
 */
class OnUpdateTests extends TestCase
{
    /**
     * Test that the slug isn't regenerated if onUpdate is false.
     */
    public function testSlugDoesntChangeWithoutOnUpdate()
    {
        $post = Post::create(array(
            'title' => 'My First Post',
        ));
        $post->save();
        $this->assertEquals('my-first-post', $post->slug);

        $post->update(array(
            'title' => 'A New Title',
        ));
        $this->assertEquals('my-first-post', $post->slug);
    }

    /**
     * Test that the slug is regenerated if the field is emptied manually.
     */
    public function testSlugDoesChangeWhenEmptiedManually()
    {
        $post = Post::create(array(
            'title' => 'My First Post',
        ));
        $post->save();
        $this->assertEquals('my-first-post', $post->slug);

        $post->slug = null;
        $post->update(array(
            'title' => 'A New Title',
        ));
        $this->assertEquals('a-new-title', $post->slug);
    }

    /**
     * Test that the slug is regenerated if onUpdate is true.
     */
    public function testSlugDoesChangeWithOnUpdate()
    {
        $post = PostWithOnUpdate::create(array(
            'title' => 'My First Post',
        ));
        $post->save();
        $this->assertEquals('my-first-post', $post->slug);

        $post->update(array(
            'title' => 'A New Title',
        ));
        $this->assertEquals('a-new-title', $post->slug);
    }

    /**
     * Test that the slug is not regenerated if onUpdate is true
     * but the source fields didn't change.
     */
    public function testSlugDoesNotChangeIfSourceDoesNotChange()
    {
        $post = PostWithOnUpdate::create(array(
            'title' => 'My First Post',
        ));
        $post->save();
        $this->assertEquals('my-first-post', $post->slug);

        $post->update(array(
            'subtitle' => 'A Subtitle',
        ));
        $this->assertEquals('my-first-post', $post->slug);
    }

    /**
     * Test that the slug is not regenerated if onUpdate is true
     * but the source fields didn't change, even with multiple
     * increments of the same slug.
     *
     * @see https://github.com/codicastudio/sluggable/issues/317
     */
    public function testSlugDoesNotChangeIfSourceDoesNotChangeMultiple()
    {
        $data = array(
            'title' => 'My First Post',
        );
        $post0 = PostWithOnUpdate::create($data);
        $post1 = PostWithOnUpdate::create($data);
        $post2 = PostWithOnUpdate::create($data);
        $post3 = PostWithOnUpdate::create($data);
        $this->assertEquals('my-first-post-3', $post3->slug);

        $post3->update(array(
            'subtitle' => 'A Subtitle',
        ));
        $this->assertEquals('my-first-post-3', $post3->slug);
    }

    /**
     * Test that the slug isn't set to null if the source fields
     * not loaded in model.
     */
    public function testSlugDoesNotChangeIfSourceNotProvidedInModel()
    {
        $post = Post::create(array(
            'title' => 'My First Post',
        ));
        $this->assertEquals('my-first-post', $post->slug);

        $post = Post::whereKey($post->id)->get(array('id', 'subtitle'))->first();
        $post->update(array(
            'subtitle' => 'A Subtitle',
        ));

        $post = Post::findOrFail($post->id);
        $this->assertEquals('my-first-post', $post->slug);
    }
}
