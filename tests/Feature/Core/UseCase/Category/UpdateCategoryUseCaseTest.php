<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as ModelCategory;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryUpdateInputDto;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_update(): void
    {
        $categoryDb = ModelCategory::factory()->create();

        $repository = new CategoryEloquentRepository(new ModelCategory());

        $useCase = new UpdateCategoryUseCase($repository);

        $response =  $useCase->execute(new CategoryUpdateInputDto(id: $categoryDb->id, name: 'Nova Cat'));

        $this->assertEquals('Nova Cat', $response->name);

        $this->assertDatabaseHas('categories', ['name' => $response->name]);

    }
}
