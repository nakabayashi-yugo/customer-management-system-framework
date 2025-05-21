<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDOException;
use Exception;
use App\Dtos\Users\DtoUsersLogin;
use App\Dtos\Users\DtoUsersEntry;
use App\Error\ErrorCode;
use App\Error\HttpStatus;

class ModelUsers extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = ['user_name', 'passwd'];

    private function wrapDto($data, $class)
    {
        return $data instanceof $class ? $data : new $class($data);
    }

    // ログイン処理
    public function userLogin($dto): array
    {
        $dto = $this->wrapDto($dto, DtoUsersLogin::class);

        try {
            $user = $this->where("user_name", $dto->user_name)->first();

            if (!$user) {
                return [
                    'status' => HttpStatus::HTTP_BAD_REQUEST,
                    'code'   => ErrorCode::ERR_USER_NAME_NOT_FOUND,
                ];
            }

            if (password_verify($dto->passwd, $user->passwd) || $dto->passwd == $user->passwd) {
                Session::put("user_id", $user->user_id);
                Session::save();

                return [
                    'status' => HttpStatus::HTTP_OK,
                    'code'   => ErrorCode::SUCCESS,
                ];
            }

            return [
                'status' => HttpStatus::HTTP_BAD_REQUEST,
                'code'   => ErrorCode::ERR_PASSWD_MISMATCH,
            ];
        } catch (PDOException $e) {
            return [
                'status' => HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                'code'   => ErrorCode::ERR_SQL,
            ];
        } catch (Exception $e) {
            return [
                'status' => HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                'code'   => ErrorCode::ERR_UNKNOWN,
            ];
        }
    }

    // ユーザー登録処理
    public function userEntry($dto): array
    {
        $dto = $this->wrapDto($dto, DtoUsersEntry::class);

        try {
            $hashed_passwd = password_hash($dto->passwd, PASSWORD_DEFAULT);

            $this->create([
                'user_name' => $dto->user_name,
                'passwd'    => $hashed_passwd,
            ]);

            return [
                'status' => HttpStatus::HTTP_OK,
                'code'   => ErrorCode::SUCCESS,
            ];
        } catch (PDOException $e) {
            return [
                'status' => HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                'code'   => ErrorCode::ERR_SQL,
            ];
        } catch (Exception $e) {
            return [
                'status' => HttpStatus::HTTP_INTERNAL_SERVER_ERROR,
                'code'   => ErrorCode::ERR_UNKNOWN,
            ];
        }
    }

    public function validCheck($dto): array
    {
        $data = (array) $dto;

        $rules = [
            'user_name' => 'required|string|max:50|unique:users,user_name',
            'passwd'    => 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        $errorCodes = [];

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            // user_name のルール別エラー
            if (isset($failedRules['user_name']['Required'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_USER_NAME_EMPTY;
            } elseif (isset($failedRules['user_name']['Max'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_USER_NAME_TOO_LONG;
            } elseif (isset($failedRules['user_name']['Unique'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_USER_NAME_OVERLAP;
            }

            // passwd のルール別エラー
            if (isset($failedRules['passwd']['Required'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_USER_PASSWD_EMPTY;
            } elseif (isset($failedRules['passwd']['Min'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_USER_PASSWD_TOO_SHORT;
            }
        }

        return $errorCodes;
    }

}
