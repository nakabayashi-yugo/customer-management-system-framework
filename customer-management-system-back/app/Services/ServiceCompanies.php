<?php
namespace App\Services;

use App\Models\ModelCompanies;
use App\Dtos\Companies\DtoCompaniesGetCompany;
use App\Dtos\Companies\DtoCompaniesList;
use App\Dtos\Companies\DtoCompaniesDelete;
use App\Dtos\Companies\DtoCompaniesEntry;
use App\Dtos\Companies\DtoCompaniesEdit;

class ServiceCompanies
{
    private $model;

    public function __construct()
    {
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
        $result = $this->model->deleteValidCheck($dto);
        if ($result["valid"] == false) {
            return $result;
        }
        return $this->model->companyDelete($dto);
    }

    // 会社登録
    public function companyEntry(DtoCompaniesEntry $dto)
    {
        $result = $this->model->validCheck($dto);
        if ($result["valid"] == false) {
            return $result;
        }
        return $this->model->companyEntry($dto);
    }

    // 会社編集
    public function companyEdit(DtoCompaniesEdit $dto)
    {
        $result = $this->model->validCheck($dto);
        if ($result["valid"] == false) {
            return $result;
        }
        return $this->model->companyEdit($dto);
    }
}
?>
