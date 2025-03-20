<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Karyawan</h1>

        <!-- Table -->
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">NIK</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Divisi</th>
                    <th class="border border-gray-300 px-4 py-2">Jabatan</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(employee, index) in employees" :key="employee.id">
                    <td class="border border-gray-300 px-4 py-2">
                        {{ index + 1 }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ employee.nik }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ employee.nama_lengkap }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{
                            employee.division
                                ? employee.division.nama_divisi
                                : "-"
                        }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{
                            employee.position
                                ? employee.position.nama_jabatan
                                : "-"
                        }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ employee.email }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button
                            class="bg-blue-500 text-white px-3 py-1 rounded"
                            @click="editEmployee(employee.id)"
                        >
                            Edit
                        </button>
                        <button
                            class="bg-red-500 text-white px-3 py-1 rounded ml-2"
                            @click="deleteEmployee(employee.id)"
                        >
                            Hapus
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 flex justify-between">
            <button
                :disabled="!prevPageUrl"
                @click="fetchEmployees(prevPageUrl)"
                class="px-4 py-2 bg-gray-400 text-white rounded"
            >
                Previous
            </button>
            <button
                :disabled="!nextPageUrl"
                @click="fetchEmployees(nextPageUrl)"
                class="px-4 py-2 bg-gray-400 text-white rounded"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            employees: [],
            prevPageUrl: null,
            nextPageUrl: null,
        };
    },
    mounted() {
        this.fetchEmployees();
    },
    methods: {
        async fetchEmployees(url = "http://127.0.0.1:8000/api/employee") {
            try {
                const response = await axios.get(url, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                this.employees = response.data.data.data;
                this.prevPageUrl = response.data.data.prev_page_url;
                this.nextPageUrl = response.data.data.next_page_url;
            } catch (error) {
                console.error("Error fetching employees:", error);
            }
        },
        editEmployee(id) {
            this.$router.push({ name: "EmployeeForm", params: { id } });
        },
        async deleteEmployee(id) {
            if (!confirm("Apakah Anda yakin ingin menghapus karyawan ini?"))
                return;
            try {
                await axios.delete(`http://127.0.0.1:8000/api/employee/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                });
                this.fetchEmployees();
            } catch (error) {
                console.error("Error deleting employee:", error);
            }
        },
    },
};
</script>
