import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Alpha from "../views/Alpha";
import CalendarDemo from "../views/CalendarDemo";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        { path: "/", component: Home },
        { path: "/alpha", component: Alpha },
        { path: "/cal", component: CalendarDemo },
        { path: "*", redirect: "/" }
    ]
});