<?php
namespace App\Dtos\Customers;

class DtoCustomersSort
{
    public ?string $sort_key;
    public ?string $sort_order;

    public function __construct(array $data = [])
    {
        $this->sort_key = $data["sort_key"] ?? null;
        $this->sort_order = $data["sort_order"] ?? null;
    }
}
?>
