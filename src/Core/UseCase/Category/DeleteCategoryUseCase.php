<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\{CategoryDeleteOutputDto,
    CategoryInputDto,
    CategoryUpdateInputDto,
    CategoryUpdateOutputDto};

class DeleteCategoryUseCase
{

    public function __construct(protected CategoryRepositoryInterface $repository)
    {
    }

    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $responseDelete = $this->repository->delete($input->id);

        return new CategoryDeleteOutputDto(
            success: $responseDelete
        );
    }
}
