<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;


abstract class ModelTestCase extends TestCase
{

    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function cats(): array;


    public function testIfUseTraits(): void
    {
        $traitsNeed = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeed, $traitsUsed);

        $this->assertTrue(true);
    }

    public function testImplementsIsFalse()
    {
        $model = $this->model();

        $this->assertFalse($model->incrementing);
    }

    public  function testHasCasts()
    {
        $castsNeed = $this->cats();

        $cast = $this->model()->getCasts();

        $this->assertEquals($castsNeed, $cast);

    }

    public function testFillables()
    {
        $expected = $this->fillables();

        $fillable = $this->model()->getFillable();

        $this->assertEquals($expected, $fillable);
    }



}
