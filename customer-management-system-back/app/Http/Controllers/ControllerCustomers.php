<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceCustomers; // サービスを使う

    class ControllerCustomers extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceCustomers();
        }
        //顧客ID一覧ゲット関数
        public function getCustomerIds(Request $request)
        {
            $result = $this->service->getCustomerIds($request->all());
            return response()->json($result);
        }
        //顧客テーブルに登録されている会社ID一覧ゲット関数
        public function getCustomerIncludedCompanyIds(Request $request)
        {
            $result = $this->service->getCustomerIncludedCompanyIds($request->all());
            return response()->json($result);
        }
        //引数によって渡された顧客IDが顧客テーブルに登録済みか返す関数
        //true: 登録済み
        //false: 登録されていない
        /**/
        public function isIdIncluded(Request $request)
        {
            $result = $this->service->isIdIncluded($request->all());
            return response()->json($result);
        }

        //一覧取得
        public function customerList(Request $request)
        {
            $result = $this->service->customerList($request->all());
            return response()->json($result);
        }
        //顧客件数取得
        public function customerCount(Request $request)
        {
            $result = $this->service->customerCount($request->all());
            return response()->json($result);
        }
        //顧客削除
        public function customerDelete(Request $request)
        {
            $result = $this->service->customerDelete($request->all());
            return response()->json($result);
        }
        //顧客登録
        public function customerEntry(Request $request)
        {
            $result = $this->service->customerEntry($request->all());
            return response()->json($result);
        }
        //顧客編集
        public function customerEdit(Request $request)
        {
            $result = $this->service->customerEdit($request->all());
            return response()->json($result);
        }
        //顧客IDの顧客取得
        public function getCustomer(Request $request)
        {
            $result = $this->service->getCustomer($request->all());
            return response()->json($result);
        }
        //顧客全取得
        public function getCustomers(Request $request)
        {
            $result = $this->service->getCustomers($request->all());
            return response()->json($result);
        }
    }
?>
