import { mapActions, mapGetters } from "vuex";
export const authMethods = mapActions(['login', 'logout','users','saveGameId','getGameId', '']);
export const authGetters = mapGetters(['authenticated', 'user']);
export const socketMethods = mapActions(['connect', 'disconnect', 'joinRoom', 'sendData', 'sendUpdateData']);
export const walltMethods = mapActions(['createWall', 'indexWall', 'updateWall']);
export const wallGetters = mapGetters(['listWall']);
//export const socketGetters = mapGetters(['listMessengers']);