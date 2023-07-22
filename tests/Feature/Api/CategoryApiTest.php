<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Http\Response;
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
        $this->assertEquals(2, $response['meta']['current_page']);

    }


    public function test_list_category_notfound()
    {
        $response = $this->getJson("$this->endPoint/not_found");


        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_list_category_byId()
    {

        $category = Category::factory()->create();

        $response = $this->getJson("$this->endPoint/{$category->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(
            ['data' => [
                "id",
                "name",
                "description",
                "is_active",
                "created_at",
            ]]
        );
    }

    public function test_category_store()
    {
        $data = [];
        $response =  $this->postJson($this->endPoint, $data);

        $response->dump();

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(
            ['message',
                'errors'=> [
                "name"
            ]]
        );
    }
}




