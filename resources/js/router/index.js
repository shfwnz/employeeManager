import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import EmployeeForm from "../components/EmployeeForm.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Employee from "../pages/Employee.vue";
import Logout from "../components/Logout.vue";
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
    },
    {
        name: "EmployeeList",
        path: "/karyawan-pekerjaan",
        component: EmployeeList,
    },
    {
        name: "create karyawan",
        path: "/karyawan/create",
        component: EmployeeForm,
    },
    {
        name: "edit karyawan",
        path: "/karyawan/edit/:id",
        component: EmployeeEdit,
    },
    {
        name: "tambah pekerjaan",
        path: "/karyawan-pekerjaan/add",
        component: EmployeeEdit,
    },
    {
        path: "/",
        component: Home,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
