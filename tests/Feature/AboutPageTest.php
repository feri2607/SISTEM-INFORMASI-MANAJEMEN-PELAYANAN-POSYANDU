<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

test('about page loads successfully', function () {
    $response = $this->get('/tentang');

    $response->assertStatus(200);
});
