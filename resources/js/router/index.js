import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import EmployeeList from "../pages/EmployeeList.vue";
import EmployeeForm from "../components/EmployeeForm.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import Logout from "../components/logout.vue";
import authMiddleware from "../middleware/auth";

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
        path: "/dashboard",
        component: Dashboard,
    },
    {
        path: "/",
        component: Home,
    },
    {
        path: "/employee",
        component: EmployeeList,
        beforeEnter: authMiddleware,
    },
    {
        path: "/employee/create",
        component: EmployeeForm,
        beforeEnter: authMiddleware,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
