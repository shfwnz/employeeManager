import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import EmployeeForm from "../components/EmployeeForm.vue";
import Login from "../pages/auth/Login.vue";
import Register from "../pages/auth/Register.vue";
import Employee from "../pages/Employee.vue";
import Logout from "../pages/auth/Logout.vue";
import authMiddleware from "../middleware/auth";
import EmployeeEdit from "../components/EmployeeEdit.vue";
import EmployeeList from "../pages/EmployeeList.vue";

const routes = [
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/register",
        component: Register,
        beforeEnter: authMiddleware,
    },
    {
        path: "/logout",
        component: Logout,
        beforeEnter: authMiddleware,
    },
    {
        name: "Employee",
        path: "/karyawan",
        component: Employee,
        beforeEnter: authMiddleware,
    },
    {
        name: "EmployeeList",
        path: "/karyawan-pekerjaan",
        component: EmployeeList,
        beforeEnter: authMiddleware,
    },
    {
        name: "create karyawan",
        path: "/karyawan/create",
        component: EmployeeForm,
        beforeEnter: authMiddleware,
    },
    {
        name: "edit karyawan",
        path: "/karyawan/edit/:id",
        component: EmployeeEdit,
        beforeEnter: authMiddleware,
    },
    {
        name: "tambah pekerjaan",
        path: "/karyawan-pekerjaan/add",
        component: EmployeeEdit,
        beforeEnter: authMiddleware,
    },
    {
        path: "/",
        component: Home,
        beforeEnter: authMiddleware,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
