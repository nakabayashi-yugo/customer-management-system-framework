<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceCompanies;

    use App\Dto\DtoCompaniesGetCompany;
    use App\Dto\DtoCompaniesList;
    use App\Dto\DtoCompaniesDelete;
    use App\Dto\DtoCompaniesEntry;
    use App\Dto\DtoCompaniesEdit;

    class ControllerCompanies extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceCompanies();
        }
        //会社IDの会社取得
        public function getCompany(Request $request)
        {
            $dto = new DtoCompaniesGetCompany($request->all());
            $result = $this->service->getCompany(get_object_vars($dto));
            return response()->json($result);
        }
        
        //会社一覧取得
        public function companyList(Request $request)
        {
            $dto = new DtoCompaniesList($request->all());
            $result = $this->service->companyList(get_object_vars($dto));
            return response()->json($result);
        }
        //会社削除
        public function companyDelete(Request $request)
        {
            $dto = new DtoCompaniesDelete($request->all());
            $result = $this->service->companyDelete(get_object_vars($dto));
            return response()->json($result);
        }
        //会社登録
        public function companyEntry(Request $request)
        {
            $dto = new DtoCompaniesEntry($request->all());
            $result = $this->service->companyEntry(get_object_vars($dto));
            return response()->json($result);
        }
        //会社編集
        public function companyEdit(Request $request)
        {
            $dto = new DtoCompaniesEdit($request->all());
            $result = $this->service->companyEdit(get_object_vars($dto));
            return response()->json($result);
        }
    }
?>
