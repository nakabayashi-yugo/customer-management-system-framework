<?php
namespace App\Services;

use App\Services\ServiceBase;
use App\Models\ModelCompanies;
use App\Dtos\Companies\DtoCompaniesGetCompany;
use App\Dtos\Companies\DtoCompaniesList;
use App\Dtos\Companies\DtoCompaniesDelete;
use App\Dtos\Companies\DtoCompaniesEntry;
use App\Dtos\Companies\DtoCompaniesEdit;

class ServiceCompanies extends ServiceBase
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ModelCompanies();
    }

    // 会社IDの会社取得
    public function getCompany(DtoCompaniesGetCompany $dto)
    {
        return $this->model->getCompany($dto);
    }

    // 会社一覧取得
    public function companyList(DtoCompaniesList $dto)
    {
        return $this->model->companyList($dto);
    }

    // 会社削除
    public function companyDelete(DtoCompaniesDelete $dto)
    {
        $errors = $this->model->deleteValidCheck($dto);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->companyDelete($dto);
        $this->addErrorCode($result['code']);
        return $result;
    }

    // 会社登録
    public function companyEntry(DtoCompaniesEntry $dto)
    {
        $errors = $this->model->validCheck($dto);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->companyEntry($dto);
        $this->addErrorCode($result['code']);
        return $result;
    }

    // 会社編集
    public function companyEdit(DtoCompaniesEdit $dto)
    {
        $errors = $this->model->validCheck($dto);
        if (!empty($errors)) {
            $this->addErrorCodes($errors);
            return;
        }

        $result = $this->model->companyEdit($dto);
        $this->addErrorCode($result['code']);
        return $result;
    }
}
?>