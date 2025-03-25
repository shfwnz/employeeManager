<template></template>

<script>
import { useRouter } from "vue-router";
import { onMounted } from "vue";

export default {
    setup() {
        const router = useRouter();

        const logout = () => {
            // Remove token
            localStorage.removeItem("token");
            alert("Logout berhasil!");
            router.push("/login"); // Redirect
        };

        onMounted(() => {
            logout();
        });

        return { logout };
    },
};
</script>
