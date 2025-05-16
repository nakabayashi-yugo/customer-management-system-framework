<?php
    namespace App\Dto;
    class DtoCompaniesGetCompany
    {
        public int $user_id;
        public int $company_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->company_id = $data["company_id"];
        }
    }
    
    class DtoCompaniesList
    {
        public int $user_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
        }
    }
    
    class DtoCompaniesDelete
    {
        public int $user_id;
        public int $company_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->company_id = $data["company_id"];
        }
    }
    
    class DtoCompaniesEntry
    {
        public int $user_id;
        public string $company_name;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->company_name = $data["company_name"];
        }
    }
    
    class DtoCompaniesEdit
    {
        public int $user_id;
        public string $company_name;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
            $this->company_name = $data["company_name"];
        }
    }