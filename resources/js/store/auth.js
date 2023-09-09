
import { login, logout } from '@/helper/auth.js';
import router from '@/routers'

const state = {
    authenticated: false,
    user: {},

};

const getters = {
    authenticated: state => state.authenticated,
    user: state => state.user,
};

const actions = {
    async login({ commit }, loginData) {
        let results = await login(loginData);
        if (results.status == 200) {
            const data = results.data.data;
            if (data.token && data.token.length > 0) {
                commit('SET_AUTHENTICATED', true);
                commit('SET_USER', data);
                localStorage.setItem("users", JSON.stringify(data))
                window.location.href = '/site-map';
            } else {
                return results.data;
            }
        }
    },

    async logout({ commit }) {
        const users = JSON.parse(localStorage.getItem('users') || "{}");
        if (Object.keys(users).length > 0) {
            let token = users.token;
            let results = await logout(token);
            console.log('results', results)
            if (results.status == 200) {
                const data = results.data.data;
                if (data.logout) {
                    commit('SET_AUTHENTICATED', false);
                    commit('SET_USER', {});
                    localStorage.removeItem("users");
                    router.push( { name:'login' } ) // redirect to page login when logout is successful
                }
            } else {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', {});
                localStorage.removeItem("users");
                router.push({ name: 'login' }) // redirect to the home page when login is successful
            }
        }
    },
    users: () => {
        let data = JSON.parse(localStorage.getItem('users') || "{}");
        commit('SET_USER', data);
    }
};

const mutations = {
    SET_AUTHENTICATED: (state, payload) => (state.authenticated = payload),
    SET_USER: (state, payload) => (state.user = payload)
};

export default {
    state,
    getters,
    actions,
    mutations,
};
