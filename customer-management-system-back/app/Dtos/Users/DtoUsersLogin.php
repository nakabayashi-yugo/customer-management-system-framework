<?php
    namespace App\Dtos\Users;
    class DtoUsersLogin
    {
        public ?string $user_name;
        public ?string $passwd;

        public function __construct(array $data)
        {
            $this->user_name = $data["user_name"] ?? null;
            $this->passwd = $data["passwd"] ?? null;
        }

        public function toArray(): array
        {
            return [
                "user_name" => $this->user_name,
                "passwd" => $this->passwd,
            ];
        }
    }
?>