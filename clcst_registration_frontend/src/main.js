import { createApp } from 'vue'
import router from './routes'

import './axios'
import './style.css'
import 'bootstrap/dist/css/bootstrap.css'
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js'
import App from './App.vue'

const app = createApp(App);

app.use(router, bootstrap)
app.mount('#app')