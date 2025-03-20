<template>
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Statistik Karyawan</h2>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-blue-200 rounded-lg">
                <h3 class="text-lg font-bold">Total Karyawan</h3>
                <p class="text-2xl">{{ statistics.total }}</p>
            </div>
            <div class="p-4 bg-green-200 rounded-lg">
                <h3 class="text-lg font-bold">Aktif</h3>
                <p class="text-2xl">{{ statistics.aktif }}</p>
            </div>
            <div class="p-4 bg-red-200 rounded-lg">
                <h3 class="text-lg font-bold">Nonaktif</h3>
                <p class="text-2xl">{{ statistics.nonaktif }}</p>
            </div>
        </div>

        <h2 class="text-xl font-bold mb-4">Filter Berdasarkan Divisi</h2>
        <select
            v-model="selectedDivision"
            @change="fetchEmployees"
            class="p-2 border rounded"
        >
            <option value="">Semua Divisi</option>
            <option
                v-for="div in statistics.divisions"
                :key="div.id"
                :value="div.id"
            >
                {{ div.nama_divisi }}
            </option>
        </select>

        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Divisi</th>
                    <th class="border border-gray-300 px-4 py-2">Jabatan</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(employee, index) in employees" :key="employee.id">
                    <td class="border border-gray-300 px-4 py-2">
                        {{ index + 1 }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ employee.nama_lengkap }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{
                            employee.division?.nama_divisi || "Tidak ada divisi"
                        }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{
                            employee.position?.nama_jabatan ||
                            "Tidak ada jabatan"
                        }}
                    </td>
                    <td
                        class="border border-gray-300 px-4 py-2"
                        :class="
                            employee.status === 'Aktif'
                                ? 'text-green-600'
                                : 'text-red-600'
                        "
                    >
                        {{ employee.status }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="loading" class="text-center mt-4">Memuat data...</div>
        <div v-if="error" class="text-center text-red-500 mt-4">
            Terjadi kesalahan: {{ error }}
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            statistics: {
                total: 0,
                aktif: 0,
                nonaktif: 0,
                divisions: [],
            },
            employees: [],
            selectedDivision: "",
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchStatistics();
        this.fetchEmployees();
    },
    methods: {
        async fetchStatistics() {
            this.loading = true;
            try {
                const totalResponse = await axios.get(
                    "http://127.0.0.1:8000/api/employee/total"
                );
                this.statistics.total = totalResponse.data.data;

                const statusResponse = await axios.get(
                    "http://127.0.0.1:8000/api/employee/status"
                );
                this.statistics.aktif = statusResponse.data.data.Aktif;
                this.statistics.nonaktif = statusResponse.data.data.Nonaktif;

                const divisionsResponse = await axios.get(
                    "http://127.0.0.1:8000/api/divisions"
                );
                this.statistics.divisions = divisionsResponse.data.data;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },

        async fetchEmployees() {
            this.loading = true;
            let url = "http://127.0.0.1:8000/api/employee";
            if (this.selectedDivision) {
                url += `?division_id=${this.selectedDivision}`;
            }

            try {
                const response = await axios.get(url);
                this.employees = response.data.data.data;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
