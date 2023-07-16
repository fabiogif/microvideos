<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    public function test_delete(): void
    {
        $categoryDB = Category::factory()->create();

        $repository = new CategoryEloquentRepository(new Category());

        $useCase = new DeleteCategoryUseCase($repository);

        $useCase->execute(new CategoryInputDto(id: $categoryDB->id));

        $this->assertSoftDeleted($categoryDB);
    }
}
