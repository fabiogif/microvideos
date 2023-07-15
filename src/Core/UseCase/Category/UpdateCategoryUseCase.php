<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{
    CategoryUpdateInputDto,
    CategoryUpdateOutputDto};

class UpdateCategoryUseCase
{

    public function __construct(protected CategoryRepositoryInterface $repository)
    {
    }

    public function execute(CategoryUpdateInputDto $input): CategoryUpdateOutputDto
    {
        $category = $this->repository->findById($input->id);

        $category->update(
            name: $input->name,
            description: $input->description ?? $category->description,
        );

        $categoryUpdate = $this->repository->update($category);

        return new CategoryUpdateOutputDto(
            id: $categoryUpdate->id,
            name: $categoryUpdate->name,
            description: $categoryUpdate->description,
            is_active: $categoryUpdate->isActive
        );
    }
}
