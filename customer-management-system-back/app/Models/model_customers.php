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
    }
?>
