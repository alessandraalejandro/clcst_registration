<script setup>
import { ref } from "vue";
import axios from "axios";

const email = ref("");
const status = ref("");
const errors = ref(null);
const loading = ref(false);

const submit = async () => {
    loading.value = true;
    status.value = "";
    errors.value = null;

    try {
        await axios.get("/sanctum/csrf-cookie");

        const response = await axios.post("/forgot-password", {
            email: email.value,
        });

        status.value = response.data.status;
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors;
        }
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="container py-5">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h4 class="fw-bold text-center mb-4">
                        Forgot Password
                    </h4>

                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                type="email"
                                v-model="email"
                                class="form-control"
                                required
                            />
                            <small v-if="errors?.email" class="text-danger">
                                {{ errors.email[0] }}
                            </small>
                        </div>

                        <div class="d-grid">
                            <button
                                class="btn btn-danger"
                                :disabled="loading"
                            >
                                {{ loading ? "Sending..." : "Send Reset Link" }}
                            </button>
                        </div>
                    </form>

                    <div
                        v-if="status"
                        class="alert alert-success mt-3 text-center"
                    >
                        {{ status }}
                    </div>

                    <div class="text-center mt-3">
                        <RouterLink to="/" class="small text-muted">
                            Back to login
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>