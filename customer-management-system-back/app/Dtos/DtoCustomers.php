<?php
    namespace App\Dto;
    class DtoCustomersSearch
    {
        public int $user_id;
        public string $cust_name;
        public string $cust_name_kana;
        public string $sex;
        public int $company_id;
        public string $born_year;
        public string $born_month;
        public string $born_date;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->cust_name = $data["cust_name"];
            $this->cust_name_kana = $data["cust_name_kana"];
            $this->sex = $data["sex"];
            $this->company_id = $data["company_id"];
            $this->born_year = $data["born_year"];
            $this->born_month = $data["born_month"];
            $this->born_date = $data["born_date"];
        }
    }
    class DtoCustomersSort
    {
        public string $sort_key;
        public string $sort_order;

        public function __construct(array $data)
        {
            $this->sort_key = $data["sort_key"];
            $this->sort_order = $data["sort_order"];
        }
    }
    class DtoCustomersList
    {
        public DtoCustomersSearch $search_data;
        public DtoCustomersSort $sort_data;
        public int $disp_num;
        public int $page_id;
        public function __construct(array $data)
        {
            $this->search_data = new DtoCustomersSearch($data["search_data"]);
            $this->sort_data = new DtoCustomersSort($data["sort_data"]);
            $this->disp_num = $data["disp_num"];
            $this->page_id = $data["page_id"];
        }
    }

    class DtoCustomersCount
    {
        public DtoCustomersSearch $search_data;

        public function __construct(array $data)
        {
            $this->search_data = new DtoCustomersSearch($data["search_data"]);
        }
    }
    
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
    
    class DtoCustomersEntry
    {
        public int $user_id;
        public string $cust_name;
        public string $cust_name_kana;
        public string $mail_address;
        public string $phone_number;
        public string $sex;
        public int $company_id;
        public string $born_date;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->cust_name = $data["cust_name"];
            $this->cust_name_kana = $data["cust_name_kana"];
            $this->mail_address = $data["mail_address"];
            $this->phone_number = $data["phone_number"];
            $this->sex = $data["sex"];
            $this->company_id = $data["company_id"];
            $this->born_date = $data["born_date"];
        }
    }
    
    class DtoCustomersEdit
    {
        public int $user_id;
        public string $cust_name;
        public string $cust_name_kana;
        public string $mail_address;
        public string $phone_number;
        public string $sex;
        public int $company_id;
        public string $born_date;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->cust_name = $data["cust_name"];
            $this->cust_name_kana = $data["cust_name_kana"];
            $this->mail_address = $data["mail_address"];
            $this->phone_number = $data["phone_number"];
            $this->sex = $data["sex"];
            $this->company_id = $data["company_id"];
            $this->born_date = $data["born_date"];
        }
    }
    
    class DtoCustomersGetCustomer
    {
        public int $user_id;
        public int $cust_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->cust_id = $data["cust_id"];
        }
    }
    
    class DtoCustomersGetCustomers
    {
        public int $user_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
        }
    }
?>
    