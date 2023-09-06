import { createRouter, createWebHistory } from "vue-router";
import store from '@/store';

import login from '@/components/login/';
import home from '@/components/home/';
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