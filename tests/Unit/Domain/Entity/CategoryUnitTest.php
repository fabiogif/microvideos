<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(name: 'Categoria', description: 'nova descricao', isActive: true);

        $this->assertNotEmpty($category->createdAt());
        $this->assertNotEmpty($category->id());
        $this->assertEquals('Categoria', $category->name);
        $this->assertEquals('nova descricao', $category->description);
        $this->assertEquals(true, $category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(name: 'new categoria', isActive: false);

        $this->assertFalse($category->isActive);

        $category->activate();

        $this->assertTrue($category->isActive);
    }


    public function testUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $category = new Category(id: $uuid, name: 'Categoria', isActive: true, createdAt: '2023-01-01 12:12:12');

        $category->update(name: 'new categoria', description: 'new dec');

        $this->assertEquals('new categoria', $category->name);
        $this->assertEquals('new dec', $category->description);
    }

    public function testExceptionName()
    {
        try {
            new Category(name: 'F', description: 'new Desc');
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
    public function testExceptionDescription()
    {
        try {
            new Category(name: 'F', description: random_bytes(99999999));
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
