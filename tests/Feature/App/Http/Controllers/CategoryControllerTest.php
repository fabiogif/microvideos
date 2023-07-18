<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{



    protected $repository;

    protected function setUp():void
    {
        $this->repository = new CategoryEloquentRepository(new Category());
        parent::setUp();
    }

    public function test_index(): void
    {
        $useCase = new ListCategoriesUseCase($this->repository);

        $controller = new CategoryController();
        $reponse = $controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $reponse);
        $this->assertArrayHasKey('meta', $reponse->additional);
    }
}
