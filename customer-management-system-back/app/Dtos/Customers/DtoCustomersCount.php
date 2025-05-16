<?php
    namespace App\Dtos\Customers;
    class DtoCustomersCount
    {
        public DtoCustomersSearch $search_data;

        public function __construct(array $data)
        {
            $this->search_data = new DtoCustomersSearch($data["search_data"]);
        }
    }
?>