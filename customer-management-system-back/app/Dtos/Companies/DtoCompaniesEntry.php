<?php
    namespace App\Dtos\Companies;
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
?>