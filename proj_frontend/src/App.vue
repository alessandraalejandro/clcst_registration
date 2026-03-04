<script setup>
import { ref, onMounted, computed } from "vue";
import Navbar from "./components/Navbar.vue";
import FooterSection from "./components/FooterSection.vue";
import { useRoute } from "vue-router";

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
        link: "/",
    },
    {
        title: "Records",
        link: "/",
    },
    {
        title: "Reports",
        link: "/",
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
