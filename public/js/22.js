(window.webpackJsonp=window.webpackJsonp||[]).push([[22],{"KHd+":function(t,a,s){"use strict";function i(t,a,s,i,e,r,n,l){var o,d="function"==typeof t?t.options:t;if(a&&(d.render=a,d.staticRenderFns=s,d._compiled=!0),i&&(d.functional=!0),r&&(d._scopeId="data-v-"+r),n?(o=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),e&&e.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(n)},d._ssrRegister=o):e&&(o=l?function(){e.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:e),o)if(d.functional){d._injectStyles=o;var c=d.render;d.render=function(t,a){return o.call(a),c(t,a)}}else{var v=d.beforeCreate;d.beforeCreate=v?[].concat(v,o):[o]}return{exports:t,options:d}}s.d(a,"a",(function(){return i}))},gwhN:function(t,a,s){"use strict";var i={props:["notif"],components:{SidebarItem:s("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"super.dashboard",index:"super.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"User Management",link:"super.user.*",index:"super.user.index",icon:"fas fa-fw fa-user"},{id:2,title:"Reference",link:"#",icon:"fas fa-fw fa-folder",child:[{title:"Position",link:"super.ref_position.*",index:"super.ref_position.index"},{title:"Title",link:"super.ref_title.*",index:"super.ref_title.index"},{title:"Approver",link:"super.ref_approver.*",index:"super.ref_approver.index"},{title:"Type Memo",link:"super.ref_type_memo.*",index:"super.ref_type_memo.index"}]}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},e=s("KHd+"),r={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},n={components:{Sidebar:Object(e.a)(i,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[s("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("super.dashboard")}},[s("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("SuperMenu WebSHF")])]),t._v(" "),s("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),s("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),s("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"text-center d-none d-md-inline"},[a("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(e.a)(r,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("nav",{staticClass:"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"},[t._m(0),t._v(" "),s("ul",{staticClass:"navbar-nav ml-auto"},[t._m(1),t._v(" "),s("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),s("li",{staticClass:"nav-item dropdown no-arrow"},[s("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[s("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))]),t._v(" "),s("b-avatar",{attrs:{variant:"primary",icon:"person-badge",size:"2rem"}})],1),t._v(" "),s("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[s("button",{staticClass:"dropdown-item",on:{click:function(a){t.show=!0}}},[s("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])])])]),t._v(" "),s("b-modal",{attrs:{title:"Logout","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[s("b-button",{attrs:{variant:"secondary"},on:{click:function(a){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),s("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(a){t.show=a},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[a("i",{staticClass:"fa fa-bars"})])},function(){var t=this.$createElement,a=this._self._c||t;return a("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[a("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[a("div",{staticClass:"input-group"},[a("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),a("div",{staticClass:"input-group-append"},[a("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[a("i",{staticClass:"fas fa-search fa-sm"})])])])])])])}],!1,null,null,null).exports,Footer:Object(e.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("footer",{staticClass:"sticky-footer bg-white"},[a("div",{staticClass:"container my-auto"},[a("div",{staticClass:"copyright text-center my-auto"},[a("span",[this._v("Copyright © Your Website 2020")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},l=Object(e.a)(n,(function(){var t=this.$createElement,a=this._self._c||t;return a("div",{attrs:{id:"wrapper"}},[a("Sidebar"),this._v(" "),a("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[a("div",{attrs:{id:"content"}},[a("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),a("main",[a("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),a("Footer")],1)],1)}),[],!1,null,null,null);a.a=l.exports},m0xG:function(t,a,s){"use strict";s.r(a);var i={metaInfo:{title:"Beranda"},data:function(){return{}},components:{Layout:s("gwhN").a},props:["meta","userinfo"],methods:{test:function(){alert("oke")}}},e=s("KHd+"),r=Object(e.a)(i,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[s("div",{staticClass:"container-fluid"},[s("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[s("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Dashboard")]),t._v(" "),s("a",{staticClass:"d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm",attrs:{href:"#"}},[s("i",{staticClass:"fas fa-download fa-sm text-white-50"}),t._v(" Generate\n        Report")])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-xl-3 col-md-6 mb-4"},[s("div",{staticClass:"card border-left-primary shadow h-100 py-2"},[s("div",{staticClass:"card-body"},[s("div",{staticClass:"row no-gutters align-items-center"},[s("div",{staticClass:"col mr-2"},[s("div",{staticClass:"\n                    text-xs\n                    font-weight-bold\n                    text-primary text-uppercase\n                    mb-1\n                  "},[t._v("\n                  Earnings (Monthly)\n                ")]),t._v(" "),s("div",{staticClass:"h5 mb-0 font-weight-bold text-gray-800"},[t._v("\n                  $40,000\n                ")])]),t._v(" "),s("div",{staticClass:"col-auto"},[s("i",{staticClass:"fas fa-calendar fa-2x text-gray-300"})])])])])]),t._v(" "),s("div",{staticClass:"col-xl-3 col-md-6 mb-4"},[s("div",{staticClass:"card border-left-success shadow h-100 py-2"},[s("div",{staticClass:"card-body"},[s("div",{staticClass:"row no-gutters align-items-center"},[s("div",{staticClass:"col mr-2"},[s("div",{staticClass:"\n                    text-xs\n                    font-weight-bold\n                    text-success text-uppercase\n                    mb-1\n                  "},[t._v("\n                  Earnings (Annual)\n                ")]),t._v(" "),s("div",{staticClass:"h5 mb-0 font-weight-bold text-gray-800"},[t._v("\n                  $215,000\n                ")])]),t._v(" "),s("div",{staticClass:"col-auto"},[s("i",{staticClass:"fas fa-dollar-sign fa-2x text-gray-300"})])])])])]),t._v(" "),s("div",{staticClass:"col-xl-3 col-md-6 mb-4"},[s("div",{staticClass:"card border-left-info shadow h-100 py-2"},[s("div",{staticClass:"card-body"},[s("div",{staticClass:"row no-gutters align-items-center"},[s("div",{staticClass:"col mr-2"},[s("div",{staticClass:"\n                    text-xs\n                    font-weight-bold\n                    text-info text-uppercase\n                    mb-1\n                  "},[t._v("\n                  Tasks\n                ")]),t._v(" "),s("div",{staticClass:"row no-gutters align-items-center"},[s("div",{staticClass:"col-auto"},[s("div",{staticClass:"h5 mb-0 mr-3 font-weight-bold text-gray-800"},[t._v("\n                      50%\n                    ")])]),t._v(" "),s("div",{staticClass:"col"},[s("div",{staticClass:"progress progress-sm mr-2"},[s("div",{staticClass:"progress-bar bg-info",staticStyle:{width:"50%"},attrs:{role:"progressbar","aria-valuenow":"50","aria-valuemin":"0","aria-valuemax":"100"}})])])])]),t._v(" "),s("div",{staticClass:"col-auto"},[s("i",{staticClass:"fas fa-clipboard-list fa-2x text-gray-300"})])])])])]),t._v(" "),s("div",{staticClass:"col-xl-3 col-md-6 mb-4"},[s("div",{staticClass:"card border-left-warning shadow h-100 py-2"},[s("div",{staticClass:"card-body"},[s("div",{staticClass:"row no-gutters align-items-center"},[s("div",{staticClass:"col mr-2"},[s("div",{staticClass:"\n                    text-xs\n                    font-weight-bold\n                    text-warning text-uppercase\n                    mb-1\n                  "},[t._v("\n                  Pending Requests\n                ")]),t._v(" "),s("div",{staticClass:"h5 mb-0 font-weight-bold text-gray-800"},[t._v("18")])]),t._v(" "),s("div",{staticClass:"col-auto"},[s("i",{staticClass:"fas fa-comments fa-2x text-gray-300"})])])])])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-xl-8 col-lg-7"},[s("div",{staticClass:"card shadow mb-4"},[s("div",{staticClass:"\n              card-header\n              py-3\n              d-flex\n              flex-row\n              align-items-center\n              justify-content-between\n            "},[s("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("\n              Earnings Overview\n            ")]),t._v(" "),s("div",{staticClass:"dropdown no-arrow"},[s("a",{staticClass:"dropdown-toggle",attrs:{href:"#",role:"button",id:"dropdownMenuLink","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[s("i",{staticClass:"fas fa-ellipsis-v fa-sm fa-fw text-gray-400"})]),t._v(" "),s("div",{staticClass:"\n                  dropdown-menu dropdown-menu-right\n                  shadow\n                  animated--fade-in\n                ",attrs:{"aria-labelledby":"dropdownMenuLink"}},[s("div",{staticClass:"dropdown-header"},[t._v("Dropdown Header:")]),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Action")]),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Another action")]),t._v(" "),s("div",{staticClass:"dropdown-divider"}),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Something else here")])])])]),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"chart-area"},[s("canvas",{attrs:{id:"myAreaChart"}})])])])]),t._v(" "),s("div",{staticClass:"col-xl-4 col-lg-5"},[s("div",{staticClass:"card shadow mb-4"},[s("div",{staticClass:"\n              card-header\n              py-3\n              d-flex\n              flex-row\n              align-items-center\n              justify-content-between\n            "},[s("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("Revenue Sources")]),t._v(" "),s("div",{staticClass:"dropdown no-arrow"},[s("a",{staticClass:"dropdown-toggle",attrs:{href:"#",role:"button",id:"dropdownMenuLink","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[s("i",{staticClass:"fas fa-ellipsis-v fa-sm fa-fw text-gray-400"})]),t._v(" "),s("div",{staticClass:"\n                  dropdown-menu dropdown-menu-right\n                  shadow\n                  animated--fade-in\n                ",attrs:{"aria-labelledby":"dropdownMenuLink"}},[s("div",{staticClass:"dropdown-header"},[t._v("Dropdown Header:")]),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Action")]),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Another action")]),t._v(" "),s("div",{staticClass:"dropdown-divider"}),t._v(" "),s("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[t._v("Something else here")])])])]),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"chart-pie pt-4 pb-2"},[s("canvas",{attrs:{id:"myPieChart"}})]),t._v(" "),s("div",{staticClass:"mt-4 text-center small"},[s("span",{staticClass:"mr-2"},[s("i",{staticClass:"fas fa-circle text-primary"}),t._v("\n                Direct\n              ")]),t._v(" "),s("span",{staticClass:"mr-2"},[s("i",{staticClass:"fas fa-circle text-success"}),t._v("\n                Social\n              ")]),t._v(" "),s("span",{staticClass:"mr-2"},[s("i",{staticClass:"fas fa-circle text-info"}),t._v("\n                Referral\n              ")])])])])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card shadow mb-4"},[s("div",{staticClass:"card-header py-3"},[s("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("Projects")])]),t._v(" "),s("div",{staticClass:"card-body"},[s("h4",{staticClass:"small font-weight-bold"},[t._v("\n              Server Migration\n              "),s("span",{staticClass:"float-right"},[t._v("20%")])]),t._v(" "),s("div",{staticClass:"progress mb-4"},[s("div",{staticClass:"progress-bar bg-danger",staticStyle:{width:"20%"},attrs:{role:"progressbar","aria-valuenow":"20","aria-valuemin":"0","aria-valuemax":"100"}})]),t._v(" "),s("h4",{staticClass:"small font-weight-bold"},[t._v("\n              Sales Tracking\n              "),s("span",{staticClass:"float-right"},[t._v("40%")])]),t._v(" "),s("div",{staticClass:"progress mb-4"},[s("div",{staticClass:"progress-bar bg-warning",staticStyle:{width:"40%"},attrs:{role:"progressbar","aria-valuenow":"40","aria-valuemin":"0","aria-valuemax":"100"}})]),t._v(" "),s("h4",{staticClass:"small font-weight-bold"},[t._v("\n              Customer Database\n              "),s("span",{staticClass:"float-right"},[t._v("60%")])]),t._v(" "),s("div",{staticClass:"progress mb-4"},[s("div",{staticClass:"progress-bar",staticStyle:{width:"60%"},attrs:{role:"progressbar","aria-valuenow":"60","aria-valuemin":"0","aria-valuemax":"100"}})]),t._v(" "),s("h4",{staticClass:"small font-weight-bold"},[t._v("\n              Payout Details\n              "),s("span",{staticClass:"float-right"},[t._v("80%")])]),t._v(" "),s("div",{staticClass:"progress mb-4"},[s("div",{staticClass:"progress-bar bg-info",staticStyle:{width:"80%"},attrs:{role:"progressbar","aria-valuenow":"80","aria-valuemin":"0","aria-valuemax":"100"}})]),t._v(" "),s("h4",{staticClass:"small font-weight-bold"},[t._v("\n              Account Setup\n              "),s("span",{staticClass:"float-right"},[t._v("Complete!")])]),t._v(" "),s("div",{staticClass:"progress"},[s("div",{staticClass:"progress-bar bg-success",staticStyle:{width:"100%"},attrs:{role:"progressbar","aria-valuenow":"100","aria-valuemin":"0","aria-valuemax":"100"}})])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-primary text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Primary\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#4e73df")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-success text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Success\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#1cc88a")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-info text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Info\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#36b9cc")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-warning text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Warning\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#f6c23e")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-danger text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Danger\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#e74a3b")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-secondary text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Secondary\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#858796")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-light text-black shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Light\n                "),s("div",{staticClass:"text-black-50 small"},[t._v("#f8f9fc")])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card bg-dark text-white shadow"},[s("div",{staticClass:"card-body"},[t._v("\n                Dark\n                "),s("div",{staticClass:"text-white-50 small"},[t._v("#5a5c69")])])])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 mb-4"},[s("div",{staticClass:"card shadow mb-4"},[s("div",{staticClass:"card-header py-3"},[s("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("Illustrations")])]),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"text-center"},[s("img",{staticClass:"img-fluid px-3 px-sm-4 mt-3 mb-4",staticStyle:{width:"25rem"},attrs:{src:"img/undraw_posting_photo.svg",alt:""}})]),t._v(" "),s("p",[t._v("\n              Add some quality, svg illustrations to your project courtesy of\n              "),s("a",{attrs:{target:"_blank",rel:"nofollow",href:"https://undraw.co/"}},[t._v("unDraw")]),t._v(", a constantly updated collection of beautiful svg images that\n              you can use completely free and without attribution!\n            ")]),t._v(" "),s("a",{attrs:{target:"_blank",rel:"nofollow",href:"https://undraw.co/"}},[t._v("Browse Illustrations on unDraw →")])])]),t._v(" "),s("div",{staticClass:"card shadow mb-4"},[s("div",{staticClass:"card-header py-3"},[s("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("\n              Development Approach\n            ")])]),t._v(" "),s("div",{staticClass:"card-body"},[s("p",[t._v("\n              SB Admin 2 makes extensive use of Bootstrap 4 utility classes in\n              order to reduce CSS bloat and poor page performance. Custom CSS\n              classes are used to create custom components and custom utility\n              classes.\n            ")]),t._v(" "),s("p",{staticClass:"mb-0"},[t._v("\n              Before working with this theme, you should become familiar with\n              the Bootstrap framework, especially the utility classes.\n            ")])])])])])])])}),[],!1,null,null,null);a.default=r.exports},rYOV:function(t,a,s){"use strict";var i={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var a=0;a<t.child.length;a++)if(this.route().current(t.child[a].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},e=s("KHd+"),r=Object(e.a)(i,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",t._l(t.items,(function(a){return s("li",{key:a.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(a)?"active":""},[1==t.isArrayRoutes(a)?s("div",[s("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(a)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+a.title+"Page","aria-expanded":"false","aria-controls":a.title+"Page"}},[s("i",{class:a.icon}),t._v(" "),s("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?s("span",[s("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(a)?s("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(a)?"show":"",attrs:{id:a.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[s("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(a.child,(function(a,i){return s("inertia-link",{key:i,class:t.isRoute(a.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(a.index)}},[a.badge?s("span",[s("span",{class:!t.isRoute(a.link)&&"font-weight-bold"},[t._v(t._s(a.title))]),t._v(" "),s("span",{staticClass:"float-right"},[s("i",{staticClass:"fas fa-exclamation-circle"})])]):s("span",[t._v(t._s(a.title)+" ")])])})),1)]):t._e()]):s("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(a.index)}},[s("i",{class:a.icon}),t._v(" "),s("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?s("span",{staticClass:"float-right"},[s("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);a.a=r.exports}}]);