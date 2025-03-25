<template>
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Form Title -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                EDIT KARYAWAN
            </h2>

            <form @submit.prevent="updateEmployee" class="space-y-4">
                <!-- NIK Input -->
                <div>
                    <label class="block text-gray-600 font-medium">NIK</label>
                    <input
                        type="text"
                        v-model="employee.nik"
                        placeholder="Masukkan NIK"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <!-- Validation Message -->
                    <p
                        v-if="validation.nik"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.nik[0] }}
                    </p>
                </div>

                <!-- Nama Lengkap Input -->
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.nama_lengkap"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.nama_lengkap[0] }}
                    </p>
                </div>

                <!-- Tempat Lahir Input -->
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.tempat_lahir"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.tempat_lahir[0] }}
                    </p>
                </div>

                <!-- Tanggal Lahir Input -->
                <div>
                    <label class="block text-gray-600 font-medium"
                        >Tanggal Lahir</label
                    >
                    <input
                        type="date"
                        v-model="employee.tanggal_lahir"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <!-- Validation Message -->
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.jenis_kelamin"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.jenis_kelamin[0] }}
                    </p>
                </div>

                <!-- Email Input -->
                <div>
                    <label class="block text-gray-600 font-medium">Email</label>
                    <input
                        type="email"
                        v-model="employee.email"
                        placeholder="Masukkan Email"
                        class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-500"
                    />
                    <!-- Validation Message -->
                    <p
                        v-if="validation.email"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.email[0] }}
                    </p>
                </div>

                <!-- Telepon Input -->
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.telepon"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.telepon[0] }}
                    </p>
                </div>

                <!-- Alamat Input -->
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.alamat"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.alamat[0] }}
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
                    <!-- Validation Message -->
                    <p
                        v-if="validation.status"
                        class="text-red-500 text-sm bg-red-100 p-2 rounded-md mt-1"
                    >
                        {{ validation.status[0] }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200"
                    >
                        UPDATE
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-200"
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
            // data
            employee: {
                nik: "",
                nama_lengkap: "",
                tempat_lahir: "",
                tanggal_lahir: "",
                jenis_kelamin: "",
                email: "",
                telepon: "",
                alamat: "",
                status: "",
            },
            // Validation error messages
            validation: [],
        };
    },
    created() {
        this.getEmployee();
    },
    methods: {
        // Fetch employee data
        async getEmployee() {
            try {
                const response = await axios.get(
                    `http://localhost:8000/api/employee/${this.$route.params.id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );
                this.employee = response.data;
            } catch (error) {
                console.error("Gagal mengambil data karyawan:", error);
            }
        },

        // Update employee data
        async updateEmployee() {
            try {
                await axios.put(
                    `http://localhost:8000/api/employee/${this.$route.params.id}`,
                    this.employee,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );

                alert("Karyawan berhasil diperbarui!");
                this.$router.push({ path: "/karyawan" });
            } catch (error) {
                if (error.response && error.response.data) {
                    this.validation = error.response.data || {};
                } else {
                    console.error("Error:", error);
                }
            }
        },

        // Reset form to initial state
        resetForm() {
            this.getEmployee();
        },
    },
};
</script>
