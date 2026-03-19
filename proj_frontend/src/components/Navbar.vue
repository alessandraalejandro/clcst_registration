<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();
const userAccess = ref({});

onMounted(() => {
   getUser();

});
const allowedPathsGuest = ["/login", "/about", "/contact"];

const showGuestNavbar = computed(() => {
    return allowedPathsGuest.includes(route.path);
});

const allowedPaths = [
    "/home",
    "/users",
    "/student-module",
    "/faculty-module",
    "/guard-module",
    "/feedback-management",
    "/appointment-management",
    "/clinic-records",
    "/guidance-records",
    "/pod-records",
];

const showAdminNavbar = computed(() => {
    return allowedPaths.includes(route.path);
});

const getUser = async () => {
    try {
        const result = await axios.get("api/user");
        const value = await axios.get(`/api/get-user-access/${result.data.id}`);
        //loginChecker.value = result1 ? true : false;
        userAccess.value = value.data.data;
        console.log(value.data.data)
    } catch (err) {
        //alert("Unauthorized Session, Please Log In");
        router.push("/");
    }
};

const logout = async () => {
    if (confirm("Are you sure you want to logout") == true) {
        await axios.post("/logout");
        alert("Logged Out");
        router.push("/login");
    } else {
        return false;
    }
};

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

const getMenuByCategory = (category) => {
    return nav2.value.filter(
        (i) =>
            i.category === category &&
            userAccess.value?.[i.accessKey] === 1
    );
};

const settingsMenu = computed(() => getMenuByCategory("navigate"));
const managementMenu = computed(() => getMenuByCategory("management"));
const recordsMenu = computed(() => getMenuByCategory("records"));

</script>

<template>
    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container text-wrap">
            <router-link
                class="navbar-brand d-flex align-items-center gap-3"
                to="/home"
            >
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
            </router-link>

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
                <ul class="navbar-nav gap-lg-3" v-if="showGuestNavbar">
                    <li
                        class="nav-item"
                        v-for="(n, index) in nav1"
                        :key="index"
                    >
                        <router-link :to="n.link" class="nav-link">
                            {{ n.title }}
                        </router-link>
                    </li>
                </ul>

                <ul class="navbar-nav gap-lg-3" v-else-if="showAdminNavbar">
                    <li class="nav-item dropdown" v-if="settingsMenu.length">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                        >
                            Settings
                        </button>

                        <ul class="dropdown-menu">
                            <li v-for="n in settingsMenu" :key="n.title">
                                <router-link :to="n.link" class="dropdown-item">
                                    {{ n.title }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown" v-if="managementMenu.length">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                        >
                            Management
                        </button>

                        <ul class="dropdown-menu">
                            <li v-for="n in managementMenu" :key="n.title">
                                <router-link :to="n.link" class="dropdown-item">
                                    {{ n.title }}
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown" v-if="recordsMenu.length">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                        >
                            Records
                        </button>

                        <ul class="dropdown-menu">
                            <li v-for="n in recordsMenu" :key="n.title">
                                <router-link :to="n.link" class="dropdown-item">
                                    {{ n.title }}
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <button class="btn btn-danger" @click="logout">
                            Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
