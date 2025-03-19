import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import EmployeeList from "../pages/EmployeeList.vue";
import EmployeeForm from "../components/EmployeeForm.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import authMiddleware from "../middleware/auth";

const routes = [
    { path: "/login", component: Login },
    { path: "/register", component: Register },
    {
        path: "/dashboard",
        component: Dashboard,
        beforeEnter: authMiddleware,
    },
    { path: "/", component: Home },
    { path: "/employees", component: EmployeeList },
    { path: "/employees/create", component: EmployeeForm },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
