import { createRouter, createMemoryHistory, createWebHistory } from "vue-router";
import Login from '../components/Login.vue'

const routes = [
    {
        path: '/', redirect: '/login'
    },
    {
        path: '/login', name: 'Login', component: Login
    },
    {
        path: '/home', name: 'Home', component: () => import("../components/Home.vue")
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
        path: '/users', name: 'Users', component: () => import('../components/UserManagement.vue')
    },
    {
        path: '/student-module', name: 'StudentModule', component: () => import('../components/StudentModule.vue')
    },
    {
        path: '/guard-module', name: 'GuardModule', component: () => import('../components/GuardModule.vue')
    },
    {
        path: '/faculty-module', name: 'FacultyModule', component: () => import('../components/FacultyModule.vue')
    },
    {
        path: '/feedback-management', name: 'FeedbackManagement', component: () => import('../components/FeedbackManagement.vue')
    },
    {
        path: '/appointment-management', name: 'AppointmentManagement', component: () => import('../components/AppointmentManagement.vue')
    },
    {
        path: '/clinic-records', name: 'ClinicRecords', component: () => import('../components/ClinicRecords.vue')
    },
    {
        path: '/guidance-records', name: 'GuidanceRecords', component: () => import('../components/GuidanceRecords.vue')
    },
    {
        path: '/pod-records', name: 'PODRecords', component: () => import('../components/PODRecords.vue')
    },


    {
        path: '/:pathMatch(.*)*', name: 'NotFound', component: () => import('../components/NotFound.vue')
    }
];


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router;