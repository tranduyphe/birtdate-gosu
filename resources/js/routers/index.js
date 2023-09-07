import { createRouter, createWebHistory } from "vue-router";
// import store from '@/store';

import login from '@/components/login/';
import home from '@/components/home/index.vue';
import Minigame from '@/components/home/Minigame.vue';
import Quest from '@/components/home/Quest.vue';

import ThuVienToanTri from '../components/home/ThuVienToanTri.vue';

import Launch from '../components/sinhnhat11nam/landing-page/Launch.vue';

import SiteMap from '../components/sinhnhat11nam/landing-page/SiteMap.vue';
const routes = [
	{
		path: '/',
		name: 'login',
		component: login,
		meta: {
			middleware: "guest",
			title: `Login`
		}
	},
	{
		path: '/index',
		name: 'home',
		component: home,
		meta: {
			middleware: "auth"
		},
	},
	{
		path: '/minigame',
		name: 'minigame',
		component: Minigame,
		meta: {
			middleware: "auth"
		},
	},
	{
		path: '/quest',
		name: 'quest',
		component: Quest,
		meta: {
			middleware: "auth"
		},
	},

	{
		name: 'thu-vien-toan-tri',
		path: '/thu-vien-toan-tri',
		component: ThuVienToanTri,
		meta: {
			middleware: "auth"
		},
	},
	{
		name: 'launch',
		path: '/launch',
		component: Launch,
		meta: {
			middleware: "auth"
		},
	},
	{
		name: 'sitemap',
		path: '/site-map',
		component: SiteMap,
		meta: {
			middleware: "auth"
		},
	},
]

const router = createRouter({
	history: createWebHistory(),
	routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
	let users = JSON.parse(localStorage.getItem('users') || "{}");
	document.title = to.meta.title;
	let authenticated = Object.keys(users).length > 0 ? true : false;
	if (to.meta.middleware == "guest") {
		if (authenticated) {
			next({ name: "home" })
		}
		next();
	} else {
		if (authenticated) {
			next()
		} else {
			next({ name: "login" })
		}
	}
})

export default router