export default class UserService {
    constructor(baseUrl = "/api/user-session") {
        this.baseUrl = baseUrl;
    }

    async getUserSession() {
        return (await axios.get(`${this.baseUrl}`)).data;
    }
    
}
