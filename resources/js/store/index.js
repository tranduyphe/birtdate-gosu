import { createStore } from 'vuex';
import auth from '@/store/auth';
import game from '@/store/game';
import socket from '@/store/socket';
import wall from '@/store/wall';
const store = createStore({
    modules: {
        auth,
        game,
        socket,
        wall
    },
});

export default store