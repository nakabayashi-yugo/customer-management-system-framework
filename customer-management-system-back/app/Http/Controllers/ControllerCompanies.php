<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Services\ServiceCompanies;

    use App\Dtos\Companies\DtoCompaniesGetCompany;
    use App\Dtos\Companies\DtoCompaniesList;
    use App\Dtos\Companies\DtoCompaniesDelete;
    use App\Dtos\Companies\DtoCompaniesEntry;
    use App\Dtos\Companies\DtoCompaniesEdit;

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
            $dto->user_id = Session::get("user_id");
            $result = $this->service->getCompany($dto);
            return response()->json($result);
        }
        
        //会社一覧取得
        public function companyList(Request $request)
        {
            $dto = new DtoCompaniesList($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->companyList($dto);
            return response()->json($result);
        }
        //会社削除
        public function companyDelete(Request $request)
        {
            $dto = new DtoCompaniesDelete($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->companyDelete($dto);
            return response()->json($result);
        }
        //会社登録
        public function companyEntry(Request $request)
        {
            $dto = new DtoCompaniesEntry($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->companyEntry($dto);
            return response()->json($result);
        }
        //会社編集
        public function companyEdit(Request $request)
        {
            $dto = new DtoCompaniesEdit($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->companyEdit($dto);
            return response()->json($result);
        }
    }
?>
