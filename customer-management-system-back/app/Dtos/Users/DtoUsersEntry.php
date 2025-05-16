<?php
    namespace App\Dtos\Users;
    
    class DtoUsersEntry
    {
        public string $user_name;
        public string $passwd;

        public function __construct(array $data)
        {
            $this->user_name = $data["user_name"];
            $this->passwd = $data["passwd"];
        }
    }
?>