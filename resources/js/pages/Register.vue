<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div>
                <label>Nama:</label>
                <input v-model="name" type="text" required />
            </div>

            <div>
                <label>Email:</label>
                <input v-model="email" type="email" required />
            </div>

            <div>
                <label>Password:</label>
                <input v-model="password" type="password" required />
            </div>

            <button type="submit">Daftar</button>
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
        };
    },
    methods: {
        async register() {
            try {
                await axios.post("http://127.0.0.1:8000/api/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
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

<style scoped>
input {
    display: block;
    margin-bottom: 10px;
}
</style>
