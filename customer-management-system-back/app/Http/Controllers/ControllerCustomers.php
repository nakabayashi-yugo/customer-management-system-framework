<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceCustomers; // サービスを使う

    use App\Dto\DtoCustomersList;
    use App\Dto\DtoCustomersCount;
    use App\Dto\DtoCustomersDelete;
    use App\Dto\DtoCustomersEntry;
    use App\Dto\DtoCustomersEdit;
    use App\Dto\DtoCustomersGetCustomer;
    use App\Dto\DtoCustomersGetCustomers;

    class ControllerCustomers extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceCustomers();
        }

        //一覧取得
        public function customerList(Request $request)
        {
            $dto = new DtoCustomersList($request->all());
            $result = $this->service->customerList(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客件数取得
        public function customerCount(Request $request)
        {
            $dto = new DtoCustomersCount($request->all());
            $result = $this->service->customerCount(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客削除
        public function customerDelete(Request $request)
        {
            $dto = new DtoCustomersDelete($request->all());
            $result = $this->service->customerDelete(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客登録
        public function customerEntry(Request $request)
        {
            $dto = new DtoCustomersEntry($request->all());
            $result = $this->service->customerEntry(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客編集
        public function customerEdit(Request $request)
        {
            $dto = new DtoCustomersEdit($request->all());
            $result = $this->service->customerEdit(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客IDの顧客取得
        public function getCustomer(Request $request)
        {
            $dto = new DtoCustomersGetCustomer($request->all());
            $result = $this->service->getCustomer(get_object_vars($dto));
            return response()->json($result);
        }
        //顧客全取得
        public function getCustomers(Request $request)
        {
            $dto = new DtoCustomersGetCustomers($request->all());
            $result = $this->service->getCustomers(get_object_vars($dto));
            return response()->json($result);
        }
    }
?>
