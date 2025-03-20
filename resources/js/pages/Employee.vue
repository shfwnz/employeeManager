<template>
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                DAFTAR KARYAWAN
            </h2>

            <router-link
                :to="{ name: 'create karyawan' }"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200"
            >
                + TAMBAH KARYAWAN
            </router-link>

            <div class="overflow-x-auto mt-4">
                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="border border-gray-300 px-4 py-2">
                                NIK
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                Nama Lengkap
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                Email
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                Telepon
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                Alamat
                            </th>
                            <th class="border border-gray-300 px-4 py-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(employee, index) in employees"
                            :key="employee?.id || index"
                            class="hover:bg-gray-50 transition duration-200"
                        >
                            <td class="border border-gray-300 px-4 py-2">
                                {{ employee.nik }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ employee.nama_lengkap }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ employee.email }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ employee.telepon }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ employee.alamat }}
                            </td>
                            <td
                                class="border border-gray-300 px-4 py-2 flex justify-center space-x-2"
                            >
                                <router-link
                                    :to="{
                                        name: 'edit karyawan',
                                        params: { id: employee.id },
                                    }"
                                    class="px-3 py-1 text-white bg-green-600 rounded-md hover:bg-green-700 transition duration-200"
                                >
                                    EDIT
                                </router-link>
                                <button
                                    @click.prevent="
                                        deleteEmployee(employee.id, index)
                                    "
                                    class="px-3 py-1 text-white bg-red-600 rounded-md hover:bg-red-700 transition duration-200"
                                >
                                    HAPUS
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
    created() {
        this.fetchEmployees();
    },
    methods: {
        fetchEmployees() {
            axios
                .get("http://localhost:8000/api/employee")
                .then((response) => {
                    this.employees = response.data.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching employees:", error);
                });
        },
        deleteEmployee(id, index) {
            if (confirm("Apakah Anda yakin ingin menghapus karyawan ini?")) {
                axios
                    .delete(`http://localhost:8000/api/employee/${id}`)
                    .then(() => {
                        this.employees.splice(index, 1);
                    })
                    .catch((error) => {
                        console.error("Error deleting employee:", error);
                    });
            }
        },
    },
};
</script>
