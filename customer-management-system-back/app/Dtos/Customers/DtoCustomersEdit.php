<?php
    namespace App\Dtos\Customers;
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
?>