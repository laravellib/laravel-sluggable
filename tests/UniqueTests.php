<?php

namespace codicastudio\sluggable\Tests;

use codicastudio\sluggable\Tests\Models\Author;
use codicastudio\sluggable\Tests\Models\Post;
use codicastudio\sluggable\Tests\Models\PostWithUniqueSlugConstraints;

/**
 * Class UniqueTests.
 */
class UniqueTests extends TestCase
{
    /**
     * Test uniqueness of generated slugs.
     */
    public function testUnique()
    {
        for ($i = 0; $i < 20; $i++) {
            $post = Post::create(array(
                'title' => 'A post title',
            ));
            if ($i == 0) {
                $this->assertEquals('a-post-title', $post->slug);
            } else {
                $this->assertEquals('a-post-title-'.$i, $post->slug);
            }
        }
    }

    /**
     * Test uniqueness after deletion.
     */
    public function testUniqueAfterDelete()
    {
        $post1 = Post::create(array(
            'title' => 'A post title',
        ));
        $this->assertEquals('a-post-title', $post1->slug);

        $post2 = Post::create(array(
            'title' => 'A post title',
        ));
        $this->assertEquals('a-post-title-1', $post2->slug);

        $post1->delete();

        $post3 = Post::create(array(
            'title' => 'A post title',
        ));
        $this->assertEquals('a-post-title', $post3->slug);
    }

    /**
     * Test custom unique query scopes.
     */
    public function testCustomUniqueQueryScope()
    {
        $authorBob = Author::create(array('name' => 'Bob'));
        $authorPam = Author::create(array('name' => 'Pam'));

        // Bob's first post
        $post = new PostWithUniqueSlugConstraints(array('title' => 'My first post'));
        $post->author()->associate($authorBob);
        $post->save();

        $this->assertEquals('my-first-post', $post->slug);

        // Bob's second post with same title is made unique
        $post = new PostWithUniqueSlugConstraints(array('title' => 'My first post'));
        $post->author()->associate($authorBob);
        $post->save();

        $this->assertEquals('my-first-post-1', $post->slug);

        // Pam's first post with same title is scoped to her
        $post = new PostWithUniqueSlugConstraints(array('title' => 'My first post'));
        $post->author()->associate($authorPam);
        $post->save();

        $this->assertEquals('my-first-post', $post->slug);

        // Pam's second post with same title is scoped to her and made unique
        $post = new PostWithUniqueSlugConstraints(array('title' => 'My first post'));
        $post->author()->associate($authorPam);
        $post->save();

        $this->assertEquals('my-first-post-1', $post->slug);
    }

    public function testIssue431()
    {
        $post1 = Post::create(array(
            'title' => 'A post title',
        ));
        $this->assertEquals('a-post-title', $post1->slug);

        $post2 = new Post;
        $post2->title = 'A post title';
        $post2->save();
        $this->assertEquals('a-post-title-1', $post2->slug);
    }
}
