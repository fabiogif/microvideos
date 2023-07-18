<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use App\Http\Requests\StoreUpdateCategoryRequest;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{



    protected $repository;

    protected $controller;

    protected function setUp():void
    {
        $this->repository = new CategoryEloquentRepository(new Category());
        $this->controller = new CategoryController();
        parent::setUp();
    }

    public function test_index(): void
    {
        $useCase = new ListCategoriesUseCase($this->repository);

        $reponse = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $reponse);
        $this->assertArrayHasKey('meta', $reponse->additional);
    }

    public function test_store()
    {
        $useCase = new CreateCategoryUseCase($this->repository);

        $request = new StoreUpdateCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Test'
        ]));

        $response = $this->controller->store($request, $useCase);
        dump($response);
        $this->assertInstanceOf(JsonResponse::class, $response);

       // $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

    }
}
