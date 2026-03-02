<template>
    <!-- ================= HERO ================= -->
        <section
        >
            <div class="container py-5">
                <div class="row align-items-center g-5">
                    <!-- LEFT SIDE -->
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold">
                            Student Affairs and Services
                            <span class="text-danger">(SAS)</span>
                        </h1>

                        <p class="lead text-muted mt-4">
                            A web-based platform for selected SAS services
                            including Guidance, Clinic, and Prefect of
                            Discipline (POD).
                        </p>

                        <div class="mt-4 d-flex flex-wrap gap-2">
                            <span class="badge bg-primary p-2">Secure</span>
                            <span class="badge bg-success p-2"
                                >Confidential</span
                            >
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
                                        <label class="form-label"
                                            >Password</label
                                        >
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="password"
                                            placeholder="Enter your password"
                                            required
                                            autocomplete="off"
                                        />
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</template>