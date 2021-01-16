import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Alpha from "../views/Alpha";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/web", component: Home },
        { path: "/alpha", component: Alpha },
        { path: "*", redirect: "/web" }
    ]
});