import { dtoCustomersGetCustomer } from "./../../../../dto/customers/dto_customers_get_customer.ts";

//登録されてる顧客の数取得
//    :表示されているdto_listの値
export async function onCount(data)
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/count";
    try {
        const response_api = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
            credentials: 'include',
        });
        if (!response_api.ok) {
            throw new Error("API失敗：" + response_api.status);
        }

        const result = await response_api.json();
        return result.data ?? 0;  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("顧客件数取得失敗：", error);
        return 0;
    }
}

//顧客IDから顧客特定
//引数：顧客ID
export async function getCustomer(cust_id)
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/getCustomer";
    try {
        const send_data = new dtoCustomersGetCustomer();
        send_data.cust_id = cust_id;
        const response_api = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(send_data),
            credentials: 'include',
        });
        if (!response_api.ok) {
            throw new Error("API失敗：" + response_api.status);
        }
        const result = await response_api.json();
        return result.data ?? null;
    } catch (error) {
        console.error("顧客取得失敗", error);
        return null;
    }
}

export function validCheck(data) {
  const errorList = [];

  // 顧客名（必須・最大32文字・漢字・ひらがな・スペースのみ）
  if (!data.cust_name || data.cust_name.trim() === "") {
    errorList.push("顧客名を入力してください");
  } else {
    if (data.cust_name.length > 32) {
      errorList.push("顧客名は32文字以内で入力してください");
    }
    if (!/^[\p{Script=Hiragana}\p{Script=Han} 　]+$/u.test(data.cust_name)) {
      errorList.push("顧客名は漢字・ひらがな・スペースのみで入力してください");
    }
  }

  // 顧客名カナ（必須・最大32文字・カタカナ・スペースのみ）
  if (!data.cust_name_kana || data.cust_name_kana.trim() === "") {
    errorList.push("顧客名カナを入力してください");
  } else {
    if (data.cust_name_kana.length > 32) {
      errorList.push("顧客名カナは32文字以内で入力してください");
    }
    if (!/^[\p{Script=Katakana}ー　]+$/u.test(data.cust_name_kana)) {
      errorList.push("顧客名カナはカタカナとスペースのみで入力してください");
    }
  }

  // メールアドレス
  if (!data.mail_address || data.mail_address.trim() === "") {
    errorList.push("メールアドレスを入力してください");
  } else if (!/^[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(data.mail_address)) {
    errorList.push("正しいメールアドレス形式で入力してください");
  }

  // 電話番号（必須・最大20文字・数字と-のみ）
  if (!data.phone_number || data.phone_number.trim() === "") {
    errorList.push("電話番号を入力してください");
  } else {
    if (data.phone_number.length > 20) {
      errorList.push("電話番号は20文字以内で入力してください");
    }
    if (!/^[0-9\-]+$/.test(data.phone_number)) {
      errorList.push("電話番号は数字とハイフンのみで入力してください");
    }
  }

  // 性別
  if (!["男性", "女性", "その他"].includes(data.sex)) {
    errorList.push("性別を選択してください");
  }

  // 会社ID
  if (!data.company_id || isNaN(parseInt(data.company_id))) {
    errorList.push("会社を選択してください");
  }

  // 生年月日（形式 & 今日より過去）
  if (!data.born_date || !/^\d{4}-\d{2}-\d{2}$/.test(data.born_date)) {
    errorList.push("生年月日を正しく入力してください（例：1990-01-01）");
  } else {
    const inputDate = new Date(data.born_date);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // 今日の00:00に固定
    if (inputDate > today) {
      errorList.push("生年月日は今日以前の日付を入力してください");
    }
  }

  // まとめて1つの文字列で返す
  return errorList.join('\n');
}
