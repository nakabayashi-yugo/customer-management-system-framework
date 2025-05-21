<?php
    namespace App\Services;

    use App\Models\ModelUsers;
    use App\Services\ServiceBase;
    use App\Error\ErrorCode;

    class ServiceUsers extends ServiceBase
    {
        private $model;

        public function __construct()
        {
            parent::__construct();
            $this->model = new ModelUsers();
        }
         public function userLogin($data)
        {
            $result = $this->model->userLogin($data);
            $this->addErrorCode($result["code"]);
            return $result;
        }
        public function userEntry($data)
        {
            $result = $this->model->validCheck($data);
            if(!empty($result))
            {
                $this->addErrorCodes($result);
                return;
            }
            $result = $this->model->userEntry($data);
            $this->addErrorCode($result["code"]);
            return $result;
        }
    }
?>