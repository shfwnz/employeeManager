<template>
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                TAMBAH KARYAWAN
            </h2>

            <form @submit.prevent="storeEmployee" class="space-y-4">
                <!-- NIK -->
                <div>
                    <label class="block text-gray-600 font-medium">NIK</label>
                    <input
                        type="text"
                        v-model="employee.nik"
                        placeholder="Masukkan NIK"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.nik"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.nik[0] }}
                    </p>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Nama Lengkap</label
                    >
                    <input
                        type="text"
                        v-model="employee.nama_lengkap"
                        placeholder="Masukkan Nama Lengkap"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.nama_lengkap"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.nama_lengkap[0] }}
                    </p>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Tempat Lahir</label
                    >
                    <input
                        type="text"
                        v-model="employee.tempat_lahir"
                        placeholder="Masukkan Tempat Lahir"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.tempat_lahir"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.tempat_lahir[0] }}
                    </p>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Tanggal Lahir</label
                    >
                    <input
                        type="date"
                        v-model="employee.tanggal_lahir"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.tanggal_lahir"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.tanggal_lahir[0] }}
                    </p>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Jenis Kelamin</label
                    >
                    <select
                        v-model="employee.jenis_kelamin"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <p
                        v-if="validation.jenis_kelamin"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.jenis_kelamin[0] }}
                    </p>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Alamat</label
                    >
                    <textarea
                        v-model="employee.alamat"
                        rows="3"
                        placeholder="Masukkan Alamat"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                    <p
                        v-if="validation.alamat"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.alamat[0] }}
                    </p>
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Telepon</label
                    >
                    <input
                        type="text"
                        v-model="employee.telepon"
                        placeholder="Masukkan Nomor Telepon"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.telepon"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.telepon[0] }}
                    </p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-600 font-medium">Email</label>
                    <input
                        type="email"
                        v-model="employee.email"
                        placeholder="Masukkan Email"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <p
                        v-if="validation.email"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.email[0] }}
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Status</label
                    >
                    <select
                        v-model="employee.status"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200"
                    >
                        SIMPAN
                    </button>
                    <button
                        type="reset"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200"
                        @click="resetForm"
                    >
                        RESET
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            employee: {
                nik: "",
                nama_lengkap: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                jenis_kelamin: "Laki-laki",
                alamat: "",
                telepon: "",
                email: "",
                status: "Aktif",
            },
            validation: [],
        };
    },
    methods: {
        async storeEmployee() {
            try {
                await axios.post(
                    "http://localhost:8000/api/employee",
                    this.employee,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );

                alert("Karyawan berhasil ditambahkan!");
                this.$router.push({ name: "Employee" });
            } catch (error) {
                if (error.response && error.response.data) {
                    this.validation = error.response.data.errors || {};
                } else {
                    console.error("Error:", error);
                }
            }
        },
        resetForm() {
            this.employee = {
                nik: "",
                nama_lengkap: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                jenis_kelamin: "Laki-laki",
                alamat: "",
                telepon: "",
                email: "",
                status: "Aktif",
            };
            this.validation = [];
        },
    },
};
</script>
