<template>
    <div>
        <h1>Data Karyawan</h1>
        <button @click="showModal = true">Tambah Karyawan</button>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{ employee.id }}</td>
                    <td>{{ employee.nik }}</td>
                    <td>{{ employee.nama_lengkap }}</td>
                    <td>
                        <span v-if="employee.jobs.length">
                            <span
                                v-for="(job, index) in employee.jobs"
                                :key="index"
                            >
                                {{ job.division?.nama_divisi || "-" }}
                                <span v-if="index !== employee.jobs.length - 1"
                                    >,
                                </span>
                            </span>
                        </span>
                        <span v-else>-</span>
                    </td>
                    <td>
                        <span v-if="employee.jobs.length">
                            <span
                                v-for="(job, index) in employee.jobs"
                                :key="index"
                            >
                                {{ job.position?.nama_jabatan || "-" }}
                                <span v-if="index !== employee.jobs.length - 1"
                                    >,
                                </span>
                            </span>
                        </span>
                        <span v-else>-</span>
                    </td>

                    <td>
                        <button @click="editEmployee(employee)">Edit</button>
                        <button @click="deleteEmployee(employee.id)">
                            Hapus
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="showModal">
            <form @submit.prevent="saveEmployee">
                <input v-model="form.nik" placeholder="NIK" required />
                <input
                    v-model="form.nama_lengkap"
                    placeholder="Nama Lengkap"
                    required
                />
                <input v-model="form.alamat" placeholder="Alamat" required />
                <select v-model="form.jenis_kelamin">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <button type="submit">Simpan</button>
                <button @click="showModal = false">Batal</button>
            </form>
        </div>
    </div>
</template>

<script>
import employeeService from "@/services/employeeService";

export default {
    data() {
        return {
            employees: [],
            showModal: false,
            form: {
                nik: "",
                nama_lengkap: "",
                alamat: "",
                jenis_kelamin: "Laki-laki",
            },
        };
    },
    methods: {
        async fetchEmployees() {
            try {
                const response = await employeeService.getEmployees();
                this.employees = response.data.data;
            } catch (error) {
                console.error("Error fetching employees:", error);
            }
        },
        async saveEmployee() {
            try {
                if (this.form.id) {
                    await employeeService.updateEmployee(
                        this.form.id,
                        this.form
                    );
                } else {
                    await employeeService.createEmployee(this.form);
                }
                this.showModal = false;
                this.fetchEmployees();
            } catch (error) {
                console.error("Error saving employee:", error);
            }
        },
        editEmployee(employee) {
            this.form = { ...employee };
            this.showModal = true;
        },
        async deleteEmployee(id) {
            if (confirm("Yakin ingin menghapus?")) {
                try {
                    await employeeService.deleteEmployee(id);
                    this.fetchEmployees();
                } catch (error) {
                    console.error("Error deleting employee:", error);
                }
            }
        },
    },
    mounted() {
        this.fetchEmployees();
    },
};
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}

button {
    margin-right: 5px;
}
</style>
