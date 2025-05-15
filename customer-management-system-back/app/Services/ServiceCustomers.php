<?php
    namespace App\Services;

    use App\Models\ModelCustomers;

    class ServiceCustomers
    {
        private $model;

        public function __construct()
        {
            $this->model = new ModelCustomers();
        }

        //一覧取得
        public function customerList($data)
        {
            $result = $this->model->customerList($data);
            return $result;
        }
        //顧客件数取得
        public function customerCount($data)
        {
            $result = $this->model->customerCount($data);
            return $result;
        }
        //顧客削除
        public function customerDelete($data)
        {
            $result = $this->model->customerDelete($data);
            return $result;
        }
        //顧客登録
        public function customerEntry($data)
        {
            $result = $this->model->validCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->customerEntry($data);
            return $result;
        }
        //顧客編集
        public function customerEdit($data)
        {
            $result = $this->model->validCheck($data);
            if($result["valid"] == false)
            {
                return $result;
            }
            $result = $this->model->customerEdit($data);
            return $result;
        }
        //顧客IDの顧客取得
        public function getCustomer($data)
        {
            $result = $this->model->getCustomer($data);
            return $result;
        }
        //顧客全取得
        public function getCustomers($data)
        {
            $result = $this->model->getCustomers($data);
            return $result;
        }
    }
?>