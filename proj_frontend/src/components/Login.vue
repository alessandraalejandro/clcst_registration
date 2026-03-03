<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

import LoginSection from "./LoginSection.vue";

const router = useRouter();

onMounted(() => {});

</script>

<template>
    <div>
        <LoginSection/>
    </div>
    
</template>
