export class dtoCompaniesEdit {
    user_id: number;
    company_name: string;

    constructor(data?: any) {
        this.user_id = data?.user_id ?? 0;
        this.company_name = data?.company_name ?? "";
    }
}
