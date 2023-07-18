<?php

namespace Tests\Unit\App\http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategoriesOutputDto;
use Mockery;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CategoryControllerUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testeIndex(): void
    {

        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('test');

        $mockDtoOutput = Mockery::mock(ListCategoriesOutputDto::class, [[], 1,2,3,4,5,6]);

        $mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')->andReturn($mockDtoOutput);

        $categoryController = new CategoryController();
        $response = $categoryController->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta',  $response->additional);



        $mockUseCaseSky = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCaseSky->shouldReceive('execute')->andReturn($mockDtoOutput);

        $categoryController->index($mockRequest, $mockUseCaseSky);
        $mockUseCaseSky->shouldHaveReceived('execute');

        Mockery::close();

    }
}
