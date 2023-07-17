<?php

namespace App\Repositories\Presenters;

use Core\Domain\Repository\Interface\PaginationInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use StdClass;

class PaginationPresenter implements PaginationInterface
{

    protected array $items = array();
    public function __construct(protected LengthAwarePaginator $paginator)
    {
       $this->items =  $this->resolveItem(items: $this->paginator->items());
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return  $this->paginator->total() ?? 0;
    }

    public function lastPage(): int
    {
       return $this->paginator->lastPage() ?? 0;
    }

    public function firstPage(): int
    {
       return $this->paginator->onFirstPage() ?? 0;
    }

    public function currentPage(): int
    {
        return $this->paginator->currentPage() ?? 0;
    }

    public function perPage(): int
    {
        return $this->paginator->perPage() ?? 0;
    }

    public function to(): int
    {
       return $this->paginator->firstItem() ?? 0;
    }

    public function from(): int
    {
       return $this->paginator->lastItem() ?? 0;
    }

    private function resolveItem(array $items): array
    {
        $response = array();

        foreach ($items as $item) {
            $stdClass = new stdClass();
            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }

           // $response[] = $stdClass;
            array_push($response, $stdClass);

        }
        return $response;
    }
}
