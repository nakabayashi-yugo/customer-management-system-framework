<?php
namespace App\Dtos\Customers;

class DtoCustomersSort
{
    public ?string $sort_key = null;
    public ?string $sort_order = null;

    public function __construct(array $data = [])
    {
        $this->sort_key = $data["sort_key"] ?? null;
        $this->sort_order = $data["sort_order"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'sort_key' => $this->sort_key,
            'sort_order' => $this->sort_order,
        ];
    }
}
?>