<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Services\ServiceUsers;
    
    use App\Dtos\Users\DtoUsersLogin;
    use App\Dtos\Users\DtoUsersEntry;

    class ControllerUsers extends Controller
    {
        public function __construct()
        {
            $this->service = new ServiceUsers();
        }
        public function userLogin(Request $request)
        {
            //dto生成
            $dto = new DtoUsersLogin($request->all());
            $result = $this->service->userLogin($dto);
            
            if ($this->service->hasErrors()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $this->service->getErrorCodes(),
                ], $this->service->getHttpStatus());
            }

            return response()->json([
                'success' => true,
                'data'    => $result,
            ]);
        }

        public function userEntry(Request $request)
        {
            $dto = new DtoUsersEntry($request->all());
            $result = $this->service->userEntry($dto);

            if ($this->service->hasErrors()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $this->service->getErrorCodes(),
                ], $this->service->getHttpStatus());
            }

            return response()->json([
                'success' => true,
                'data'    => $result,
            ]);
        }
    }
?>
