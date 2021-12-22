(window.webpackJsonp=window.webpackJsonp||[]).push([[44],{"3OYQ":function(t,a,e){"use strict";e.r(a);var s=e("9Qmd"),i=e("Dt6l"),r=e("jMhu"),n={props:["_token","userinfo","notif","breadcrumbItems","errors","__store"],components:{Layout:s.a,FlashMsg:i.a,Breadcrumb:r.a},data:function(){return{submitState:!1,form:{department:"",alias:""}}},methods:{submit:function(){var t=this;this.submitState||(this.submitState=!0,this.$inertia.post(this.route(this.__store),this.form).then((function(){return t.submitState=!1})))}}},o=e("KHd+"),l=Object(o.a)(n,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[e("flash-msg"),t._v(" "),e("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[e("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Create New Department")])]),t._v(" "),e("breadcrumb",{attrs:{items:t.breadcrumbItems}}),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12"},[e("b-card",{attrs:{"no-body":""}},[e("b-form",{attrs:{id:"form"},on:{submit:function(a){return a.preventDefault(),t.submit(a)}}},[e("b-card-body",[e("b-col",{attrs:{col:"",lg:"3",md:"auto"}},[e("b-form-group",{attrs:{id:"input-group-title",label:"Department Name:","label-for":"input-title","invalid-feedback":t.errors.department?t.errors.department[0]:"",state:!t.errors.department&&null}},[e("b-form-input",{attrs:{id:"input-title",type:"text",name:"department",placeholder:"Input department",state:!t.errors.department&&null,trim:""},model:{value:t.form.department,callback:function(a){t.$set(t.form,"department",a)},expression:"form.department"}})],1),t._v(" "),e("b-form-group",{attrs:{id:"input-group-title",label:"Alias Name:","label-for":"input-title","invalid-feedback":t.errors.alias?t.errors.alias[0]:"",state:!t.errors.alias&&null}},[e("b-form-input",{attrs:{id:"input-title",type:"text",name:"alias",placeholder:"Input alias name",state:!t.errors.alias&&null,trim:""},model:{value:t.form.alias,callback:function(a){t.$set(t.form,"alias",a)},expression:"form.alias"}})],1)],1),t._v(" "),e("b-row",{attrs:{"align-h":"center"}},[e("b-button-group",[e("b-button",{attrs:{type:"submit",variant:"primary"}},[t._v("Submit")]),t._v(" "),e("b-button",{attrs:{type:"reset",variant:"secondary"}},[t._v("Reset")])],1)],1)],1)],1)],1)],1)])],1)}),[],!1,null,null,null);a.default=l.exports},"9Qmd":function(t,a,e){"use strict";var s={props:["notif"],components:{SidebarItem:e("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"admin.dashboard",index:"admin.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"Master",link:"#",icon:"fas fa-fw fa-folder",child:[{title:"Branch Office",link:"admin.branch.*",index:"admin.branch.index"},{title:"Department",link:"admin.department.*",index:"admin.department.index"},{title:"Employee",link:"admin.employee.*",index:"admin.employee.index"}]}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},i=e("KHd+"),r={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},n={components:{Sidebar:Object(i.a)(s,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[e("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("admin.dashboard")}},[e("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("WebSHF")])]),t._v(" "),e("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),e("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),e("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"text-center d-none d-md-inline"},[a("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(i.a)(r,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("nav",{staticClass:"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"},[t._m(0),t._v(" "),e("ul",{staticClass:"navbar-nav ml-auto"},[t._m(1),t._v(" "),e("li",{staticClass:"nav-item dropdown no-arrow mx-1"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"alertsDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("i",{staticClass:"fas fa-bell fa-fw"}),t._v(" "),t.alertstatus?e("span",{staticClass:"badge badge-danger badge-counter"},[t._v("3+")]):t._e()]),t._v(" "),t.alertstatus?e("div",{staticClass:"dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"alertsDropdown"}},[e("h6",{staticClass:"dropdown-header"},[t._v("Alerts Center")]),t._v(" "),t._m(2),t._v(" "),t._m(3),t._v(" "),t._m(4),t._v(" "),e("a",{staticClass:"dropdown-item text-center small text-gray-500",attrs:{href:"#"}},[t._v("Show All Alerts")])]):t._e()]),t._v(" "),e("li",{staticClass:"nav-item dropdown no-arrow mx-1"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"messagesDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("i",{staticClass:"fas fa-envelope fa-fw"}),t._v(" "),t.messagestatus?e("span",{staticClass:"badge badge-danger badge-counter"},[t._v("7")]):t._e()]),t._v(" "),t.messagestatus?e("div",{staticClass:"dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"messagesDropdown"}},[e("h6",{staticClass:"dropdown-header"},[t._v("Message Center")]),t._v(" "),t._m(5),t._v(" "),t._m(6),t._v(" "),t._m(7),t._v(" "),t._m(8),t._v(" "),e("a",{staticClass:"dropdown-item text-center small text-gray-500",attrs:{href:"#"}},[t._v("Read More Messages")])]):t._e()]),t._v(" "),e("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),e("li",{staticClass:"nav-item dropdown no-arrow"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))])]),t._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[t._m(9),t._v(" "),e("div",{staticClass:"dropdown-divider"}),t._v(" "),e("button",{staticClass:"dropdown-item",on:{click:function(a){t.show=!0}}},[e("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])])])]),t._v(" "),e("b-modal",{attrs:{title:"Logout","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[e("b-button",{attrs:{variant:"secondary"},on:{click:function(a){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),e("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(a){t.show=a},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[a("i",{staticClass:"fa fa-bars"})])},function(){var t=this.$createElement,a=this._self._c||t;return a("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[a("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[a("div",{staticClass:"input-group"},[a("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),a("div",{staticClass:"input-group-append"},[a("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[a("i",{staticClass:"fas fa-search fa-sm"})])])])])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"mr-3"},[a("div",{staticClass:"icon-circle bg-primary"},[a("i",{staticClass:"fas fa-file-alt text-white"})])]),this._v(" "),a("div",[a("div",{staticClass:"small text-gray-500"},[this._v("December 12, 2019")]),this._v(" "),a("span",{staticClass:"font-weight-bold"},[this._v("A new monthly report is ready to download!")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"mr-3"},[a("div",{staticClass:"icon-circle bg-success"},[a("i",{staticClass:"fas fa-donate text-white"})])]),this._v(" "),a("div",[a("div",{staticClass:"small text-gray-500"},[this._v("December 7, 2019")]),this._v("\n            $290.29 has been deposited into your account!\n          ")])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"mr-3"},[a("div",{staticClass:"icon-circle bg-warning"},[a("i",{staticClass:"fas fa-exclamation-triangle text-white"})])]),this._v(" "),a("div",[a("div",{staticClass:"small text-gray-500"},[this._v("December 2, 2019")]),this._v("\n            Spending Alert: We've noticed unusually high spending for your\n            account.\n          ")])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"dropdown-list-image mr-3"},[a("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/fn_BT9fwg_E/60x60",alt:""}}),this._v(" "),a("div",{staticClass:"status-indicator bg-success"})]),this._v(" "),a("div",{staticClass:"font-weight-bold"},[a("div",{staticClass:"text-truncate"},[this._v("\n              Hi there! I am wondering if you can help me with a problem I've\n              been having.\n            ")]),this._v(" "),a("div",{staticClass:"small text-gray-500"},[this._v("Emily Fowler · 58m")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"dropdown-list-image mr-3"},[a("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/AU4VPcFN4LE/60x60",alt:""}}),this._v(" "),a("div",{staticClass:"status-indicator"})]),this._v(" "),a("div",[a("div",{staticClass:"text-truncate"},[this._v("\n              I have the photos that you ordered last month, how would you\n              like them sent to you?\n            ")]),this._v(" "),a("div",{staticClass:"small text-gray-500"},[this._v("Jae Chun · 1d")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"dropdown-list-image mr-3"},[a("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/CS2uCrpNzJY/60x60",alt:""}}),this._v(" "),a("div",{staticClass:"status-indicator bg-warning"})]),this._v(" "),a("div",[a("div",{staticClass:"text-truncate"},[this._v("\n              Last month's report looks great, I am very happy with the\n              progress so far, keep up the good work!\n            ")]),this._v(" "),a("div",{staticClass:"small text-gray-500"},[this._v("Morgan Alvarez · 2d")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[a("div",{staticClass:"dropdown-list-image mr-3"},[a("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/Mv9hjnEUHR4/60x60",alt:""}}),this._v(" "),a("div",{staticClass:"status-indicator bg-success"})]),this._v(" "),a("div",[a("div",{staticClass:"text-truncate"},[this._v("\n              Am I a good boy? The reason I ask is because someone told me\n              that people say this to all dogs, even if they aren't good...\n            ")]),this._v(" "),a("div",{staticClass:"small text-gray-500"},[this._v("Chicken the Dog · 2w")])])])},function(){var t=this.$createElement,a=this._self._c||t;return a("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[a("i",{staticClass:"fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"}),this._v("\n          Settings\n        ")])}],!1,null,null,null).exports,Footer:Object(i.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("footer",{staticClass:"sticky-footer bg-white"},[a("div",{staticClass:"container my-auto"},[a("div",{staticClass:"copyright text-center my-auto"},[a("span",[this._v("Copyright © Your Website 2020")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},o=Object(i.a)(n,(function(){var t=this.$createElement,a=this._self._c||t;return a("div",{attrs:{id:"wrapper"}},[a("Sidebar"),this._v(" "),a("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[a("div",{attrs:{id:"content"}},[a("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),a("main",[a("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),a("Footer")],1)],1)}),[],!1,null,null,null);a.a=o.exports},Dt6l:function(t,a,e){"use strict";function s(t,a){return function(t){if(Array.isArray(t))return t}(t)||function(t,a){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var e=[],s=!0,i=!1,r=void 0;try{for(var n,o=t[Symbol.iterator]();!(s=(n=o.next()).done)&&(e.push(n.value),!a||e.length!==a);s=!0);}catch(t){i=!0,r=t}finally{try{s||null==o.return||o.return()}finally{if(i)throw r}}return e}(t,a)||function(t,a){if(!t)return;if("string"==typeof t)return i(t,a);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return i(t,a)}(t,a)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(t,a){(null==a||a>t.length)&&(a=t.length);for(var e=0,s=new Array(a);e<a;e++)s[e]=t[e];return s}var r={mounted:function(){for(var t=0,a=Object.entries(this.pageFlashes);t<a.length;t++){var e=s(a[t],2),i=e[0],r=e[1];r&&("success"==i&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=i,this.msg=r,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var a=this;_.each(t,(function(t,e){t&&("success"==e&&a.$emit("onSuccess",!0),a.dismissCountDown=3,a.variant=e,a.msg=t,a.pageFlashes[e]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},n=e("KHd+"),o=Object(n.a)(r,(function(){var t=this,a=t.$createElement;return(t._self._c||a)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(a){t.dismissCountDown=a},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);a.a=o.exports},"KHd+":function(t,a,e){"use strict";function s(t,a,e,s,i,r,n,o){var l,d="function"==typeof t?t.options:t;if(a&&(d.render=a,d.staticRenderFns=e,d._compiled=!0),s&&(d.functional=!0),r&&(d._scopeId="data-v-"+r),n?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(n)},d._ssrRegister=l):i&&(l=o?function(){i.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:i),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,a){return l.call(a),c(t,a)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:d}}e.d(a,"a",(function(){return s}))},jMhu:function(t,a,e){"use strict";var s={props:{items:{type:Array}}},i=e("KHd+"),r=Object(i.a)(s,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("ol",{staticClass:"breadcrumb"},t._l(t.items,(function(a){return e("li",{key:a.title,staticClass:"breadcrumb-item",class:{active:a.active}},[a.active?e("span",[a.icon?e("i",{staticClass:"fas",class:a.icon}):t._e(),t._v("\n      "+t._s(a.title)+"\n    ")]):e("inertia-link",{attrs:{href:a.param?t.route(a.href,a.param):t.route(a.href)}},[a.icon?e("i",{staticClass:"fas",class:a.icon}):t._e(),t._v("\n      "+t._s(a.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);a.a=r.exports},rYOV:function(t,a,e){"use strict";var s={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var a=0;a<t.child.length;a++)if(this.route().current(t.child[a].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},i=e("KHd+"),r=Object(i.a)(s,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",t._l(t.items,(function(a){return e("li",{key:a.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(a)?"active":""},[1==t.isArrayRoutes(a)?e("div",[e("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(a)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+a.title+"Page","aria-expanded":"false","aria-controls":a.title+"Page"}},[e("i",{class:a.icon}),t._v(" "),e("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?e("span",[e("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(a)?e("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(a)?"show":"",attrs:{id:a.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[e("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(a.child,(function(a,s){return e("inertia-link",{key:s,class:t.isRoute(a.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(a.index)}},[a.badge?e("span",[e("span",{class:!t.isRoute(a.link)&&"font-weight-bold"},[t._v(t._s(a.title))]),t._v(" "),e("span",{staticClass:"float-right"},[e("i",{staticClass:"fas fa-exclamation-circle"})])]):e("span",[t._v(t._s(a.title)+" ")])])})),1)]):t._e()]):e("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(a.index)}},[e("i",{class:a.icon}),t._v(" "),e("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?e("span",{staticClass:"float-right"},[e("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);a.a=r.exports}}]);