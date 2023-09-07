import { createStore } from 'vuex';
import auth from '@/store/auth';
import game from '@/store/game';
const store = createStore({
    modules: {
        auth,
        game
    },
});

export default store