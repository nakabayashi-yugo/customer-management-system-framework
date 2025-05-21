<?php

namespace App\Error;

//HTTPステータスコード定義

class HttpStatus
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;             // 入力ミス、バリデーションエラー
    public const HTTP_NOT_FOUND = 404;               // ファイルが見つからない
    public const HTTP_INTERNAL_SERVER_ERROR = 500;   // サーバーのエラー
}
