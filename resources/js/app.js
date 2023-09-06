require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import Router from '@/routers';
import VueAxios from 'vue-axios';
import store from '@/store';
const app = createApp(App);
app.use(VueAxios, axios);
app.use(Router)
app.use(store);
app.mount('#app');