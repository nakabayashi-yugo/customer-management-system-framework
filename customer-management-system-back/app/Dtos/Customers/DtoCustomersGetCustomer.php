<?php
namespace App\Dtos\Customers;

class DtoCustomersGetCustomer
{
    public ?int $user_id;
    public ?int $cust_id;

    public function __construct(array $data)
    {
        $this->user_id = $data["user_id"] ?? null;
        $this->cust_id = $data["cust_id"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'cust_id' => $this->cust_id,
        ];
    }
}
?>
