<?php
namespace App\Services;

use App\Models\ModelCustomers;
use App\Dtos\Customers\DtoCustomersList;
use App\Dtos\Customers\DtoCustomersCount;
use App\Dtos\Customers\DtoCustomersDelete;
use App\Dtos\Customers\DtoCustomersEntry;
use App\Dtos\Customers\DtoCustomersEdit;
use App\Dtos\Customers\DtoCustomersGetCustomer;
use App\Dtos\Customers\DtoCustomersGetCustomers;

class ServiceCustomers
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelCustomers();
    }

    // 一覧取得
    public function customerList(DtoCustomersList $dto)
    {
        return $this->model->customerList($dto);
    }

    // 顧客件数取得
    public function customerCount(DtoCustomersCount $dto)
    {
        return $this->model->customerCount($dto);
    }

    // 顧客削除
    public function customerDelete(DtoCustomersDelete $dto)
    {
        return $this->model->customerDelete($dto);
    }

    // 顧客登録
    public function customerEntry(DtoCustomersEntry $dto)
    {
        $result = $this->model->validCheck($dto);
        if ($result["valid"] == false) {
            return $result;
        }
        return $this->model->customerEntry($dto);
    }

    // 顧客編集
    public function customerEdit(DtoCustomersEdit $dto)
    {
        $result = $this->model->validCheck($dto);
        if ($result["valid"] == false) {
            return $result;
        }
        return $this->model->customerEdit($dto);
    }

    // 顧客IDの顧客取得
    public function getCustomer(DtoCustomersGetCustomer $dto)
    {
        return $this->model->getCustomer($dto);
    }

    // 顧客全取得
    public function getCustomers(DtoCustomersGetCustomers $dto)
    {
        return $this->model->getCustomers($dto);
    }
}
?>
