<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\Interface\PaginationInterface;
use App\Models\Category as CategoryModel;


class CategoryEloquentRepository implements CategoryRepositoryInterface
{

    public function __construct(protected CategoryModel $model)
    {
    }

    public function insert(Category $category): Category
    {
       $category = $this->model->create([
           'id' => $category->id(),
           'name' => $category->name,
           'description' => $category->description,
           'is_active' => $category->isActive,
           'created_at' => $category->createdAt()
       ]);

       return $this->toCategory($category);
    }

    public function findById(string $categoryId): Category
    {
        $category =  $this->model->find($categoryId);

        if(!$category)
        {
            throw new NotFoundException('Category not found');
        }
        return $this->toCategory($category);
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
      $categories = $this->model->where(function ($query) use ($filter){
          if($filter)
          $query->where('name', 'LIKE', '%'.$filter.'%');
      })->orderBy('id', $order)->get();

      return $categories->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        $query = $this->model;
            if($filter)
            $query->where('name', 'LIKE', '%'.$filter.'%');

        $paginator = $query->orderBy('id', $order)->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($paginator);
    }

    public function update(Category $category): Category
    {

        $categoryDb =  $this->model->find($category->id);

        if(!$categoryDb)
        {
            throw new NotFoundException('Category Not found');
        }

        $categoryDb->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
        ]);

        $categoryDb->refresh();

       return $this->toCategory($categoryDb);
    }

    public function delete(string $categoryId): bool
    {
        $categoryDb =  $this->model->find($categoryId);

        if(!$categoryDb)
        {
            throw new NotFoundException('Category Not found');
        }
        return $categoryDb->delete();
    }

    public function toCategory(object $object): Category
    {
        $entity = new Category(
            id: $object->id,
            name: $object->name,
            description: $object->description,
        );

        $object->is_active ? $entity->activate() : $entity->disable();

        return  $entity;
    }

}
