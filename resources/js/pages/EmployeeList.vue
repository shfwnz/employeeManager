<template>
    <div>
        <h1>Daftar Karyawan</h1>
        <router-link to="/employees/create">tambah karyawan</router-link>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.nama_lengkap }}</td>
                    <td>{{ employee.status }}</td>
                    <td>{{ employee.division_name }}</td>
                    <td>{{ employee.position_name }}</td>
                    <td>{{ formatCurrency(employee.sallary) }}</td>
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
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/employee"
                );
                this.employees = response.data.data.data;
            } catch (error) {
                console.error("Error fetching data:", error);
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
