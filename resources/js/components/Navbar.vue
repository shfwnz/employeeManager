<template>
    <nav class="bg-cyan-300 p-4">
        <ul class="flex space-x-4">
            <li>
                <router-link
                    to="/login"
                    class="text-white hover:text-black font-medium"
                >
                    Login
                </router-link>
            </li>
            <li>
                <router-link
                    to="/register"
                    class="text-white hover:text-black font-medium"
                >
                    Register
                </router-link>
            </li>
            <li>
                <router-link
                    to="/logout"
                    class="text-white hover:text-black font-medium"
                >
                    Logout
                </router-link>
            </li>
            <li>
                <router-link
                    to="/"
                    class="text-white hover:text-black font-medium"
                >
                    Home
                </router-link>
            </li>
            <li>
                <router-link
                    to="/karyawan"
                    class="text-white hover:text-black font-medium"
                >
                    Karyawan
                </router-link>
            </li>
            <li>
                <router-link
                    to="/karyawan-pekerjaan"
                    class="text-white hover:text-black font-medium"
                >
                    Pekerjaan Karyawan
                </router-link>
            </li>
        </ul>
    </nav>
</template>
