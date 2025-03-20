<template>
    <div class="container mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Daftar Pekerjaan</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Karyawan</th>
                    <th class="border border-gray-300 px-4 py-2">Divisi</th>
                    <th class="border border-gray-300 px-4 py-2">Jabatan</th>
                    <th class="border border-gray-300 px-4 py-2">
                        Tanggal Bergabung
                    </th>
                    <th class="border border-gray-300 px-4 py-2">Gaji</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(job, index) in jobs" :key="job.id">
                    <td class="border border-gray-300 px-4 py-2">
                        {{ index + 1 }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ job.employee.nama_lengkap }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ job.division.nama_divisi }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ job.position.nama_jabatan }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ job.tanggal_bergabung }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        Rp{{ job.gaji.toLocaleString() }}
                    </td>
                    <td
                        class="border border-gray-300 px-4 py-2 font-semibold"
                        :class="
                            job.employee.status === 'Aktif'
                                ? 'text-green-600'
                                : 'text-red-600'
                        "
                    >
                        {{ job.employee.status }}
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
            jobs: [],
            loading: false,
            error: null,
        };
    },
    mounted() {
        this.fetchJobs();
    },
    methods: {
        async fetchJobs() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/job"
                ); // Pastikan API mengirim data lengkap
                this.jobs = response.data.data.data;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
