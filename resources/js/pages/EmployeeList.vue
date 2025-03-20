<template>
    <div>
        <h1>Daftar Karyawan</h1>
        <router-link to="/employee/create">Tambah Karyawan</router-link>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Gaji</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="employees.length === 0">
                    <td colspan="6" style="text-align: center">
                        Tidak ada data karyawan
                    </td>
                </tr>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.nama_lengkap }}</td>
                    <td>{{ employee.nama_divisi || "N/A" }}</td>
                    <td>{{ employee.nama_jabatan || "N/A" }}</td>
                    <td>{{ employee.status }}</td>
                    <td>{{ formatCurrency(employee.gaji) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            employees: [],
        };
    },
    mounted() {
        this.fetchEmployees();
    },
    methods: {
        async fetchEmployees() {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/employee",
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                console.log("API Response:", response.data);
                this.employees = response.data.data || [];
            } catch (error) {
                console.error(
                    "Error fetching data:",
                    error.response || error.message
                );
            }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
            }).format(value);
        },
    },
};
</script>
