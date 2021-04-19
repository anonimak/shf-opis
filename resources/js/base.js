// Location in resources/js/base.js

module.exports = {
    methods: {

        route: window.route,
        isRoute(...routes) {
            return routes.some((route) => {
                return (this.route().params)?this.route().current(route, this.route().params): this.route().current(route)
            });
        },
        /**
         * Translate the given key.
         */
        __(key, replace = {}) {
            var translation = this.$page.language[key] ?
                this.$page.language[key] :
                key

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            return translation
        },

        /** 
         * Translate the given key with basic pluralization. 
         */
        __n(key, number, replace = {}) {

            var translation = this.$page.language[key] ?
                this.$page.language[key] :
                key

            var options = translation.split('|');

            key = options[1];
            if (number <= 1) {
                key = options[0];
            }

            return this.__(key, replace);
        },

        cutStr(str, lengthStr = 25) {
            if (str.length > lengthStr)
                return str.substr(0, lengthStr) + "...";
            return str;
        },

        // baseUrl
        baseUrl(strUrl) {
            return (strUrl)?this.$page._baseUrl+strUrl: this.$page._baseUrl;
        }
    },
    computed: {
        pageFlashes () {
            return this.$page.flash
        },
    }
}
