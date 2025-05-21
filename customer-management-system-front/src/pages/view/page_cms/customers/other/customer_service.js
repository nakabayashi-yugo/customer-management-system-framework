import { dtoCustomersGetCustomer } from "./../../../../dto/customers/dto_customers_get_customer.ts";

//登録されてる顧客の数取得
//    :表示されているdto_listの値
export async function onCount(data)
{
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/customers/count";
    try {
        const response = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
            credentials: 'include',
        });

        const result = await response.json();
        return result.data ?? 0;  // ← 取れなかったら0を返す
    } catch (error) {
        console.error("顧客件数取得失敗：", error);
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
        const response = await fetch(api_url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(send_data),
            credentials: 'include',
        });
        const result = await response.json();
        return result.data ?? null;
    } catch (error) {
        console.error("顧客取得失敗", error);
    }
}