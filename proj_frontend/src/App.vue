<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import Navbar from "./components/Navbar.vue";
import FooterSection from "./components/FooterSection.vue";
import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();

const navLogin = ref([
    {
        title: "Home",
        link: "/login",
    },
    {
        title: "About",
        link: "/about",
    },
    {
        title: "Contact",
        link: "/contact",
    },
]);

const navDash = ref([
    {
        title: "Dashboard",
        link: "/home",
        category: "navigate",
    },
    {
        title: "User Management",
        link: "/users",
        category: "management",
        accessKey: "user_management",
    },
    {
        title: "Feedback Management",
        link: "/feedback-management",
        category: "management",
        accessKey: "feedback_management",
    },
    {
        title: "Appointment Management",
        link: "/appointment-management",
        category: "management",
        accessKey: "appointment_management",
    },
    {
        title: "Clinic Records",
        link: "/clinic-records",
        category: "records",
        accessKey: "clinic_records",
    },
    {
        title: "Guidance Records",
        link: "/guidance-records",
        category: "records",
        accessKey: "guidance_records",
    },
    {
        title: "POD Records",
        link: "/pod-records",
        category: "records",
        accessKey: "pod_records",
    },
    {
        title: "Student Module",
        link: "/student-module",
        category: "navigate",
        accessKey: "student_module",
    },
    {
        title: "Faculty Module",
        link: "/faculty-module",
        category: "navigate",
        accessKey: "faculty_module",
    },
    {
        title: "Guard Module",
        link: "/guard-module",
        category: "navigate",
        accessKey: "guard_module",
    },
]);

</script>

<template>
  <!-- Layout WITHOUT navbar (NotFound) -->
  <div class="vh-100 w-100" v-if="route.name === 'NotFound'">
    <RouterView />
  </div>

  <!-- Layout WITH navbar -->
  <div class="vh-100 w-100" v-else>
    <Navbar :loginNav="navLogin" :dashNav="navDash" />

    <div class="d-flex flex-column justify-content-center align-items-center h-100">
      <RouterView />
    </div>
    <div class="d-flex">
        <FooterSection />
    </div>
    
    
  </div>
</template>