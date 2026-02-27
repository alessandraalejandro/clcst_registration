<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";

// for autoload
onMounted(() => {
    getPerson();
});


const editPerson = ref({})

const person = ref([]);
const loading = ref(true);
const getPerson = async () => {
    try {
        await axios({
            method: "GET",
            url: "api/get-person",
        }).then(async (result) => {
            person.value = result.data;
            loading.value = false;
        });
    } catch (error) {
        console.error(error);
        alert("Login failed");
    }
};

const addPerson = async () => {
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
        alert("Login failed");
    }
};

const setValues = (mode, data ) =>{
  let x = {
    mode: mode,
    person_id: data? data.person_id : '',
    person_fname: data? data.person_fname : '',
    person_mname: data? data.person_mname : '',
    person_lname: data? data.person_lname : '',
    person_suffix: data? data.person_suffix : '',
    person_bday: data? data.person_bday : '',
    person_contact: data? data.person_contact : '',
  }

  editPerson.value = x


}
</script>

<template>
    <button type="button" @click="getPerson()">get person</button>
    <table class="table">
        <thead>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Suffix</th>
            <th>Birthday</th>
            <th>Contact</th>
        </thead>
        <tbody>
            <tr v-if="!Object.keys(person).length && loading == true">
                <td colspan="6" class="text-center">Loading</td>
            </tr>
            <tr v-else-if="!Object.keys(person).length && loading == false">
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
                        @click = "setValues(1, p)"
                    >
                        Edit Record
                    </button>
                </td>
                <td><button>Delete</button></td>
            </tr>
        </tbody>
    </table>

    <!-- Button trigger modal -->
    <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
        @click = "setValues(0)"
    >
        Insert Record
    </button>

    <!-- Modal -->
    <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="addPerson">
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
</template>
