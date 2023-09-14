import { io } from "socket.io-client";
console.log('process.env.NODE_ENV', process.env.NODE_ENV);
const URL = process.env.NODE_ENV === "development" ? 'ws://localhost:3000' : "wss://base.nemosoftware.nets:7979";
//export const socket = io(URL);
const state = {
    connectSocket: false,
};

const getters = {
    connectSocket: state => state.connectSocket,
};

const actions = {
    connect: ({commit}, slug) => {
        // socket.on("connect", () => {
        //     console.log('connect', socket);
        //     commit('setConnect', true);
        // });
    },
    disconnect: ({commit}) => {
        // socket.on("disconnect", () => {
        //     commit('setConnect', false);
        // });
    },
    joinRoom({commit}, id){
        // console.log('id', id)
        // socket.emit('join room', id);
    },
    sendData({commit}, data){
        //socket.emit('send data', data);
    },
    sendUpdateData({commit}, data){
        //socket.emit('send update data', data);
    },
    // listentData(){
    //     let results = false;
    //     socket.on('send data', (data)=>{
    //         console.log('listent data', data)
    //         results = data;
    //     });
    //     console.log('listent results', results);
    //     return results;
    // }
};

const mutations = {
    setConnect: (state, payload) => (state.connectSocket = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};