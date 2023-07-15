<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as CategoryEntity;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Exception\NotFoundException;
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
}
