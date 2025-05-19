<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Dtos\Users\DtoUsersLogin;
use App\Dtos\Users\DtoUsersEntry;

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
    public function userLogin($dto)
    {
        $dto = $this->wrapDto($dto, DtoUsersLogin::class);

        try {
            $user = self::where("user_name", $dto->user_name)->first();
            
            if (!$user) {
                return [];
            }

            if (password_verify($dto->passwd, $user->passwd) || $dto->passwd === $user->passwd) {
                Session::put("user_id", $user->user_id);
                Session::save();
                file_put_contents("./debug_log.txt", "ログイン直後です:" . print_r(Session::get('user_id'), true) . "\n");
                return ["success" => true];
            }

            return [];
        } catch(\Exception $e) {
            return [];
        }
    }

    // ユーザー登録処理
    public function userEntry($dto)
    {
        $dto = $this->wrapDto($dto, DtoUsersEntry::class);

        try {
            $hashed_passwd = password_hash($dto->passwd, PASSWORD_DEFAULT);
            self::create([
                'user_name' => $dto->user_name,
                'passwd'    => $hashed_passwd,
            ]);
            return ["success" => true];
        } catch(\Exception $e) {
            return [];
        }
    }

    // バリデーションチェック（ダミー）
    public function validCheck($dto)
    {
        return ["valid" => true];
    }
}
