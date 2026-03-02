<template>
    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container text-wrap">
            <a class="navbar-brand d-flex align-items-center gap-3" href="/">
                <img src="/src/assets/img/logo.png" alt="Logo" width="40" height="40" />
                <div class="text-wrap">
                    <div class="fw-bold">City College of San Fernando Pampanga</div>
                    <small class="text-muted">Student Affairs and Services</small>
                </div>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-lg-3">
                    <router-link to="/sample" class="nav-item">
                        <span class="nav-link">Dashboard</span>
                    </router-link>
                    <router-link to="/sample" class="nav-item">
                        <span class="nav-link">Records</span>
                    </router-link>
                    <router-link to="/sample" class="nav-item">
                        <span class="nav-link">Reports</span>
                    </router-link>
                </ul>
            </div>
        </div>
    </nav>
</template>