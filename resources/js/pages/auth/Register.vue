<template>
    <div>
        <!-- Page Title -->
        <h2 class="font-semibold text-center mb-4 p-4">Register</h2>

        <!-- Register Form -->
        <form @submit.prevent="register">
            <div>
                <!-- Name Input -->
                <label>Nama:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="name"
                    type="text"
                    required
                />
            </div>

            <div>
                <!-- Email Input -->
                <label>Email:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="email"
                    type="email"
                    required
                />
            </div>

            <div>
                <!-- Password Input -->
                <label>Password:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="password"
                    type="password"
                    required
                />
            </div>

            <div>
                <!-- Confirm Password Input -->
                <label>Konfirmasi Password:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="password_confirmation"
                    type="password"
                    required
                />
            </div>

            <!-- Register Button -->
            <button
                class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Daftar
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        };
    },
    methods: {
        async register() {
            try {
                await axios.post("http://127.0.0.1:8000/api/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });

                alert("Registrasi berhasil! Silakan login.");
                this.$router.push("/login");
            } catch (error) {
                alert("Registrasi gagal.");
                console.error(error);
            }
        },
    },
};
</script>
