<template>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">DATA KARYAWAN</div>

                    <div class="card-body">
                        <router-link
                            :to="{ name: 'create' }"
                            class="btn btn-md btn-success"
                            >TAMBAH KARYAWAN</router-link
                        >

                        <div class="table-responsive mt-2">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Divisi</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(employee, index) in employees"
                                        :key="employee.id"
                                    >
                                        <td>{{ employee.nik }}</td>
                                        <td>{{ employee.nama_lengkap }}</td>
                                        <td>{{ employee.email }}</td>
                                        <td>{{ employee.jenis_kelamin }}</td>
                                        <td>{{ employee.nama_divisi }}</td>
                                        <td>{{ employee.nama_jabatan }}</td>
                                        <td>{{ employee.status }}</td>
                                        <td class="text-center">
                                            <router-link
                                                :to="{
                                                    name: 'edit',
                                                    params: { id: employee.id },
                                                }"
                                                class="btn btn-sm btn-primary"
                                            >
                                                EDIT
                                            </router-link>
                                            <button
                                                @click.prevent="
                                                    deleteEmployee(
                                                        employee.id,
                                                        index
                                                    )
                                                "
                                                class="btn btn-sm btn-danger"
                                            >
                                                HAPUS
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <button
                            @click="prevPage"
                            :disabled="page === 1"
                            class="btn btn-sm btn-secondary"
                        >
                            Previous
                        </button>
                        <span class="mx-3"
                            >Halaman {{ page }} dari {{ totalPages }}</span
                        >
                        <button
                            @click="nextPage"
                            :disabled="page >= totalPages"
                            class="btn btn-sm btn-secondary"
                        >
                            Next
                        </button>
                    </div>
                </div>
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
            page: 1,
            perPage: 10,
            totalPages: 1,
        };
    },
    created() {
        this.fetchEmployees();
    },
    methods: {
        fetchEmployees() {
            axios
                .get(
                    `http://localhost:8000/api/employee?page=${this.page}&per_page=${this.perPage}`
                )
                .then((response) => {
                    this.employees = response.data.data || []; // Pastikan data ada
                    this.totalPages = response.data.last_page || 1;
                })
                .catch((error) => {
                    console.error("Error fetching employees:", error);
                });
        },

        deleteEmployee(id, index) {
            if (confirm("Apakah Anda yakin ingin menghapus karyawan ini?")) {
                axios
                    .delete(`http://localhost:8000/api/employee/${id}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    })
                    .then(() => {
                        this.employees.splice(index, 1);
                    })
                    .catch((error) => {
                        console.error("Error deleting employee:", error);
                    });
            }
        },

        nextPage() {
            if (this.page < this.totalPages) {
                this.page++;
                this.fetchEmployees();
            }
        },
        prevPage() {
            if (this.page > 1) {
                this.page--;
                this.fetchEmployees();
            }
        },
    },
};
</script>
