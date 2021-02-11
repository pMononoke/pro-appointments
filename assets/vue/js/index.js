require('../css/app.scss');

const $ = require('jquery');

require('bootstrap');

import Vue from "vue";
import App from "./App";
import router from "./router";

//import SideclickModal from '../../../public/bundles/sideclickbootstrapmodal/javascript/sideclick_modal';

//  new SideclickModal();

new Vue({
    components: { App },
    template: "<App/>",
    router
}).$mount("#app");