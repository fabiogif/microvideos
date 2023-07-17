<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{

    private function createUseCase(): ListCategoriesOutputDto
    {
        $repository = new CategoryEloquentRepository(new ModelCategory());

        $useCase = new ListCategoriesUseCase($repository);

       return $useCase->execute(new ListCategoriesInputDto());
    }

    /**
     * A basic feature test list all Category empty.
     */
    public function test_list_all_empyt(): void
    {
        $response = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }


    /**
     *  feature test list all Category.
     */
    public function test_list_all(): void
    {
        $category = ModelCategory::factory()->count(20)->create();

        $response = $this->createUseCase();
        $this->assertCount(15, $response->items);
        $this->assertEquals(count($category), $response->total);

    }


}
