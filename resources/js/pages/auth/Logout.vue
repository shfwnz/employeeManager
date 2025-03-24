<script>
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();

        const logout = () => {
            localStorage.removeItem("token");
            if (!localStorage.getItem("token")) {
                alert("Logout berhasil!");
                router.push("/login");
                return true;
            } else {
                alert("Gagal logout!");
                return false;
            }
        };

        return { logout };
    },
};
</script>
