export class dtoCustomersSearch {
    user_id: number;
    cust_name: string;
    cust_name_kana: string;
    sex: string;
    company_id: number;
    born_year: string;
    born_month: string;
    born_date: string;

    constructor(data: any) {
        this.user_id = data.user_id;
        this.cust_name = data.cust_name;
        this.cust_name_kana = data.cust_name_kana;
        this.sex = data.sex;
        this.company_id = data.company_id;
        this.born_year = data.born_year;
        this.born_month = data.born_month;
        this.born_date = data.born_date;
    }
}