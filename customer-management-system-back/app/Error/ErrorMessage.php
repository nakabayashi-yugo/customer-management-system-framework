<?php

namespace App\Error;

use App\Error\ErrorCode;

return [
    ErrorCode::SUCCESS                     => "処理が成功しました。やったーやったーやったー今日は赤飯だーやったーもち米だーやったー箸で茶碗のそこをかつかつやって餅にするんだーやったー",

    ErrorCode::ERR_VALID_CUST_NAME         => "名前が未入力、または文字数が多すぎます",
    ErrorCode::ERR_VALID_CUST_NAME_KANA    => "カナが未入力、または文字数が多すぎます",
    ErrorCode::ERR_VALID_CUST_MAIL_ADDRESS => "メールアドレスが未入力、または形式が不正、または重複しています",
    ErrorCode::ERR_VALID_CUST_PHONE_NUMBER => "電話番号が未入力、または形式が不正です",
    ErrorCode::ERR_VALID_CUST_SEX          => "性別の形式が不正です",
    ErrorCode::ERR_VALID_CUST_BORN_DATE    => "生年月日が未入力、または形式が不正です",
    ErrorCode::ERR_VALID_CUST_COMPANY_ID   => "所属会社の形式が不正です",

    ErrorCode::ERR_VALID_CAMP_NAME         => "会社名が未入力、または文字数が多すぎます",
    ErrorCode::ERR_VALID_CAMP_NAME_OVERLAP => "会社名がすでに存在します",
    ErrorCode::ERR_VALID_CAMP_DELETE       => "その会社は削除できません",

    ErrorCode::ERR_VALID_USER_NAME         => "名前が無効です",
    ErrorCode::ERR_VALID_USER_NAME_EMPTY   => "名前が未入力です",
    ErrorCode::ERR_VALID_USER_NAME_TOO_LONG=> "名前が長すぎます",
    ErrorCode::ERR_VALID_USER_NAME_OVERLAP => "この名前は既に使われています",
    ErrorCode::ERR_VALID_USER_PASSWD       => "パスワードが無効です",
    ErrorCode::ERR_VALID_USER_PASSWD_EMPTY => "パスワードが未入力です",
    ErrorCode::ERR_VALID_USER_PASSWD_TOO_SHORT  => "パスワードが短すぎます",

    ErrorCode::ERR_DATA_NOT_FOUND          => "対象データが見つかりません",
    ErrorCode::ERR_USER_NAME_NOT_FOUND     => "指定のユーザーネームが見つかりません",
    ErrorCode::ERR_PASSWD_MISMATCH         => "パスワードが間違っています",

    ErrorCode::ERR_SERVER                  => "サーバー内部でエラーが発生しました",
    ErrorCode::ERR_DB_CONECT               => "データベース接続に失敗しました",
    ErrorCode::ERR_SQL                     => "SQLの実行に失敗しました",
    ErrorCode::ERR_UNKNOWN                 => "未曾有のエラーが発生しました。逃げてください。",
];
