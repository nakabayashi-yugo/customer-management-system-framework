export class dtoCompaniesDelete {
    user_id: number;
    company_id: number;

    constructor(data?: any) {
        this.user_id = data?.user_id ?? 0;
        this.company_id = data?.cust_id ?? 0;
    }
}
