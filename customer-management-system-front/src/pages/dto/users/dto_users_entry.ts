export class dtoUsersEntry {
    user_name: string;
    passwd: string;

    constructor(data: { user_name: string; passwd: string }) {
        this.user_name = data.user_name;
        this.passwd = data.passwd;
    }
}