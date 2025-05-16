<?php
    namespace App\Dtos\Companies;
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
?>