export default class DanhGiaService {
    constructor(baseUrl = "/api/danh_gia") {
        this.baseUrl = baseUrl;
    }


    async getDanhGiaByMaCT(maCT) {
        return (await axios.get(`${this.baseUrl}/?MaCT=${maCT}`)).data;
    }

    async createDanhGia(data) {
        return (await axios.post(`${this.baseUrl}/`, data)).data;
    }

}
