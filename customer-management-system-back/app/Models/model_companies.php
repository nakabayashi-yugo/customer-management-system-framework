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
    }
?>
