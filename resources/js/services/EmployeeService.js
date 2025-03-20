import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api";

export default {
    getEmployees() {
        return axios.get(`${API_URL}/employee/detail`);
    },
    getEmployee(id) {
        return axios.get(`${API_URL}/employee/detail/${id}`);
    },
    createEmployee(data) {
        return axios.post(`${API_URL}/employee`, data);
    },
    updateEmployee(id, data) {
        return axios.put(`${API_URL}/employee/${id}`, data);
    },
    deleteEmployee(id) {
        return axios.delete(`${API_URL}/employee/${id}`);
    },
};
