<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

const path = computed(() => route.path);



const props = defineProps({
    loginNav: {},
    dashNav: {},
});

const nav1 = computed(() => {
    return props.loginNav;
});

const nav2 = computed(() => {
    return props.dashNav;
});
</script>

<template>
    <!-- ================= NAVBAR ================= -->
    <nav
        class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">

        <div class="container text-wrap">
            <a class="navbar-brand d-flex align-items-center gap-3" href="/">
                <img
                    src="/src/assets/img/logo.png"
                    alt="Logo"
                    width="40"
                    height="40"
                />
                <div class="text-wrap">
                    <div class="fw-bold">
                        City College of San Fernando Pampanga
                    </div>
                    <small class="text-muted"
                        >Student Affairs and Services</small
                    >
                </div>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div
                class="collapse navbar-collapse justify-content-end"
                id="navbarNav"
            >
                <ul class="navbar-nav gap-lg-3" v-if="path=='/login' || path=='/about' || path=='/contact'">
                    <li class="nav-item" v-for="(n, index) in nav1" :key="index">
                        <router-link :to="n.link" class="nav-link">
                            {{ n.title }}
                        </router-link>
                    </li>
                </ul>
                
                <ul class="navbar-nav gap-lg-3" v-else-if="path=='/home'">
                    <li class="nav-item" v-for="(n, index) in nav2" :key="index">
                        <router-link :to="n.link" class="nav-link">
                            {{ n.title }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
