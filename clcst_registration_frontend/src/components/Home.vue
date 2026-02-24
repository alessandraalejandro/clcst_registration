<script setup>
import { ref, computed, onMounted } from "vue";
import hayup from "./box.vue";

const data = ref("test princess sssssssssssss");

onMounted(() => {
    data.value = "ssss";
});

let araa = [
    {
        firstname: "prince",
        lastname: "pelaez",
        iscute: false,
    },
    {
        firstname: "arron",
        lastname: "gomez",
        iscute: true,
    },
];

const btnClick = (a) => {
    alert(a.lastname + a.firstname);
};
</script>

<template>
    <div v-for="(a, index) in araa">
        <div>
            <input type="text" :value="a.firstname" v-show="a.iscute == true" />
            <input type="text" :value="a.lastname" />
            <button
                type="button"
                class="btn btn-sm btn-success"
                @click="btnClick(araa[0])"
            >
                Click Me
            </button>
        </div>
    </div>
</template>
