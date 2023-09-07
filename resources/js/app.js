require('./bootstrap');
import {  createApp ,ref } from 'vue';
import App from './App.vue';

import SimpleTypeahead from 'vue3-simple-typeahead';
import 'vue3-simple-typeahead/dist/vue3-simple-typeahead.css'; //Optional default CSS
const app = createApp(App);
app.use(SimpleTypeahead);
import BootstrapVue3 from 'bootstrap-vue-3';

import "bootstrap/dist/css/bootstrap.min.css";

// import "bootstrap";
import Router from '@/routers';

import config from './config';
import VueAxios from 'vue-axios';
import axios from 'axios';
import store from '@/store';
import Swal from 'sweetalert2';
// import { saveAs } from "file-saver";

import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

app.config.globalProperties.$swal = Swal;
app.config.globalProperties.$config = config;
app.config.globalProperties.$toast = toast;
app.config.globalProperties.$refs = ref;

app.use(VueAxios, axios);
app.use(Router);
app.use(BootstrapVue3);
app.use(store);
app.mount('#app');