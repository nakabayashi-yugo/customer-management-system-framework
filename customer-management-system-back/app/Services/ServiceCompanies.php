<?php
    namespace App\Services;

    use App\Models\ModelCompanies;

    class ServiceCompanies
    {
        private $model;

        public function __construct()
        {
            $this->model = new ModelCompanies();
        }
        //会社IDの会社取得
        public function getCompany($data)
        {
            $result = $this->model->getCompany($data);
            return $result;
        }
        
        //会社一覧取得
        public function companyList($data)
        {
            $result = $this->model->companyList($data);
            return $result;
        }
        //会社削除
        public function companyDelete($data)
        {
            $result = $this->model->deleteValidCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->companyDelete($data);
            return $result;
        }
        //会社登録
        public function companyEntry($data)
        {
            $result = $this->model->validCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->companyEntry($data);
            return $result;
        }
        //会社編集
        public function companyEdit($data)
        {
            $result = $this->model->validCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->companyEdit($data);
            return $result;
        }
    }
?>