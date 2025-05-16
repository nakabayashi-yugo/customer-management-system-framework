<?php
    namespace App\Dtos\Customers;
    class DtoCustomersGetCustomers
    {
        public int $user_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
        }
    }
?>