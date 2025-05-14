<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ModelUsers extends Model
    {
        protected $table = 'users';
        protected $primaryKey = 'user_id';

        const CREATED_AT = 'created_at';
        const UPDATED_AT = 'updated_at';

        protected $fillable = ['user_name', 'passwd'];
    }
?>
