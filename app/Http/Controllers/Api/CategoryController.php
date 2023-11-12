<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Core\UseCase\Category\{
    CreateCategoryUseCase,
    DeleteCategoryUseCase,
    ListCategoriesUseCase,
    ListCategoryUseCase,
    UpdateCategoryUseCase
};
use Core\UseCase\DTO\Category\{
    CategoryCreateInputDto,
    CategoryInputDto,
    CategoryUpdateInputDto,
    ListCategoriesInputDto
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psy\Util\Json;

class CategoryController extends Controller
{

    public function index(Request $request, ListCategoriesUseCase $useCase)
    {
        $response = $useCase->execute(input: new ListCategoriesInputDto(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            page: (int)$request->get('page', 1),
            totalPage: (int)$request->get('totalPage', 15),
        ));


        return CategoryResource::collection(collect($response->items))
            ->additional(['meta' => [
                'total' => $response->total,
                'current_page' => $response->current_page,
                'last_page' => $response->last_page,
                'first_page' => $response->first_page,
                'per_page' => $response->per_page,
                'to' => $response->to,
                'from' => $response->from
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
        return (new CategoryResource($response))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListCategoryUseCase $useCase, $id): JsonResponse
    {
        $category = $useCase->execute(new CategoryInputDto($id));
        return (new CategoryResource($category))->response();
    }

    public function update(StoreUpdateCategoryRequest $request, UpdateCategoryUseCase $useCase, $id): JsonResponse
    {
        $response = $useCase->execute(
            input: new CategoryUpdateInputDto(
                id: $id,
                name: $request->name
            )
        );

        return (new CategoryResource($response))->response();
    }

    public function destroy(DeleteCategoryUseCase $useCase, $id)
    {
        $useCase->execute(
            input: new CategoryInputDto(
                id: $id
            )
        );
        return response()->noContent();
    }
}
