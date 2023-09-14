import { Comment } from "@/helper";
const state = {
    listComment: [],
};

const getters = {
    listComment: state => state.listComment,
};

const actions = {
    async createComment({ commit }, data) {
        let results = await Comment.create(data);
        if (results.status == 200) {
            return results.data;
        }
    },
    async indexComment({ commit }) {
        let results = await Comment.index();
        if (results.status == 200) {
            commit('SET_LISTCOMMENT', results.data);
            return results.data;
        }
    },
    async updateComment({ commit }, data) {
        let results = await Comment.update(data);
        if (results.status == 200) {
            return results.data;
        }
    },
    async deleteComment({ commit }, data) {
        let results = await Comment.remove(data);
        if (results.status == 200) {
            return results.data;
        }
    },
};

const mutations = {
    SET_LISTCOMMENT: (state, payload) => (state.listComment = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
