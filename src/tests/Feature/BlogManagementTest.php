<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to create a post', function () {
    $title = 'Test Post';
    $content = 'Lorem ipsum';
    $category = Category::factory()->create();

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->post('/api/posts', [
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ])
        ->assertStatus(201)
        ->assertJson([
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ]);
});

it('allows admin to view all posts', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
    $postCount = rand(3, 9);
    Post::factory($postCount)->create();

    $this->get('/api/posts')
        ->assertStatus(200)
        ->assertJsonCount($postCount);
});

it('allows admin to view a specific post', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $post = Post::factory()->create();

    $this->actingAs($admin)
        ->get("/api/posts/{$post->id}")
        ->assertStatus(200)
        ->assertJson([
            'id' => $post->id,
            'title' => $post->title,
        ]);
});

it('allows admin to edit a post', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $post = Post::factory()->create();
    $newTitle = 'Updated Post';

    $this->actingAs($admin)
        ->put("/api/posts/{$post->id}", [
            'title' => $newTitle,
            'content' => $post->content,
            'category_id' => $post->category_id,
        ])
        ->assertStatus(200)
        ->assertJson(['title' => $newTitle]);
});

it('allows admin to delete a post', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $post = Post::factory()->create();

    $this->actingAs($admin)
        ->delete("/api/posts/{$post->id}")
        ->assertStatus(204);
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

// Non-Admin Blocks
it('blocks non-admin from creating a post', fn () =>
    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->post('/api/posts', [
            'title' => 'Test Post',
            'content' => 'Lorem ipsum',
            'category_id' => Category::factory()->create()->id,
        ])
        ->assertStatus(403)
);

it('allows non-admin to view all posts', function () {
    $this->actingAs(User::factory()->create(['role' => 'user']));
    $postCount = rand(3, 9);
    Post::factory($postCount)->create();

    $this->get('/api/posts')
        ->assertStatus(200)
        ->assertJsonCount($postCount);
});

it('allows non-admin to view a specific post', function () {
    $user = User::factory()->create(['role' => 'user']);
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->get("/api/posts/{$post->id}")
        ->assertStatus(200)
        ->assertJson([
            'id' => $post->id,
            'title' => $post->title,
        ]);
});

it('blocks non-admin from editing a post', fn () =>
    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->put('/api/posts/' . Post::factory()->create()->id, [
            'title' => 'Updated Post',
            'content' => 'Lorem ipsum',
            'category_id' => Category::factory()->create()->id,
        ])
        ->assertStatus(403)
);

it('blocks non-admin from deleting a post', fn () =>
    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->delete('/api/posts/' . Post::factory()->create()->id)
        ->assertStatus(403)
);

// Unauthenticated Blocks
it('blocks unauthenticated user from creating a post', fn () =>
    $this->post('/api/posts', [
        'title' => 'Test Post',
        'content' => 'Lorem ipsum',
        'category_id' => Category::factory()->create()->id,
    ])
    ->assertStatus(401) // Sanctum returns 401 for unauthenticated
);

it('blocks unauthenticated user from viewing all posts', fn () =>
    $this->get('/api/posts')
        ->assertStatus(401)
);

it('blocks unauthenticated user from viewing a specific post', fn () =>
    $this->get('/api/posts/' . Post::factory()->create()->id)
        ->assertStatus(401)
);

it('blocks unauthenticated user from editing a post', fn () =>
    $this->put('/api/posts/' . Post::factory()->create()->id, [
        'title' => 'Updated Post',
        'content' => 'Lorem ipsum',
        'category_id' => Category::factory()->create()->id,
    ])
    ->assertStatus(401)
);

it('blocks unauthenticated user from deleting a post', fn () =>
    $this->delete('/api/posts/' . Post::factory()->create()->id)
        ->assertStatus(401)
);