<?php
namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;

class ListCategoryUseCase {

    public function __construct(protected CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    } 

    public function execute(CategoryInputDto $items): CategoryOutputDto
    {

         $category = $this->repository->findById($items);

         return new CategoryOutputDto(
            id: $category->id,
            name: $category->name,
            description: $category->description,
            is_active: $category->isActive
         );


    }

}