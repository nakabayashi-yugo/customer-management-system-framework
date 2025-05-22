import { errorAlert } from "./../../../error_alert.js";

//idから会社特定
//    :会社ID
export async function getCompany(company_id)
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/getCompany";
    try {
        const send_data = {
            user_id: null,
            company_id: company_id,
        }
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
        return result.data ?? 0;  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("会社情報取得失敗", error);
        return 0;
    }
}

//会社情報全取得
export async function getCompanies()
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/list";
    try {
        const send_data = {
            user_id: null
        }
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
        return result.data ?? [];  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("全会社情報取得失敗", error);
        return [];
    }
}

export function validCheck(data) {
  const errorList = [];

  // 会社名（必須・最大32文字）
  if (!data.company_name || data.company_name.trim() === "") {
    errorList.push("会社名を入力してください");
  } else if (data.company_name.length > 32) {
    errorList.push("会社名は32文字以内で入力してください");
  }

  // ※ユニーク（重複チェック）はAPI使わないと無理なのでここではやらない

  return errorList.join('\n');
}
