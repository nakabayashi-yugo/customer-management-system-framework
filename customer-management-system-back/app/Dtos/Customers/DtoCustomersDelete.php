<?php
    namespace App\Dtos\Customers;
    class DtoCustomersDelete
    {
        public int $user_id;
        public int $cust_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->cust_id = $data["cust_id"];
        }
    }
?>