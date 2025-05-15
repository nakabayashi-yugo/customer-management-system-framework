<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceUsers;

    class ControllerUsers extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceUsers();
        }
        public function userLogin(Request $request)
        {
            $result = $this->service->userLogin($request->all());

            return response()->json($result);
        }

        public function userEntry(Request $request)
        {
            $result = $this->service->userEntry($request->all());

            return response()->json($result);
        }
    }
?>
