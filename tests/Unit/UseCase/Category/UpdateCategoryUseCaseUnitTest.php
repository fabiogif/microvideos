<?php

namespace Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\{CategoryUpdateInputDto, CategoryUpdateOutputDto};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
      public function testRenameCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Name';
        $categoryDesc = 'Desc';

        $mockEntity = Mockery::mock(Category::class, [$uuid, $categoryName, $categoryDesc]);

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockEntity->shouldReceive('update');


        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('update')->andReturn($mockEntity);


        $mockInputDto = Mockery::mock(CategoryUpdateInputDto::class, [$uuid, 'Novo Nome','Nova Desc']);

        $useCase = new UpdateCategoryUseCase($mockRepo);

        $responseUseCase =  $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryUpdateOutputDto::class , $responseUseCase);

    }
}
