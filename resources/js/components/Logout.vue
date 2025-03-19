<script>
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();

        const logout = () => {
            localStorage.removeItem("token");
            alert("Logout berhasil!");
            router.push("/login");
        };

        return { logout };
    },
};
</script>
