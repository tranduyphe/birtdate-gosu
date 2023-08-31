import { createRouter, createWebHistory } from "vue-router";
import login from '@/js/components/login/';
const routes = [
	{
		path: '/',
		name: 'login',
		component: login
	},
]

export default createRouter({
	history: createWebHistory(),
	routes
})