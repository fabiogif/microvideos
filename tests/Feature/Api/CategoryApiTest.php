<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{

    protected string $endPoint = '/api/categories';

    public function test_list_empty_all_categories(): void
    {
        $response = $this->getJson($this->endPoint);

        $response->assertStatus(200);
    }
    public function test_list_all_categories()
    {
        Category::factory()->count(30)->create();

        $response = $this->getJson($this->endPoint);

        $response->assertJsonStructure([
            "meta" => [
                "total",
                "current_page",
                "last_page",
                "first_page",
                "per_page",
                "to",
                "from", ]]);

        $response->assertStatus(200);

    }

    public function test_list_paginate_categories()
    {
        Category::factory()->count(30)->create();

        $response = $this->getJson("$this->endPoint?page=2");
        $response->assertStatus(200);

    }
}


