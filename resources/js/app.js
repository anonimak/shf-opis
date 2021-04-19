require("./bootstrap");
import "bootstrap-vue/dist/bootstrap-vue.css";

// hover css
import "hover.css/css/hover-min.css";

import { InertiaApp } from "@inertiajs/inertia-vue";

import Vue from "vue";

// meta tools
import VueMeta from "vue-meta";

import BootstrapVue from "bootstrap-vue";
import FlashMessage from "@smartweb/vue-flash-message";

// untuk local storage
import Storage from "vue-ls";

// untuk moment js
const moment = require("moment");
require("moment/locale/id");

Vue.use(VueMeta);

Vue.use(require("vue-moment"), {
    moment
});

// bootstrap framework
Vue.use(BootstrapVue);

// untuk flash message
Vue.use(FlashMessage);
Vue.use(InertiaApp);

// untuk localstorage
Vue.use(Storage);

Vue.mixin(require("./base"));

const app = document.getElementById("app");

new Vue({
    metaInfo: {
        titleTemplate: title =>
            title ? `${title} - Sinarmas Hana Finance` : "Sinarmas Hana Finance"
    },
    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name =>
                    import(`./Pages/${name}`).then(module => module.default)
            }
        })
}).$mount(app);
