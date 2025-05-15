<?php
    namespace App\Services;

    use App\Models\ModelUsers;

    class ServiceUsers
    {
        private $model;

        public function __construct()
        {
            $this->model = new ModelUsers();
        }
         public function userLogin($data)
        {
            $result = $this->model->userLogin($data);
            return $result;
        }
        public function userEntry($data)
        {
            $result = $this->model->validCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->userEntry($data);
            return $result;
        }
    }
?>