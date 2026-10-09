<?php

it('renders the learnify welcome dashboard', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Learnify');
    $response->assertSee('Phase 1');
    $response->assertSee('Docker Environment Running');
});

it('returns a successful response from the health check endpoint', function () {
    $response = $this->getJson('/health');

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'ok',
            'php' => PHP_VERSION,
        ])
        ->assertJsonStructure([
            'status',
            'framework',
            'php',
            'timestamp',
        ]);
});
