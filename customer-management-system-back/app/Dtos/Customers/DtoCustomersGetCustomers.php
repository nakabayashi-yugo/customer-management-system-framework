<?php
namespace App\Dtos\Customers;

class DtoCustomersGetCustomers
{
    public ?int $user_id;

    public function __construct(array $data)
    {
        $this->user_id = $data["user_id"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
        ];
    }
}
?>
