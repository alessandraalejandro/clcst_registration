<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

// for autoload - render first
onMounted(() => {
    getPerson(1);
    getUser();
});

const editPerson = ref({});

const loginChecker = ref(false);

const person = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);

// get all data in person table
const getPerson = async (page = 1) => {
    try {
        loading.value = true;

        const result = await axios.get(`api/get-person?page=${page}`);

        person.value = result.data.data; // IMPORTANT
        currentPage.value = result.data.current_page;
        lastPage.value = result.data.last_page;

        loading.value = false;

    } catch (error) {
        console.error(error);
    }
};

const changePage = (page) => {
    if (page < 1 || page > lastPage.value) return;
    getPerson(page);
};

// get if user is logged in for session
const getUser = async () => {
    try {
        await axios({
            method: "GET",
            url: "api/user",
        }).then((result) => {
            loginChecker.value = result ? true: false; 
        }).catch((err) => {
            alert("Unauthorized Session, Please Log In");
            router.push("/");
        });
    } catch (error) {
        console.error(error);
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

// add or edit person
const controlPerson = async () => {
    try {
        await axios({
            method: "POST",
            url: "api/edit-person",
            data: editPerson.value,
        }).then(async (result) => {
            console.log(result.status);
            if (result.status == 200) {
                alert("Successfully Added");
                location.reload();
            } else {
                alert("Failed");
            }
        });
    } catch (error) {
        console.error(error);
    }
};

// delete person
const deletePerson = async (p) => {
    if (!confirm("Are you sure you want to delete?")) return;

    await axios.post("api/edit-person", {
        mode: 2,
        person_id: p.person_id
    });

    await getPerson();
};

const setValues = (mode, data) => {
    let x = {
        mode: mode,
        person_id: data ? data.person_id : "",
        person_fname: data ? data.person_fname : "",
        person_mname: data ? data.person_mname : "",
        person_lname: data ? data.person_lname : "",
        person_suffix: data ? data.person_suffix : "",
        person_bday: data ? data.person_bday : "",
        person_contact: data ? data.person_contact : "",
    };

    editPerson.value = x;
};

</script>

<template>
    <div class="container m-5" v-if="loginChecker">
    
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            @click="setValues(0)"
        >
            Insert Record
        </button>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Suffix</th>
                    <th>Birthday</th>
                    <th>Contact</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="person.length === 0 && loading">
                        <td colspan="6" class="text-center">Loading</td>
                    </tr>
                    <tr v-else-if="person.length === 0 && !loading">
                        <td colspan="6" class="text-center">No record found</td>
                    </tr>
                    <tr v-else class="table-active" v-for="p in person">
                        <td>{{ p.person_fname }}</td>
                        <td>{{ p.person_mname }}</td>
                        <td>{{ p.person_lname }}</td>
                        <td>{{ p.person_suffix }}</td>
                        <td>{{ p.person_bday }}</td>
                        <td>{{ p.person_contact }}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                @click="setValues(1, p)"
                            >
                                Edit Record
                            </button>

                            <button class="btn btn-danger" @click="deletePerson(p)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form class="modal-content" @submit.prevent="controlPerson">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Modal title
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="firstname">First Name</label><br />
                            <input
                                type="text"
                                v-model="editPerson.person_fname"
                            /><br />
                            <label for="middlename">Middle Name</label><br />
                            <input
                                type="text"
                                v-model="editPerson.person_mname"
                            /><br />
                            <label for="lastname">Last Name</label><br />
                            <input
                                type="text"
                                v-model="editPerson.person_lname"
                            /><br />
                            <label for="suffix">Suffix</label><br />
                            <input
                                type="text"
                                v-model="editPerson.person_suffix"
                            /><br />
                            <label for="bday">Birthday</label><br />
                            <input
                                type="date"
                                v-model="editPerson.person_bday"
                            /><br />
                            <label for="contact">Contact</label><br />
                            <input
                                type="text"
                                v-model="editPerson.person_contact"
                            /><br />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <button type="button" @click="logout()">Logout</button>


        <div class="mt-3 d-flex justify-content-center align-items-center mb5">
            <button 
                class="btn btn-secondary me-2"
                @click="changePage(currentPage - 1)"
                :disabled="currentPage === 1"
            >
                Prev
            </button>

            <button
                v-for="page in lastPage"
                :key="page"
                class="btn btn-outline-primary me-1"
                :class="{ 'btn-primary text-white': page === currentPage }"
                @click="changePage(page)"
            >
                {{ page }}
            </button>

            <button 
                class="btn btn-secondary ms-2"
                @click="changePage(currentPage + 1)"
                :disabled="currentPage === lastPage"
            >
                Next
            </button>
        </div>
    </div>

</template>
