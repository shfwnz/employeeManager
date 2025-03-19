import { createRouter, createWebHistory } from "vue-router";
import Home from "../components/Home.vue";
import EmployeeList from "../pages/EmployeeList.vue";
import EmployeeForm from "../components/EmployeeForm.vue";

const routes = [
    { path: "/", component: Home },
    { path: "/employees", component: EmployeeList },
    { path: "/employees/create", component: EmployeeForm },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
