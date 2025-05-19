<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Services\ServiceCustomers; // サービスを使う

    use App\Dtos\Customers\DtoCustomersList;
    use App\Dtos\Customers\DtoCustomersCount;
    use App\Dtos\Customers\DtoCustomersDelete;
    use App\Dtos\Customers\DtoCustomersEntry;
    use App\Dtos\Customers\DtoCustomersEdit;
    use App\Dtos\Customers\DtoCustomersGetCustomer;
    use App\Dtos\Customers\DtoCustomersGetCustomers;

    class ControllerCustomers extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceCustomers();
        }

        //一覧取得
        public function customerList(Request $request)
        {
            //file_put_contents("./debug_log.txt", "受け取りデータ:" . print_r($dto, true) . "\n");
            $dto = new DtoCustomersList($request->all());
            $dto->search_data->user_id = Session::get('user_id');
            $result = $this->service->customerList($dto);
            return response()->json($result);
        }
        //顧客件数取得
        public function customerCount(Request $request)
        {
            $dto = new DtoCustomersCount($request->all());
            $dto->search_data->user_id = Session::get("user_id");
            $result = $this->service->customerCount($dto);
            return response()->json($result);
        }
        //顧客削除
        public function customerDelete(Request $request)
        {
            $dto = new DtoCustomersDelete($request->all());
            file_put_contents("./debug_log.txt", "受け取りデータ:" . print_r($dto, true) . "\n");
            $dto->user_id = Session::get("user_id");
            $result = $this->service->customerDelete($dto);
            return response()->json($result);
        }
        //顧客登録
        public function customerEntry(Request $request)
        {
            $dto = new DtoCustomersEntry($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->customerEntry($dto);
            return response()->json($result);
        }
        //顧客編集
        public function customerEdit(Request $request)
        {
            $dto = new DtoCustomersEdit($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->customerEdit($dto);
            return response()->json($result);
        }
        //顧客IDの顧客取得
        public function getCustomer(Request $request)
        {
            $dto = new DtoCustomersGetCustomer($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->getCustomer($dto);
            return response()->json($result);
        }
        //顧客全取得
        public function getCustomers(Request $request)
        {
            $dto = new DtoCustomersGetCustomers($request->all());
            $dto->user_id = Session::get("user_id");
            $result = $this->service->getCustomers($dto);
            return response()->json($result);
        }
    }
?>
