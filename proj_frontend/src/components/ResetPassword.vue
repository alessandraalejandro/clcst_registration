<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();

const token = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const errors = ref(null);
const loading = ref(false);

onMounted(() => {
    token.value = route.params.token;
    email.value = route.query.email;
});

const submit = async () => {
    loading.value = true;
    errors.value = null;

    try {
        await axios.post("/reset-password", {
            token: token.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
        });

        router.push("/");
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
                        Reset Password
                    </h4>

                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                type="email"
                                v-model="email"
                                class="form-control"
                                readonly
                            />
                        </div>

                        <div class="mb-3">
                            <label>New Password</label>
                            <input
                                type="password"
                                v-model="password"
                                class="form-control"
                                required
                            />
                            <small v-if="errors?.password" class="text-danger">
                                {{ errors.password[0] }}
                            </small>
                        </div>

                        <div class="mb-4">
                            <label>Confirm Password</label>
                            <input
                                type="password"
                                v-model="password_confirmation"
                                class="form-control"
                                required
                            />
                        </div>

                        <div class="d-grid">
                            <button
                                class="btn btn-danger"
                                :disabled="loading"
                            >
                                {{ loading ? "Resetting..." : "Reset Password" }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>