<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import Navbar from "./components/Navbar.vue";
import FooterSection from "./components/FooterSection.vue";
import { useRoute, useRouter } from "vue-router";

onMounted(() => {
   // getUser();

});

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
    },
    {
        title: "Feedback Management",
        link: "/feedback-management",
        category: "management",
    },
    {
        title: "Appointment Management",
        link: "/appointment-management",
        category: "management",
    },
    {
        title: "Clinic Records",
        link: "/clinic-records",
        category: "records",
    },
    {
        title: "Guidance Records",
        link: "/guidance-records",
        category: "records",
    },
    {
        title: "POD Records",
        link: "/pod-records",
        category: "records",
    },
    {
        title: "Student Module",
        link: "/student-module",
        category: "navigate",
    },
    {
        title: "Faculty Module",
        link: "/faculty-module",
        category: "navigate",
    },
    {
        title: "Guard Module",
        link: "/guard-module",
        category: "navigate",
    },
]);

// const getUser = async () => {
//     try {
//         const result1 = await axios.get("api/user");
//         loginChecker.value = result1 ? true : false;
//     } catch (err) {
//         alert("Unauthorized Session, Please Log In");
//         router.push("/");
//     }
// };
// const getUser = async () => {
//     try {
//         await axios({
//             method: "GET",
//             url: "api/user",
//         })
//             .then((result1) => {
//                 axios({
//                     method: "GET",
//                     url: "api/get-user-access/1",
//                 })
//                     .then((result2) => {
//                         console.log(result2);
//                         //loginChecker.value = result1 ? true : false;
                        
//                     })
                
//             })
//             .catch((err) => {
//                 alert("Unauthorized Session, Please Log In");
//                 router.push("/");
//             });
//     } catch (error) {
//         console.error(error);
//     }
// };
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
