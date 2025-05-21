<?php
namespace App\Services;

use App\Models\ModelCustomers;
use App\Services\ServiceBase;
use App\Dtos\Customers\DtoCustomersList;
use App\Dtos\Customers\DtoCustomersCount;
use App\Dtos\Customers\DtoCustomersDelete;
use App\Dtos\Customers\DtoCustomersEntry;
use App\Dtos\Customers\DtoCustomersEdit;
use App\Dtos\Customers\DtoCustomersGetCustomer;
use App\Dtos\Customers\DtoCustomersGetCustomers;

class ServiceCustomers extends ServiceBase
{
    private $model;

    public function __construct()
    {
        parent::__construct();
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
        $errors = $this->model->deleteValidCheck($dto);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->customerDelete($dto);
        $this->addErrorCode($result['code']);
        return $result;
    }

    // 顧客登録
    public function customerEntry(DtoCustomersEntry $dto)
    {
        $errors = $this->model->validCheck($dto);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->customerEntry($dto);
        $this->addErrorCode($result['code']);
        return $result;
    }

    // 顧客編集
    public function customerEdit(DtoCustomersEdit $dto)
    {
        $errors = $this->model->validCheck($dto, true);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->customerEdit($dto);
        $this->addErrorCode($result['code']);
        return $result;
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
