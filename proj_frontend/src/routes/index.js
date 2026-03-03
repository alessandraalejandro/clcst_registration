import { createRouter, createMemoryHistory, createWebHashHistory } from "vue-router";
import Login from '../components/Login.vue'

const routes = [
    {
        path: '/', redirect: '/login'
    },
    {
        path: '/login', name: 'Login', component: Login
    },
    {
        path: '/home', name: 'Home', component: () => import("../components/Home.vue"), 
    },
    {
        path: '/about', name: 'About', component: () => import('../components/About.vue')
    },
    {
        path: '/contact', name: 'Contact', component: () => import('../components/Contact.vue')
    },
    {
        path: '/forgot-password', name: 'ForgotPassword', component: () => import('../components/ForgotPassword.vue')
    },
    {
        path: '/reset-password/:token', name: 'ResetPassword', component: () => import('../components/ResetPassword.vue')
    },


    {
        path: '/:pathMatch(.*)*', name: 'NotFound', component: () => import('../components/NotFound.vue')
    }
];


const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router;