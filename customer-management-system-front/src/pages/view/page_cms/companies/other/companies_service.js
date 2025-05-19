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
        const response = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(send_data),
            credentials: 'include',
        });

        const result = await response.json();
        return result ?? 0;  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("会社情報取得失敗", error);
    }
}

//会社情報全取得
export async function getCompanies(company_id)
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/list";
    try {
        const send_data = {
            user_id: null
        }
        const response = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(send_data),
            credentials: 'include',
        });

        const result = await response.json();
        return result ?? 0;  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("会社情報取得失敗", error);
    }
}