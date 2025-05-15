<?php
    namespace App\Dto;
    class DtoUsersLogin
    {
        public string $user_name;
        public string $passwd;

        public function __construct(array $data)
        {
            $this->user_name = $data["user_name"];
            $this->passwd = $data["passwd"];
        }
    }
    
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