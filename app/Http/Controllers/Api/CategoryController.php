<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\ListCategoriesInputDto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function index(Request $request, ListCategoriesUseCase $categoriesUseCase)
    {
        $response = $categoriesUseCase->execute(input: new ListCategoriesInputDto(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            page:  (int)$request->get('page', 1),
            totalPage: (int)$request->get('totalPage', 15),
        ));

        return CategoryResource::collection(collect($response->items))
            ->additional(['meta' => [
                'total' => $response->total ,
                'last_page' => $response->last_page,
                'first_page' => $response->first_page,
                'per_page' => $response->per_page,
                'to' => $response->to,
                'from'=> $response->from
            ]]);
    }


    public function store(StoreUpdateCategoryRequest $request, CreateCategoryUseCase $useCaseCategory)
    {
        $response = $useCaseCategory->execute(
          input: new CategoryCreateInputDto(
              name: $request->name,
              description: $request->description ?? '',
              isActive: (bool)$request->is_active ?? true,
            )
        );
        return (new CategoryResource(collect($response)))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
