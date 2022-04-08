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
window.moment = moment;
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

// fileagent
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";

Vue.use(VueFileAgent);

// spreadsheet hotdata
import { HotTable } from "@handsontable/vue";
Vue.component("hot-table", HotTable);
import "handsontable/dist/handsontable.full.css";

// component v-select
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

//  component vueNumeric
import VueNumeric from "vue-numeric";
Vue.use(VueNumeric);

// component VueCurrencyFilter
import VueCurrencyFilter from "vue-currency-filter";
Vue.use(VueCurrencyFilter, {
    symbol: "Rp",
    thousandsSeparator: ".",
    fractionCount: 2,
    fractionSeparator: ",",
    symbolPosition: "front",
    symbolSpacing: true,
    avoidEmptyDecimals: 0
});

Vue.mixin(require("./base"));

// lodash
import _ from "lodash";
Object.defineProperty(Vue.prototype, "$_", { value: _ });
// vue click outside
import vClickOutside from "v-click-outside";
Vue.use(vClickOutside);

// MOBILE SUPPORT
// vueBottomNavigation
import VueBottomNavigation from "bottom-navigation-vue";
Vue.use(VueBottomNavigation);

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
