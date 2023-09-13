import { mapActions, mapGetters } from "vuex";
export const authMethods = mapActions(['login', 'logout','users','saveGameId','getGameId']);
export const authGetters = mapGetters(['authenticated', 'user']);