window.Vue = require("vue").default;

import Vue from "vue";
import Vuetify from "vuetify";
import VeeValidate from "vee-validate";
import store from "./store";

require("./bootstrap");
require("./core.js");
require("./components/index.js");

import "vuetify/dist/vuetify.min.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";


Vue.use(VeeValidate);
Vue.use(Vuetify, {
    iconfont: "md",
    theme: {
        options: {customProperties: true},
        primary: "#3759a8",
        secondary: "#4c4c4e",
        accent: "#DF542D", //processing
        error: "#FF5252", //Incomplete
        info: "#3759a8",
        success: "#4c4c4e", //Completed
        warning: "#F1AA43", //pending,
        disabled: "#a7a9ab"
    },
});

const vuexOptions = {
    state: {
        data: "TestData",
    },
};

const app = new Vue(
    {
        mode: "development",
        el: "#app",
        store,
        mixins: Laravel.vueMixins,
        mounted() {
            document.getElementById("app").classList.add('init');
        },
        data: {
            drawer: undefined,
            right: null,
        },
        methods: {
            logout() {
                this.$refs.logoutForm.submit();
            },
        },
    },
    vuexOptions
);

//TODO::Convert to .env check
Vue.config.devtools = true;
Vue.config.debug = true;
Vue.config.silent = false;
