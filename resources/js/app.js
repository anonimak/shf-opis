require("./bootstrap");
import "bootstrap-vue/dist/bootstrap-vue.css";
// remixicon
import "remixicon/fonts/remixicon.css";

// hover css
import "hover.css/css/hover-min.css";

import { InertiaApp } from "@inertiajs/inertia-vue";

import Vue from "vue";

// meta tools
import VueMeta from "vue-meta";

import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue";

import FlashMessage from "@smartweb/vue-flash-message";

import vSelect from "vue-select";

// untuk local storage
import Storage from "vue-ls";

// untuk moment js
const moment = require("moment");
// require("moment/locale/id");

Vue.use(VueMeta);

Vue.use(require("vue-moment"), {
    moment
});

// bootstrap framework
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);

// untuk flash message
Vue.use(FlashMessage);

// inertia app
Vue.use(InertiaApp);

// untuk localstorage
Vue.use(Storage);

// file-upload
import VueUploadComponent from "vue-upload-component";
Vue.component("file-upload", VueUploadComponent);

// spreadsheet hotdata
import { HotTable } from "@handsontable/vue";
Vue.component("hot-table", HotTable);
import "handsontable/dist/handsontable.full.css";

// component v-select
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

Vue.mixin(require("./base"));

import _ from "lodash";
Object.defineProperty(Vue.prototype, "$_", { value: _ });

const app = document.getElementById("app");

const VueApp = new Vue({
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
