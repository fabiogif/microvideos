<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{

    public function test_create(): void
    {
        $repository = new CategoryEloquentRepository(new Category());

        $useCase = new CreateCategoryUseCase($repository);

        $response = $useCase->execute(new CategoryCreateInputDto(
            name: 'test',
            description: 'test description'
        ));

        $this->assertEquals('test', $response->name);
        $this->assertNotEmpty($response->id);
        $this->assertDatabaseHas('categories', [
            'name' => 'test',
            'description' => 'test description'
        ]);
    }
}
