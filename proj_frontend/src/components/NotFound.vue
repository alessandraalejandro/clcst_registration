<template>
  <div class="not-found d-flex align-items-center justify-content-center text-center text-white">
    <div>
      <h1 class="display-1 fw-bold">404</h1>
      <p class="lead mb-4">Page Not Found</p>
      <router-link to="/" class="btn btn-light btn-lg px-4 text-danger fw-bold">
        Back to Home
      </router-link>
    </div>
  </div>
</template>

<style scoped>
.not-found {
  height: 100vh;
  background: linear-gradient(135deg, #dc3545, #b02a37);
}
.display-1 {
  font-size: 9rem;
  letter-spacing: 6px;
}
</style>