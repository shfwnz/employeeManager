<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label>Email:</label>
                <input v-model="email" type="email" required />
            </div>

            <div>
                <label>Password:</label>
                <input v-model="password" type="password" required />
            </div>

            <button type="submit">Login</button>
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

                localStorage.setItem("token", response.data.token);
                alert("Login berhasil!");
                this.$router.push("/dashboard");
            } catch (error) {
                alert("Login gagal. Periksa kembali email dan password.");
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
