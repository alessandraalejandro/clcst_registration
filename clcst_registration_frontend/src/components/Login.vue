<script setup>
import { ref, computed, onMounted } from "vue";
import hayup from "./Nav.vue";
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
        await getToken();
        await axios({
            method:"POST",
            url:"/login",
            data:{
                email:username.value,
                password:password.value
            }
        }).then(async(results) => {
            router.push("/home");
            console.log(results);
        });
        console.log(username.value);
        console.log(password.value);
};
</script>

<template>
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="card p-3 d-flex flex-column text-start">
            <form @submit.prevent="login()" id="form">
                <label class="form-label">Username</label><br>
                <input type="text" class="form-control" name="username" v-model="username" required><br>
                <label class="form-label">Password</label><br>
                <input type="password" class="form-control" name="password" v-model="password" required autocomplete="off"><br>
                <button type="submit" class="btn btn-success p-2 w-100">Login</button>
            </form>
        </div>
    </div>
        
</template>