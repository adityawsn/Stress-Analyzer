<?php

namespace Tests\Feature;

use Tests\TestCase;

class HasilPageTest extends TestCase
{
    public function test_hasil_page_can_be_rendered(): void
    {
        $response = $this->get('/hasil');

        $response->assertOk();
    }

    public function test_hasil_calculate_returns_fuzzy_result(): void
    {
        $response = $this->getJson('/hasil/calculate?tps=60&mw=60');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'tps',
                'mw',
                'tsukamoto' => ['nilai', 'kategori'],
                'mamdani' => ['nilai', 'kategori'],
                'selisih',
            ]);
    }
}
