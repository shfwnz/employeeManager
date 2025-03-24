<script>
import { useRouter } from "vue-router";
import { onMounted } from "vue";

export default {
    setup() {
        const router = useRouter();

        const logout = () => {
            localStorage.removeItem("token");
            alert("Logout berhasil!");
            router.push("/login");
        };

        onMounted(() => {
            logout();
        });

        return { logout };
    },
};
</script>
