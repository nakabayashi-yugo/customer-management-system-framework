import { dtoCustomersSearch } from "./dto_customers_search.ts";
import { dtoCustomersSort } from "./dto_customers_sort.ts";

export class dtoCustomersList {
    search_data: dtoCustomersSearch;
    sort_data: dtoCustomersSort;
    disp_num: number;
    page_id: number;

    constructor(data?: any) {
        this.search_data = new dtoCustomersSearch(data?.search_data ?? {});
        this.sort_data = new dtoCustomersSort(data?.sort_data ?? {});
        this.disp_num = data?.disp_num ?? 10;
        this.page_id = data?.page_id ?? 1;
    }
}