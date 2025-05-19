import { dtoCustomersSearch } from "./dto_customers_search.ts";

export class dtoCustomersCount {
    search_data: dtoCustomersSearch;

    constructor(data: any) {
        this.search_data = data;
    }
}