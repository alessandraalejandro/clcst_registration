<script setup>
import { ref, onMounted, computed } from "vue";
import Navbar from "./components/Navbar.vue";

const navLogin = ref([
    
        {
            title: "Home",
            link: "/",
        },
        {
            title: "About",
            link: "/",
        },
        {
            title: "Contact",
            link: "/",
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
    <div class="vh-100 w-100">
        <Navbar :loginNav="navLogin" :dashNav="navDash" />
      <div class="d-flex flex-column justify-content-center align-items-center h-100">
         <RouterView></RouterView>
      </div>
    </div>

</template>
