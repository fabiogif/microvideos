<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Genre;

use Core\Domain\Entity\ValueObject\Uuid;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Ramsey\Uuid\Uuid as RamseyUuid;
use PHPUnit\Framework\TestCase;
use DateTime;

class GenreUnitTest extends TestCase
{
    public function testAttributes(): void
    {
      $uuid = (string) RamseyUuid::uuid4();
      $date =  new DateTime(date('Y-m-d H:i:s'));

      $genre = new Genre(
          id: new Uuid($uuid),
          name: 'New Genre',
          isActive: true,
          createdAt: $date,
      );

        $this->assertEquals($uuid, $genre->id());
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(true, $genre->isActive);
        $this->assertEquals($date, $genre->createdAt);
    }

    public function testAttributesCreate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertNotEmpty($genre->id());
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(true, $genre->isActive);
    }

    public function testeDesactivate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertTrue($genre->isActive);

        $genre->deactivate();

        $this->assertFalse($genre->isActive);

    }

    public function testeActivate()
    {
        $genre = new Genre(
            name: 'New Genre',
            isActive: false
        );

        $this->assertFalse($genre->isActive);

        $genre->activate();

        $this->assertTrue($genre->isActive);

    }


    public function testUpdate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertEquals('New Genre', $genre->name);

        $genre->update(name: 'New Updated');

        $this->assertEquals('New Updated', $genre->name);

    }

    public function testEntityException()
    {
        $this->expectException(EntityValidationException::class);

        $genre = new Genre(
            name: 'F',
        );
    }

    public function testEntityUpdateException()
    {
        $this->expectException(EntityValidationException::class);

        $uuid = (string) RamseyUuid::uuid4();
        $date =  new DateTime(date('Y-m-d H:i:s'));

        $genre = new Genre(
            id: new Uuid($uuid),
            name: 'New Genre',
            isActive: true,
            createdAt: $date,
        );
        $genre->update(name : 'F');
    }

    public function testAddCategoryToGenre()
    {
        $categoryId = (string) RamseyUuid::uuid4();

        $genre = new Genre(name: 'new genre');

        $this->assertIsArray($genre->categoriesId);

        $this->assertCount(0, $genre->categoriesId);

        $genre->addCategory(categoryId: $categoryId);
        $genre->addCategory(categoryId: $categoryId);
        $genre->addCategory(categoryId: $categoryId);


        $this->assertCount(3, $genre->categoriesId);
  }
    public function testRemoveCategoryToGenre()
    {
        $categoryId = (string) RamseyUuid::uuid4();
        $categoryIdD = (string) RamseyUuid::uuid4();

        $genre = new Genre(name: 'new genre', categoriesId: [$categoryId, $categoryIdD]);

        $this->assertCount(2, $genre->categoriesId);

        $genre->removeCategory(categoryId: $categoryId);

        $this->assertCount(1, $genre->categoriesId);


    }
}
