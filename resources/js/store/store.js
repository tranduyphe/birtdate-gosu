import { mapActions, mapGetters } from "vuex";
export const authMethods = mapActions(['login', 'logout']);
export const authGetters = mapGetters(['authenticated', 'user']);