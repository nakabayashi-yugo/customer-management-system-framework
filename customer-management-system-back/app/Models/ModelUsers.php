<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Session;

    class ModelUsers extends Model
    {
        protected $table = 'users';
        protected $primaryKey = 'user_id';

        const CREATED_AT = 'created_at';
        const UPDATED_AT = 'updated_at';

        protected $fillable = ['user_name', 'passwd'];

        public function userLogin($data)
        {
            try {
                $user = self::where("user_name", $data["user_name"])->first();
                
                if(!$user)
                {
                    return [];
                }
                //パスワードあってるかな
                if(password_verify($data["passwd"], $user->passwd) || $data["passwd"] === $user->passwd)
                {
                    Session::put("user_id", $user->user_id);   
                    Session::save();  // ← これ追加
                    file_put_contents("./debug_log.txt", "ログイン直後です:" . print_r(Session::get('user_id'), true) . "\n");
                    return ["success" => true];
                }
                return [];
            } catch(\Exception $e) {
                return [];
            }

        }
        public function userEntry($data)
        {
            try{
                $hashed_passwd = password_hash($data["passwd"], PASSWORD_DEFAULT);
                self::create([
                    'user_name' => $data['user_name'],
                    'passwd'    => $hashed_passwd,
                ]);
                return ["success" => true];
            } catch(\Exception $e) {
                    return [];
            }
        }
        public function validCheck($data)
        {
            return ["valid" => true];
        }
    }
?>
