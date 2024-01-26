import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth";
import snackbar from "./modules/snackbar";
import users from "./modules/users";
import server from "./modules/state";

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== "production";

export default new Vuex.Store({
  modules: {
    auth,
    snackbar,
    users,
    server,
  },
  strict: debug,
});
