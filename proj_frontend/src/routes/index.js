import { createRouter, createMemoryHistory, createWebHashHistory } from "vue-router";
import Home from '../components/Home.vue'
import Sample from '../components/sample.vue'
const routes = [
    {
        path: '/',
        redirect: '/login'
    },
    // {
    //     path: '/:pathMatch(.*)*',
    //     name: 'NotFound',
    //     component: () => import('../components/NotFound.vue')
    // },
    {
        path: '/login', name: 'Login', component: () => import("../components/Login.vue")
    },
    {
        path: '/home', name: 'Home', component: Home
    },
    {
        path: '/sample', name: 'Sample', component: Sample
    }
];


const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router;