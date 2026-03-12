<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

// for autoload - render first
onMounted(() => {
    getPersonAccess(currentPage.value);
    getUser();
});

const editPersonAccess = ref({});

const loginChecker = ref(false);

const personAccess = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);
const searchData = ref("");

// get all data in person table
const getPersonAccess = async (page) => {
    console.log("test-access");
    try {
        loading.value = true;
        await axios({

            method: "GET",
            url: `api/get-person-access/?page=${page}`,
            params: {
                search_data: searchData.value,
            },
        }).then(async (result) => {
            personAccess.value = result.data.data; // IMPORTANT
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
    getPersonAccess(pageValue);
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
const controlPersonAccess = async () => {
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

// delete person
const deletePersonAccess = async (p) => {
    if (!confirm("Are you sure you want to delete?")) return;

    await axios.post("api/edit-person-access", {
        mode: 2,
        id: p.id,
    });

    await getPersonAccess();
};

const setValues = (mode, data) => {
    let x = {
        id: data ? data.id : null,
        mode: mode,
        persons_id: data ? data.persons_id : "",
        roles: data ? data.roles : "",
        user_management: data ? data.user_management : "0",
        feedback_management: data ? data.feedback_management : "0",
        appointment_management: data ? data.appointment_management : "0",
        clinic_records: data ? data.clinic_records : "0",
        guidance_records: data ? data.guidance_records : "0",
        pod_records: data ? data.pod_records : "0",
        student_module: data ? data.student_module : "0",
        faculty_module: data ? data.faculty_module : "0",
        guard_module: data ? data.guard_module : "0",
        };

    editPersonAccess.value = x;
};

</script>

<template>
    <div class="container m-5" v-if="loginChecker">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <input
                v-model="searchData"
                type="text"
                @keyup.enter="getPersonAccess(1)"
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
                        <th>ID</th>
                        <th>Person ID</th>
                        <th>Role</th>
                        <th>User Management</th>
                        <th>Feedback Management</th>
                        <th>Appointment Management</th>
                        <th>Clinic Records</th>
                        <th>Guidance Records</th>
                        <th>POD Records</th>
                        <th>Student Module</th>
                        <th>Faculty Module</th>
                        <th>Guard Module</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="personAccess.length === 0 && loading">
                        <td colspan="12" class="text-center">Loading</td>
                    </tr>
                    <tr v-else-if="personAccess.length === 0 && !loading">
                        <td colspan="12" class="text-center">No record found</td>
                    </tr>
                    <tr v-else class="table-active" v-for="p in personAccess">
                        <td>{{ p.id }}</td>
                        <td>{{ p.persons_id }}</td>
                        <td>{{ p.roles }}</td>
                        <td>{{ p.user_management }}</td>
                        <td>{{ p.feedback_management }}</td>
                        <td>{{ p.appointment_management }}</td>
                        <td>{{ p.clinic_records }}</td>
                        <td>{{ p.guidance_records }}</td>
                        <td>{{ p.pod_records }}</td>
                        <td>{{ p.student_module }}</td>
                        <td>{{ p.faculty_module }}</td>
                        <td>{{ p.guard_module }}</td>
                        <td>
                            <div class="d-flex gap-2">
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
                                    @click="deletePersonAccess(p)"
                                >
                                    Delete
                                </button>
                            </div>
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
                            <div class="col-md-6">
                            <label class="form-label">
                                Person ID
                            </label>
                            <input 
                                type="number"
                                class="form-control"
                                v-model="editPersonAccess.persons_id"
                                placeholder="Enter Person ID"
                            >
                        </div>
                            <div class="col-md-6">
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


<!-- <template>
    <div class="container mt-4">
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Person ID</th>
          <th>Role</th>
          <th>User Management</th>
          <th>Feedback Management</th>
          <th>Appointment Management</th>
          <th>Clinic Records</th>
          <th>Guidance Records</th>
          <th>POD Records</th>
          <th>Student Module</th>
          <th>Faculty Module</th>
          <th>Guard Module</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>1001</td>
          <td>Admin</td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
        </tr>

        <tr>
          <td>2</td>
          <td>1002</td>
          <td>Faculty</td>
          <td><span class="badge bg-danger">No</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-danger">No</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-danger">No</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-success">Yes</span></td>
          <td><span class="badge bg-danger">No</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template> -->