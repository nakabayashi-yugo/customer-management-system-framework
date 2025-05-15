<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ModelCompanies extends Model
    {
        protected $table = 'companies';
        protected $primaryKey = 'company_id';

        const CREATED_AT = 'insert_at';
        const UPDATED_AT = 'update_at';

        protected $fillable = 
        [
            "user_id",
            "company_name",
        ];

        //会社IDの会社取得
        public function getCompany($data)
        {
            try {
                return $this::where("user_id", $data["user_id"])
                            ->where("company_id", $data["company_id"])
                            ->first();
            } catch (\Exception $e) {
                return collect();  // 空のCollection返すほうが統一感ある
            }
        }
        //会社ID全件取得
        public function getCompanyIds($data)
        {
            try {
                $query = $this::query();
                $query->where("user_id", $data["user_id"]);
                return $query->pluck("company_id")->toArray();
            } catch (\Exception $e) {
                return collect();  // 空のCollection返すほうが統一感ある
            }
        }
        
        //会社一覧取得
        public function companyList($data)
        {
            try {
                return $this::where("user_id", $data["user_id"])->get();
            } catch (\Exception $e) {
                return collect();  // 空のCollection返すほうが統一感ある
            }
        }
        //会社削除
        public function companyDelete($data)
        {
            try {
                $deletedCount = $this::where("user_id", $data["user_id"])
                                    ->where("company_id", $data["company_id"])
                                    ->delete();
                if ($deletedCount > 0) {
                    return ["success" => true];
                } else {
                    return [];
                }
            } catch (\Exception $e) {
                return collect();  // 空のCollection返すほうが統一感ある
            }
        }
        //会社登録
        public function companyEntry($data)
        {
            try {
                $created = $this::create([
                    "user_id"        => $data["user_id"],
                    "company_name"   => $data["company_name"],
                ]);

                if ($created) {
                    return ["success" => true];
                } else {
                    return [];
                }
            } catch (\Exception $e) {
                return [];
            }
        }
        //会社編集
        public function companyEdit($data)
        {
           try {
                $updatedCount = $this::where('user_id', $data['user_id'])
                                    ->where('company_id', $data['company_id'])
                                    ->update([
                                        'company_name'      => $data['company_name'],
                                    ]);

                if ($updatedCount > 0) {
                    return ["success" => true];
                } else {
                    return [];
                }
            } catch (\Exception $e) {
                return [];
            }
        }
        
        //バリデ
        public function validCheck($data)
        {
            return ["valid" => true];
        }
        //削除時のバリデ
        public function deleteValidCheck($data)
        {
            $errors = [];
            $model_companies = new ModelCustomers();
            
            $valid_customers_company_ids = $model_companies->getCompanyIds($data["user_id"]);
            
            //すでに顧客情報に登録されている会社IDかどうかのチェック
            if(in_array($data["company_id"], $valid_customers_company_ids))
            {
                $errors["valid"] = false;
            }

             return $errors;
        }
    }
?>
