import { createRouter, createMemoryHistory, createWebHashHistory } from "vue-router";
import Home from '../components/Home.vue'
const routes = [

    {
        path: '/login', name: 'Login', component: () => import("../components/Login.vue")
    },
    {
        path: '/home', name: 'Home', component: Home
    }
];


const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router;