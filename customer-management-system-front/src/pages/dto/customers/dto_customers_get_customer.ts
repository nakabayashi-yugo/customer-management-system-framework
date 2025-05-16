export class dtoCustomersGetCustomer {
    user_id: number;
    cust_id: number;

    constructor(data: any) {
        this.user_id = data.user_id;
        this.cust_id = data.cust_id;
    }
}