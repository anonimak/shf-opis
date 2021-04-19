const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/backend/admin-main.scss", "public/css")
    .webpackConfig({
        resolve: {
            extensions: [".js", ".vue", ".json"],
            alias: {
                vue$: "vue/dist/vue.runtime.esm.js",
                "@": path.resolve("resources/js")
            }
        },
        output: {
            chunkFilename: "js/[name].js?id=[chunkhash]"
        },
        optimization: {
            splitChunks: {
                cacheGroups: {
                    default: false,
                    vendors: {
                        chunks: "initial",
                        name: "vendor",
                        filename: "js/[name].js"
                    }
                }
            }
        }
    })
    .version()
    .babelConfig({
        plugins: ["@babel/plugin-syntax-dynamic-import"]
    });

// mix to admin
// mix.js('resources/js/app.js', 'public/admin/js')
//     .sass('resources/sass/app-admin.scss', 'public/admin/css');

// mix.webpackConfig({
//         output: {
//             chunkFilename: 'js/[name].js?id=[chunkhash]'
//         },
//         resolve: {
//             alias: {
//                 vue$: 'vue/dist/vue.runtime.esm.js',
//                 '@': path.resolve('resources/js'),
//             },
//         },
//     })
//     .version();
