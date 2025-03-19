const authMiddleware = (to, from, next) => {
    const token = localStorage.getItem("token");
    if (!token) {
        alert("Akses ditolak. Silakan login terlebih dahulu.");
        next("/login");
    } else {
        next();
    }
};

export default authMiddleware;
