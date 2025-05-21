export class dtoCompaniesList {
    user_id: number;

    constructor(data?: any) {
        this.user_id = data?.user_id ?? 0;
    }
}
