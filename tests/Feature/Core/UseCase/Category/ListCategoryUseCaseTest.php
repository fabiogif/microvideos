<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase
{


    public function test_list_by_category(): void
    {
        $categoryDb = ModelCategory::factory()->create();

        $repository = new CategoryEloquentRepository(new ModelCategory());

        $useCase = new ListCategoryUseCase($repository);

        $response =  $useCase->execute(new CategoryInputDto($categoryDb->id));

        $this->assertEquals($categoryDb->id, $response->id);
        $this->assertEquals($categoryDb->name, $response->name);
        $this->assertEquals($categoryDb->description, $response->description);



    }
}
