require("./bootstrap");

import Vue from "vue";

import App from "./vue/app.vue";

import VueRouter from "vue-router";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faPlusSquare,
    faBackward,
    faTrash,
    faEdit,
    faBell
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faPlusSquare, faBackward, faTrash, faEdit, faBell);

Vue.component("font-awesome-icon", FontAwesomeIcon);

import Coin from "./vue/coin.vue";
import Coins from "./vue/coins.vue";

Vue.use(VueRouter);

const routes = [
    { path: "/", name: "coins", component: Coins },
    { path: "/:id", name: "coin", component: Coin }
];

const router = new VueRouter({
    mode: "history",
    routes
});

const app = new Vue({
    router,
    el: "#app",
    components: { App }
});
