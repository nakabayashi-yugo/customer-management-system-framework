export class dtoCustomersSort {
    sort_key: string;
    sort_order: string;

    constructor(data: any) {
        this.sort_key = data.sort_key;
        this.sort_order = data.sort_order;
    }
}