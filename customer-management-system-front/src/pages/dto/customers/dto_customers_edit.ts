export class dtoCustomersEdit {
    user_id: number;
    cust_id: number;
    cust_name: string;
    cust_name_kana: string;
    mail_address: string;
    phone_number: string;
    sex: string;
    company_id: number;
    born_date: string;

    constructor(data?: any) {
        this.user_id = data?.user_id ?? 0;
        this.cust_id = data?.cust_id ?? 0;
        this.cust_name = data?.cust_name ?? '';
        this.cust_name_kana = data?.cust_name_kana ?? '';
        this.mail_address = data?.mail_address ?? '';
        this.phone_number = data?.phone_number ?? '';
        this.sex = data?.sex ?? '';
        this.company_id = data?.company_id ?? 0;
        this.born_date = data?.born_date ?? '';
    }
}