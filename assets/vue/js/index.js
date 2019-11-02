require('../css/app.scss');

const $ = require('jquery');

require('bootstrap');

import Vue from "vue";
import App from "./App";
import router from "./router";

new Vue({
    components: { App },
    template: "<App/>",
    router
}).$mount("#app");