<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\Interface\PaginationInterface;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{

    protected CategoryEloquentRepository $repository;

    protected function setUp():void
    {
        parent::setUp();
        $this->repository = new CategoryEloquentRepository(new Model());
    }


    public function testInsert(): void
    {
       $entity = new CategoryEntity(name: 'Test');

       $response = $this->repository->insert($entity);

       $this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
       $this->assertInstanceOf(CategoryEntity::class, $response);
       $this->assertDatabaseHas('categories', ['name' => $entity->name]);
    }

    public function testFindById()
    {
       $category =  Model::factory()->create();

       $response = $this->repository->findById($category->id);

       $this->assertEquals($category->id, $response->id());
       $this->assertInstanceOf(CategoryEntity::class, $response);
    }

    public function testFindByIdNotFound()
    {
        try{
            $this->repository->findById('notfound');
            $this->assertTrue(false);
        } catch (\Throwable $th)
        {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        $categories = Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertEquals(count($categories), count($response));

    }

    public function testPaginate()
    {
         Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithout()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateIdNotFound()
    {
        try{
            $category = new CategoryEntity(name: 'not_found');

            $this->repository->update($category);

            $this->assertTrue(false);
        } catch (\Throwable $th)
        {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }
    public function testUpdate()
    {
        $category =  Model::factory()->create();

        $entityCategory = new CategoryEntity(id: $category->id, name: 'Test news');

        $response = $this->repository->update($entityCategory);

        $this->assertEquals('Test news', $response->name);
        $this->assertInstanceOf(CategoryEntity::class, $response);

        $this->assertNotEquals($category->name, $response->name);

        $this->assertDatabaseHas('categories', ['name' => $entityCategory->name]);
    }

    public function testDeleteIdNotFound()
    {
        try{

            $this->repository->delete('not_found');

            $this->assertTrue(false);
        } catch (\Throwable $th)
        {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $category =  Model::factory()->create();

        $response = $this->repository->delete($category->id);

        $this->assertTrue($response);
    }
}
