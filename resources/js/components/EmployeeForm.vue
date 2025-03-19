<template>
    <div>
        <h2>Tambah Karyawan</h2>
        <form @submit.prevent="submitForm">
            <div>
                <label>Nama Lengkap:</label>
                <input v-model="employee.name" type="text" required />
            </div>

            <div>
                <label>Status:</label>
                <select v-model="employee.status">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <div>
                <label>Divisi:</label>
                <select v-model="employee.division_id">
                    <option
                        v-for="division in divisions"
                        :key="division.id"
                        :value="division.id"
                    >
                        {{ division.nama_divisi }}
                    </option>
                </select>
            </div>

            <div>
                <label>Jabatan:</label>
                <select v-model="employee.position_id">
                    <option
                        v-for="position in positions"
                        :key="position.id"
                        :value="position.id"
                    >
                        {{ position.nama_jabatan }}
                    </option>
                </select>
            </div>

            <div>
                <label>Gaji:</label>
                <input v-model="employee.salary" type="number" required />
            </div>

            <button type="submit">Simpan</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";

export default {
    setup() {
        const employee = ref({
            name: "",
            status: "Aktif",
            division_id: "",
            position_id: "",
            salary: "",
        });

        const divisions = ref([]);
        const positions = ref([]);

        onMounted(async () => {
            try {
                const divisiRes = await axios.get(
                    "http://127.0.0.1:8000/api/division"
                );
                const posisiRes = await axios.get(
                    "http://127.0.0.1:8000/api/position"
                );

                divisions.value = divisiRes.data?.data || divisiRes.data;
                positions.value = posisiRes.data?.data || posisiRes.data;
            } catch (error) {
                console.error("Error mengambil data:", error);
            }
        });

        // Fungsi simpan karyawan
        const submitForm = async () => {
            try {
                await axios.post(
                    "http://127.0.0.1:8000/api/employee",
                    employee.value
                );
                alert("Data berhasil disimpan!");
                employee.value = {
                    name: "",
                    status: "Aktif",
                    division_id: "",
                    position_id: "",
                    salary: "",
                };
            } catch (error) {
                console.error("Gagal menyimpan data:", error);
            }
        };

        return { employee, divisions, positions, submitForm };
    },
};
</script>

<style scoped>
div {
    margin-bottom: 10px;
}
input,
select {
    display: block;
    margin-top: 5px;
}
</style>
