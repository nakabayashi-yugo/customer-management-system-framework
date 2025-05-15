<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceCompanies;

    class ControllerCompanies extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceCompanies();
        }
        //会社IDの会社取得
        public function getCompany(Request $request)
        {
            $result = $this->service->getCompany($request->all());
            return response()->json($result);
        }
        //会社ID全件取得
        public function getCompanyIds(Request $request)
        {
            $result = $this->service->getCompanyIds($request->all());
            return response()->json($result);
        }
        
        //会社一覧取得
        public function companyList(Request $request)
        {
            $result = $this->service->companyList($request->all());
            return response()->json($result);
        }
        //会社削除
        public function companyDelete(Request $request)
        {
            $result = $this->service->companyDelete($request->all());
            return response()->json($result);
        }
        //会社登録
        public function companyEntry(Request $request)
        {
            $result = $this->service->companyEntry($request->all());
            return response()->json($result);
        }
        //会社編集
        public function companyEdit(Request $request)
        {
            $result = $this->service->companyEdit($request->all());
            return response()->json($result);
        }
    }
?>
