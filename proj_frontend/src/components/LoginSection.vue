<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const username = ref("");
const password = ref("");
const showPassword = ref(false); // <-- Track if password is visible

const login = async () => {
    try {
        // First, get CSRF cookie
        await axios.get("/sanctum/csrf-cookie");

        // Then, login
        const response = await axios.post("/login", {
            email: username.value,
            password: password.value,
        });

        console.log(response.data);

        // Navigate **after successful login**
        router.push("/home");
    } catch (error) {
        console.error(error);
        alert("Login failed");
    }
};
</script>

<template>
    <!-- ================= HERO ================= -->
    <section>
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <!-- LEFT SIDE -->
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold">
                        Student Affairs and Services
                        <span class="text-danger">(SAS)</span>
                    </h1>

                    <p class="lead text-muted mt-4">
                        A web-based platform for selected SAS services including
                        Guidance, Clinic, and Prefect of Discipline (POD).
                    </p>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <span class="badge bg-primary p-2">Secure</span>
                        <span class="badge bg-success p-2">Confidential</span>
                        <span class="badge bg-purple p-2 bg-secondary"
                            >Role-Based</span
                        >
                    </div>
                </div>

                <!-- RIGHT LOGIN -->
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <h4 class="card-title text-center mb-4 fw-bold">
                                Welcome Back
                            </h4>

                            <form @submit.prevent="login">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        v-model="username"
                                        placeholder="Enter your email"
                                        required
                                        autofocus
                                    />
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <div
                                        style="
                                            position: relative;
                                            display: flex;
                                            align-items: center;
                                        "
                                    >
                                        <input
                                            :type="
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            v-model="password"
                                            placeholder="Enter your password"
                                            required
                                            autocomplete="off"
                                            class="form-control"
                                            style="
                                                padding-right: 2.5rem;
                                                flex: 1;
                                            "
                                        />
                                        <span
                                            @click="
                                                showPassword = !showPassword
                                            "
                                            style="
                                                position: absolute;
                                                right: 0.75rem;
                                                cursor: pointer;
                                                display: flex;
                                                align-items: center;
                                                height: 100%;
                                            "
                                        >
                                            <!-- Eye Icon -->
                                            <svg
                                                v-if="!showPassword"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 1.3rem;
                                                    height: 1.3rem;
                                                "
                                            >
                                                <path
                                                    d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"
                                                />
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    fill="#fff"
                                                />
                                            </svg>

                                            <svg
                                                v-else
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                                style="
                                                    width: 1.3rem;
                                                    height: 1.3rem;
                                                "
                                            >
                                                <path
                                                    d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7 1.94 0 3.75-.58 5.3-1.57l3.41 3.41 1.41-1.41L3.41 3.41 2 4.82l3.41 3.41C7.25 7.58 9.06 7 11 7c5 0 9.27 3.11 11 7-1.04 2.34-2.84 4.29-5.1 5.49l1.45 1.45C21.77 17.48 23 14.93 23 12c-1.73-3.89-6-7-11-7z"
                                                />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="d-grid">
                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-lg"
                                    >
                                        Sign In
                                    </button>
                                </div>
                            </form>
                            <span class="text-end mb-3">
                                <RouterLink
                                    to="/forgot-password"
                                    class="text-decoration-none small text-muted"
                                >
                                    Forgot Password?
                                </RouterLink>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
