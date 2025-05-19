export class dtoCustomersDelete {
    user_id: number;
    cust_id: number;

    constructor(data?: any) {
        this.user_id = data?.user_id ?? 0;
        this.cust_id = data?.cust_id ?? 0;
    }
}