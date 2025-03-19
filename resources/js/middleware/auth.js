export default function auth({ next }) {
    const token = localStorage.getItem("token");

    if (!token) {
        return next({ path: "/login" });
    }

    return next();
}
