<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

import LoginSection from "./LoginSection.vue";
import About from "./About.vue";
import FooterSection from "./FooterSection.vue";

const router = useRouter();

onMounted(() => {});

const getToken = async () => {
    axios.get("/sanctum/csrf-cookie");
};

const username = ref("");
const password = ref("");

const login = async () => {
    try {
        // First, get CSRF cookie
        await axios.get("/sanctum/csrf-cookie");

        // Then, login
        const response = await axios.post("/login", {
            email: username.value,
            password: password.value,
        });

        console.log(response.data);

        // Navigate **after successful login**
        router.push("/home");
    } catch (error) {
        console.error(error);
        alert("Login failed");
    }
};
</script>

<template>
    <div >
        <LoginSection/>
    </div>
    
    
</template>
