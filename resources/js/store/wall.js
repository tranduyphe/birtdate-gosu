
import { create, index, update } from '@/helper/wall';
const state = {
    listWall: [],
};

const getters = {
    listWall: state => state.listWall,
};

const actions = {
    async createWall({ commit }, data) {
        let results = await create(data);
        if (results.status == 200) {
            return results.data;
        }
    },
    async indexWall({ commit }, data) {
        let results = await index(data);
        if (results.status == 200) {
            commit('SET_LISTWALL', results.data);
            return results.data;
        }
    },
    async updateWall({ commit }, data) {
        let results = await update(data);
        if (results.status == 200) {
            //commit('SET_LISTWALL', results.data);
            return results.data;
        }
    },
};

const mutations = {
    SET_LISTWALL: (state, payload) => (state.listWall = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
