<?php
    namespace App\Dtos\Companies;
    class DtoCompaniesList
    {
        public int $user_id;

        public function __construct(array $data)
        {
            $this->user_id = $data["user_id"];
        }
    }
?>