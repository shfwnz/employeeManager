<template>
    <div>
        <!-- Page Title -->
        <h2 class="font-semibold text-center mb-4 p-4">Login</h2>

        <!-- Login Form -->
        <form @submit.prevent="login">
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

            <!-- Login Button -->
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
            email: "", // User email
            password: "", // User password
        };
    },
    methods: {
        async login() {
            try {
                // Send login request
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/login",
                    {
                        email: this.email,
                        password: this.password,
                    }
                );

                // Check if token exists
                if (response.data && response.data.token) {
                    localStorage.setItem("token", response.data.token); // Store token

                    // Set authorization header
                    axios.defaults.headers.common[
                        "Authorization"
                    ] = `Bearer ${response.data.token}`;

                    alert("Login Berhasil!");
                    this.$router.push("/karyawan"); // Redirect to employee page
                } else {
                    alert("Token not found");
                    throw new Error("Token missing in response.");
                }
            } catch (error) {
                if (error.response) {
                    // Show API error message
                    alert(
                        error.response.data.message ||
                            "Login failed. Check email and password."
                    );
                } else {
                    alert("An error occurred. Try again later.");
                }
                console.error(error);
            }
        },
    },
};
</script>
