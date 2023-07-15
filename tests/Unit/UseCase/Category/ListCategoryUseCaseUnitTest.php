<?php

namespace Test\Unit\UseCase\Category;

use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\{CategoryInputDto, CategoryOutputDto};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = (string)Uuid::uuid4()->toString();
        $categoryName = 'Test Category';

        $mockEntity = Mockery::mock(CategoryEntity::class, [$id, $categoryName]);

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CategoryInputDto::class, [$id]);

        $useCase = new ListCategoryUseCase($mockRepo);

        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);

        $this->assertEquals('Test Category', $response->name);

        $this->assertEquals($id, $response->id);

    }

}
