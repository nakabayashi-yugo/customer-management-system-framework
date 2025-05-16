<?php
    namespace App\Dtos\Customers;
    class DtoCustomersSearch
    {
        public ?int $user_id = null;
        public ?string $cust_name = null;
        public ?string $cust_name_kana = null;
        public ?string $sex = null;
        public ?int $company_id = null;
        public ?string $born_year = null;
        public ?string $born_month = null;
        public ?string $born_date = null;


        public function __construct(array $data = [])
        {
            $this->user_id = $data["user_id"] ?? null;
            $this->cust_name = $data["cust_name"] ?? null;
            $this->cust_name_kana = $data["cust_name_kana"] ?? null;
            $this->sex = $data["sex"] ?? null;
            $this->company_id = $data["company_id"] ?? null;
            $this->born_year = $data["born_year"] ?? null;
            $this->born_month = $data["born_month"] ?? null;
            $this->born_date = $data["born_date"] ?? null;
        }

    }
?>