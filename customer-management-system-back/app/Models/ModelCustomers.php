<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ModelCustomers extends Model
    {
        protected $table = 'customers';
        protected $primaryKey = 'cust_id';

        const CREATED_AT = 'insert_at';
        const UPDATED_AT = 'update_at';

        protected $fillable = 
        [
            "user_id",
            "cust_name",
            "cust_name_kana", 
            "mail_address",
            "phone_number",
            "sex",
            "company_id",
            "born_date",
        ];

        //顧客ID一覧ゲット関数
        public function getCustomerIds($data)
        {
            try {
                //全件取得
                $query = $this::query();
                $query->where('user_id', $data["user_id"]);
                //cust_idだけを配列として返す
                return $query->pluck("cust_id")->toArray();
            } catch(\Exception $e) {
                return [];
            }
        }
        //顧客テーブルに登録されている会社ID一覧ゲット関数
        public function getCustomerIncludedCompanyIds($data)
        {
            try {
                //全件取得
                $query = $this::query();
                $query->where("user_id", $data["user_id"]);
                //company_idだけを配列として返す
                return $query->pluck("company_id")->toArray();
            } catch(\Exception $e) {
                return [];
            }
        }
        //引数によって渡された顧客IDが顧客テーブルに登録済みか返す関数
        //true: 登録済み
        //false: 登録されていない
        /**/
        public function isIdIncluded($data)
        {
            try {
                //顧客テーブルの顧客ID一覧取得
                $ids = $this->getCustomerIds($data);
                //要素が一つもないなら終わり
                if(!$ids)
                {
                    return $ids;
                }
                //引数として渡されたcust_idが含まれているか返す
                return in_array($data["cust_id"], $ids);
            } catch(\Exception $e) {
                return [];
            }
        }

        //検索機能
        public function customerSearch($data)
        {
            try {
                //全件取得
                $query = $this::query();
                $query->where('user_id', $data['user_id']);
                $query->when($data['cust_name'] ?? null, function ($q, $cust_name) {
                    $q->where('cust_name', 'like', "%{$cust_name}%");
                });
                $query->when($data['cust_name_kana'] ?? null, function ($q, $cust_name_kana) {
                    $q->where('cust_name_kana', 'like', "%{$cust_name_kana}%");
                });
                $query->when($data['sex'] ?? null, function ($q, $sex) {
                    $q->where('sex', $sex);
                });
                $query->when($data['company_id'] ?? null, function ($q, $company_id) {
                    $q->where('company_id', $company_id);
                });
                $query->when($data['born_year'] ?? null, function ($q, $born_year) {
                    $q->whereYear('born_date', $born_year);
                });
                $query->when($data['born_month'] ?? null, function ($q, $born_month) {
                    $q->whereMonth('born_date', $born_month);
                });
                $query->when($data['born_date'] ?? null, function ($q, $born_date) {
                    $q->whereDay('born_date', $born_date);
                });

                return $query;
            } catch(\Exception $e) {
                return [];
            }
        }
        //ソート
        public function customerSort($data, $disp_data)
        {
            // ソート
            $sort_key = $data['sort_data']['sort_key'] ?? 'cust_id';
            $sort_order = $data['sort_data']['sort_order'] === '昇順' ? 'asc' : 'desc';
            $disp_data->orderBy($sort_key, $sort_order);
            return $disp_data;
        }
        //表示件数更新
        public function customerDispNumChange($data, $disp_data)
        {
            $perPage = $data['disp_num'] ?? 10;
            $page = $data['page_id'] ?? 1;
            $offset = ($page - 1) * $perPage;
            $disp_data->offset($offset)->limit($perPage);

            return $disp_data;
        }
        //一覧取得
        public function customerList($data)
        {
            try {
                //悩んだ。検索の方のdtoのuser_idに一覧のdtoのuser_idを入れる
                $data["search_data"]["user_id"] = $data["user_id"];
                $disp_data = $this->customerSearch($data["search_data"]);
                //空だったらおわり
                if(empty($disp_data))    return collect();
                //ソート
                $disp_data = $this->customerSort($data["sort_data"], $disp_data);
                //表示件数
                $disp_data = $this->customerDispNumChange($data, $disp_data);
                return $disp_data->get();
            } catch(\Exception $e) {
                return [];
            }
        }
        //顧客件数取得
        public function customerCount($data)
        {
            try {
                $data["search_data"]["user_id"] = $data["user_id"];
                $disp_data = $this->customerSearch($data["search_data"]);
                return count($disp_data);
            } catch(\Exception $e) {
                return 0;
            }
        }
        //顧客削除
        public function customerDelete($data)
        {
            try {
                $deletedCount = $this::where('user_id', $data['user_id'])
                                    ->where('cust_id', $data['cust_id'])
                                    ->delete();

                if ($deletedCount > 0) {
                    return ["success" => true];
                } else {
                    return [];
                }
            } catch (\Exception $e) {
                return [];
            }
        }
        //顧客登録
        public function customerEntry($data)
        {
            try {
                $created = $this::create([
                    "user_id"        => $data["user_id"],
                    "cust_name"      => $data["cust_name"],
                    "cust_name_kana" => $data["cust_name_kana"],
                    "mail_address"   => $data["mail_address"],
                    "phone_number"   => $data["phone_number"],
                    "sex"            => $data["sex"],
                    "company_id"     => $data["company_id"],
                    "born_date"      => $data["born_date"],
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
        //顧客編集
        public function customerEdit($data)
        {
           try {
                $updatedCount = $this::where('user_id', $data['user_id'])
                                    ->where('cust_id', $data['cust_id'])
                                    ->update([
                                        'cust_name'      => $data['cust_name'],
                                        'cust_name_kana' => $data['cust_name_kana'],
                                        'mail_address'   => $data['mail_address'],
                                        'phone_number'   => $data['phone_number'],
                                        'sex'            => $data['sex'],
                                        'born_date'      => $data['born_date'],
                                        'company_id'     => $data['company_id'],
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
        //顧客IDの顧客取得
        public function getCustomer($data)
        {
            try {
                return $this::where('user_id', $data['user_id'])
                            ->where('cust_id', $data['cust_id'])
                            ->first();  // 1件だけ取得
            } catch(\Exception $e) {
                return [];
            }
        }
        //顧客全取得
        public function getCustomers($data)
        {
            try {
                return $this::where("user_id", $data["user_id"])->get();
            } catch (\Exception $e) {
                return collect();  // 空のCollection返すほうが統一感ある
            }
        }
        //バリデ
        public function validCheck($data)
        {
            return ["valid" => true];
        }
    }
?>
