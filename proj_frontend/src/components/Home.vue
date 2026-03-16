<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

// for autoload - render first
onMounted(() => {
    getPerson(currentPage.value);
    getUser();
});

const editPerson = ref({});
const editPersonAccess = ref({});

const loginChecker = ref(false);

const person = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);
const searchData = ref("");
const personAccess = ref([]);

const getPersonAccess = async (id) => {
    console.log("test-access");
    try {
        loading.value = true;
        await axios({
            method: "GET",
            url: `/api/get-user-access/${id}`,
        }).then(async (result) => {
            personAccess.value = result.data.data; // IMPORTANT
            setValues1(personAccess.value);
            console.log(personAccess.value)
        });
    } catch (err) {
        return err;
    }
};

const controlPersonAccess = async () => {
    console.log("testing")
    try {
        await axios({
            method: "POST",
            url: "api/edit-person-access",
            data: editPersonAccess.value,
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

const setValues1 = (data) => {
    let x1 = {
        account_id: data ? data.account_id : null,  
        roles: data ? data.roles : "",
        user_management: data ? data.user_management : 0,
        feedback_management: data ? data.feedback_management : 0,
        appointment_management: data ? data.appointment_management : 0,
        clinic_records: data ? data.clinic_records : 0,
        guidance_records: data ? data.guidance_records : 0,
        pod_records: data ? data.pod_records : 0,
        student_module: data ? data.student_module : 0,
        faculty_module: data ? data.faculty_module : 0,
        guard_module: data ? data.guard_module : 0,
        };

    editPersonAccess.value = x1;
};

// get all data in person table
const getPerson = async (page) => {
    console.log("test");
    // try {
    //     loading.value = true;

    //     const result = await axios.get(`api/get-person/?page=${page}`);

    //     person.value = result.data.data; // IMPORTANT
    //     currentPage.value = result.data.current_page;
    //     lastPage.value = result.data.last_page;

    //     loading.value = false;

    // } catch (error) {
    //     console.error(error);
    // }
    try {
        loading.value = true;
        await axios({
            method: "GET",
            url: `api/get-person/?page=${page}`,
            params: {
                search_data: searchData.value,
            },
        }).then(async (result) => {
            person.value = result.data.data; // IMPORTANT
            currentPage.value = result.data.current_page;
            lastPage.value = result.data.last_page;
            // searchPerson.value = person.value; //
            loading.value = false;
        });
    } catch (err) {
        return err;
    }
};

const changePage = (pageValue) => {
    // if (page < 1 || page > lastPage.value) return;
    getPerson(pageValue);
};

// get if user is logged in for session
const getUser = async () => {
    try {
        await axios({
            method: "GET",
            url: "api/user",
        })
            .then((result) => {
                loginChecker.value = result ? true : false;
            })
            .catch((err) => {
                alert("Unauthorized Session, Please Log In");
                router.push("/");
            });
    } catch (error) {
        console.error(error);
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
        person_id: p.person_id,
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
        person_email: data ? data.person_email : "",
        person_password: data ? data.person_password : "",
    };

    editPerson.value = x;
};

// front end search - realtime for less records
// const searchDataTest = ref("");
//const searchPerson = ref([]);
// const realTimeSearch = () => {
//     console.log(searchDataTest.value);

//     const search = searchDataTest.value.toLowerCase();

//     searchPerson.value = person.value.filter((e) => {
//         return (
//             e.person_fname?.toLowerCase().includes(search) ||
//             e.person_mname?.toLowerCase().includes(search) ||
//             e.person_lname?.toLowerCase().includes(search) ||
//             e.person_suffix?.toLowerCase().includes(search)
//         );
//     });
// };
</script>

<template>
    <div class="container m-5" v-if="loginChecker">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <input
                v-model="searchData"
                type="text"
                @keyup.enter="getPerson(1)"
                placeholder="Search"
                class="form-control w-25"
            />

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                @click="setValues(0)"
            >
                Insert
            </button>
        </div>

        <!-- <input
            v-model="searchDataTest"
            type="text"
            @keyup="realTimeSearch()"
            placeholder="Search"
        /> -->
        <!-- Button trigger modal -->

        <div class="table-responsive overflow-auto position-relative" style="height: 320px;">
            <table class="table table-striped table-bordered">
                <thead class="table-dark" style="position: sticky; top: 0;">
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
                            <div class="d-flex gap-2">
                                <button
                                    type="button"
                                    class="btn btn-warning px-4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal1"
                                    @click="getPersonAccess(p.account_id)"
                                >
                                    Access
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-primary px-4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    @click="setValues(1, p)"
                                >
                                    Edit
                                </button>

                                <button
                                    class="btn btn-danger"
                                    @click="deletePerson(p)"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div
            class="modal fade"
            id="exampleModal1"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <form class="row g-3" @submit.prevent="controlPersonAccess">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            User Permission
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-12">
                            <label class="form-label">Role</label>
                            <select class="form-control" v-model="editPersonAccess.roles">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Guard">Guard</option>
                                <option value="Student">Student</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.user_management" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                User Management
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.feedback_management" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Feedback Management
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.appointment_management" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Appointment Management
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.clinic_records" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Clinic Records
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.guidance_records" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Guidance Records
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.pod_records" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                POD Records
                            </label>
                        </div>

                         <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.student_module" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Student Module
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.faculty_module" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Faculty Module
                            </label>
                        </div>

                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox"
                                v-model="editPersonAccess.guard_module" :true-value="1" :false-value="0">
                            <label class="form-check-label">
                                Guard Module
                            </label>
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
                </div>
                </form>
            </div>
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
                <form class="row g-3" @submit.prevent="controlPerson">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            User Record
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="editPerson.person_fname"
                        />
                        </div>

                        <div class="col-md-6">
                        <label class="form-label">Middle Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="editPerson.person_mname"
                        />
                        </div>

                        <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="editPerson.person_lname"
                        />
                        </div>

                        <div class="col-md-3">
                        <label class="form-label">Suffix</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="editPerson.person_suffix"
                        />
                        </div>

                        <div class="col-md-4">
                        <label class="form-label">Birthday</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="editPerson.person_bday"
                        />
                        </div>

                        <div class="col-md-6">
                        <label class="form-label">Contact</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="editPerson.person_contact"
                        />
                        </div>
                        
                        <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            v-model="editPerson.email"
                        />
                        </div>

                        <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            v-model="editPerson.password"
                        />
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
                </div>
                </form>
            </div>
        </div>
        
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
