<?php

use App\Models\Event;
use App\Models\Category;
use App\Models\User;

it('allows guest users to view upcoming events on the landing page', function () {
    $category = Category::factory()->create();
    $organizer = User::factory()->create(['role' => 'organizer']);
    
    // Create an approved event
    $event = Event::create([
        'user_id' => $organizer->id,
        'category_id' => $category->id,
        'title' => 'Test Upcoming Event',
        'description' => 'This is a test event description.',
        'date' => now()->addDays(5)->format('Y-m-d'),
        'time' => '18:00:00',
        'location' => 'Tech Hub',
        'capacity' => 100,
        'price' => 0,
        'status' => 'approved',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Test Upcoming Event');
    $response->assertSee('FREE');
});

it('allows guest users to view approved events on the explore directory', function () {
    $category = Category::factory()->create();
    $organizer = User::factory()->create(['role' => 'organizer']);
    
    $event = Event::create([
        'user_id' => $organizer->id,
        'category_id' => $category->id,
        'title' => 'Explore Event Test',
        'description' => 'Exploring things.',
        'date' => now()->addDays(5)->format('Y-m-d'),
        'time' => '18:00:00',
        'location' => 'Tech Hub',
        'capacity' => 100,
        'price' => 0,
        'status' => 'approved',
    ]);

    $response = $this->get('/events');

    $response->assertStatus(200);
    $response->assertSee('Explore Event Test');
});

it('allows guest users to view the details of an approved event', function () {
    $category = Category::factory()->create();
    $organizer = User::factory()->create(['role' => 'organizer']);
    
    $event = Event::create([
        'user_id' => $organizer->id,
        'category_id' => $category->id,
        'title' => 'Specific Detail Event Test',
        'description' => 'Detailed description of the event.',
        'date' => now()->addDays(5)->format('Y-m-d'),
        'time' => '18:00:00',
        'location' => 'Tech Hub',
        'capacity' => 100,
        'price' => 250,
        'status' => 'approved',
    ]);

    $response = $this->get("/events/{$event->id}");

    $response->assertStatus(200);
    $response->assertSee('Specific Detail Event Test');
    $response->assertSee('₹250');
    $response->assertSee('Log In to Book');
});
