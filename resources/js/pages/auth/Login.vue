<template>
    <div>
        <h2 class="font-semibold text-center mb-4 p-4">Login</h2>
        <form @submit.prevent="login">
            <div>
                <label>Email:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="email"
                    type="email"
                    required
                />
            </div>

            <div>
                <label>Password:</label>
                <input
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    v-model="password"
                    type="password"
                    required
                />
            </div>

            <button
                class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Login
            </button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/login",
                    {
                        email: this.email,
                        password: this.password,
                    }
                );

                if (response.data && response.data.token) {
                    localStorage.setItem("token", response.data.token);

                    axios.defaults.headers.common[
                        "Authorization"
                    ] = `Bearer ${response.data.token}`;

                    alert("Login berhasil!");
                    this.$router.push("/karyawan");
                } else {
                    alert("Token tidak ditemukan");
                    throw new Error("Token tidak ditemukan dalam response.");
                }
            } catch (error) {
                if (error.response) {
                    alert(
                        error.response.data.message ||
                            "Login gagal. Periksa kembali email dan password."
                    );
                } else {
                    alert("Terjadi kesalahan. Coba lagi nanti.");
                }
                console.error(error);
            }
        },
    },
};
</script>

<style scoped>
input {
    display: block;
    margin-bottom: 10px;
}
</style>
