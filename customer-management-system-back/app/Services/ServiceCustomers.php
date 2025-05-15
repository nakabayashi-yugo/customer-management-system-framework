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
        //顧客ID一覧ゲット関数
        public function getCustomerIds($data)
        {
            $result = $this->model->getCustomerIds($data);
            return $result;
        }
        //顧客テーブルに登録されている会社ID一覧ゲット関数
        public function getCustomerIncludedCompanyIds($data)
        {
            $result = $this->model->getCustomerIncludedCompanyIds($data);
            return $result;
        }
        //引数によって渡された顧客IDが顧客テーブルに登録済みか返す関数
        //true: 登録済み
        //false: 登録されていない
        /**/
        public function isIdIncluded($data)
        {
            $result = $this->model->isIdIncluded($data);
            return $result;
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