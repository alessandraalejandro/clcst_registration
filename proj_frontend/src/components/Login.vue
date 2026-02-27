<script setup>
import { ref, computed, onMounted } from "vue";
import hayup from "./box.vue";
import axios from "axios";

import { useRouter } from "vue-router";

const router = useRouter();



onMounted(() => {

});

const getToken = async () => {
    axios.get("/sanctum/csrf-cookie");
}

const username = ref("");
const password = ref("");

const login = async () => {
    try {
        // First, get CSRF cookie
        await axios.get('/sanctum/csrf-cookie');

        // Then, login
        const response = await axios.post('/login', {
            email: username.value,
            password: password.value
        });

        console.log(response.data);

        // Navigate **after successful login**
        router.push("/home");

    } catch (error) {
        console.error(error);
        alert('Login failed');
    }
};
</script>

<template>
    <div class="card p-3 d-flex flex-column text-start">
        <form @submit.prevent="login()" id="form">
            <label>Username</label><br>
            <input type="text" class="form-control" name="username" v-model="username" required><br>
            <label>Password</label><br>
            <input type="password" class="form-control" name="password" v-model="password" required autocomplete="off"><br>
            <button type="submit" class="btn btn-success p-2 w-100">Login</button>
        </form>
    </div>
        
</template>