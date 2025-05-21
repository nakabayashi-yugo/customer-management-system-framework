<?php

namespace App\Error;


//アプリ独自のエラーコードをまとめたクラス
class ErrorCode
{
    // 成功
    public const SUCCESS = 9999;

    // 1000～1999: バリデーションエラー

    // 顧客
    public const ERR_VALID_CUST_NAME = 1001;
    public const ERR_VALID_CUST_NAME_KANA = 1002;
    public const ERR_VALID_CUST_MAIL_ADDRESS = 1003;
    public const ERR_VALID_CUST_PHONE_NUMBER = 1004;
    public const ERR_VALID_CUST_SEX = 1005;
    public const ERR_VALID_CUST_BORN_DATE = 1006;
    public const ERR_VALID_CUST_COMPANY_ID = 1007;

    // 会社
    public const ERR_VALID_CAMP_NAME = 1101;
    public const ERR_VALID_CAMP_NAME_OVERLAP = 1102;
    public const ERR_VALID_CAMP_DELETE = 1103;

    // ユーザー
    public const ERR_VALID_USER_NAME = 1201;
    public const ERR_VALID_USER_NAME_EMPTY = 1202;
    public const ERR_VALID_USER_NAME_TOO_LONG = 1203;
    public const ERR_VALID_USER_NAME_OVERLAP = 1204;
    public const ERR_VALID_USER_PASSWD = 1206;
    public const ERR_VALID_USER_PASSWD_EMPTY = 1205;
    public const ERR_VALID_USER_PASSWD_TOO_SHORT = 1207;

    // 共通
    public const ERR_DATA_NOT_FOUND = 1301;
    public const ERR_USER_NAME_NOT_FOUND = 1302;
    public const ERR_PASSWD_MISMATCH = 1303;

    // システムエラー
    public const ERR_SERVER = 5001;
    public const ERR_DB_CONECT = 5002;
    public const ERR_SQL = 5003;
    public const ERR_UNKNOWN = 5004;
}
