(window.webpackJsonp=window.webpackJsonp||[]).push([[51],{"+Onf":function(t,e,a){"use strict";a.r(e);var s=a("gwhN"),r=a("Dt6l"),i=a("jMhu"),n={props:["_token","userinfo","notif","breadcrumbItems","errors","__store"],components:{Layout:s.a,FlashMsg:r.a,Breadcrumb:i.a},data:function(){return{submitState:!1,form:{msg:"",status:null,type:null},options:[{value:null,text:"--Please select a status maintenance message--"},{value:"hide",text:"Hide"},{value:"show",text:"Show"}],optiontypes:[{value:null,text:"--Please select a type maintenance message--"},{value:"primary",text:"Primary"},{value:"secondary",text:"Secondary"},{value:"info",text:"Info"},{value:"success",text:"Success"},{value:"warning",text:"Warning"},{value:"danger",text:"Danger"}]}},methods:{submit:function(){var t=this;this.submitState||(this.submitState=!0,this.$inertia.post(route(this.__store),this.form).then((function(){return t.submitState=!1})))}}},o=a("KHd+"),l=Object(o.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[a("flash-msg"),t._v(" "),a("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[a("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Create New Maintenance Message")])]),t._v(" "),a("breadcrumb",{attrs:{items:t.breadcrumbItems}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("b-card",{attrs:{"no-body":""}},[a("b-form",{attrs:{id:"form"},on:{submit:function(e){return e.preventDefault(),t.submit(e)}}},[a("b-card-body",[a("b-col",{attrs:{col:"",lg:"5",md:"auto"}},[a("b-form-group",{attrs:{id:"input-group-title",label:"Message","label-for":"textarea","invalid-feedback":t.errors.msg?t.errors.msg[0]:"",state:!t.errors.msg&&null}},[a("b-form-textarea",{attrs:{id:"textarea",type:"text",name:"msg",placeholder:"Maintenance Message",state:!t.errors.msg&&null,rows:"3","max-rows":"6",trim:"",required:""},model:{value:t.form.msg,callback:function(e){t.$set(t.form,"msg",e)},expression:"form.msg"}})],1),t._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Status","label-for":"input-title","invalid-feedback":t.errors.status?t.errors.status[0]:"",state:!t.errors.status&&null}},[a("b-form-select",{attrs:{placeholder:"-- Select Status Maintenance Message --",options:t.options},model:{value:t.form.status,callback:function(e){t.$set(t.form,"status",e)},expression:"form.status"}})],1),t._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Type","label-for":"input-title","invalid-feedback":t.errors.type?t.errors.type[0]:"",state:!t.errors.type&&null}},[a("b-form-select",{attrs:{placeholder:"-- Select Type Maintenance Message --",options:t.optiontypes},model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}})],1)],1),t._v(" "),a("b-row",{attrs:{"align-h":"center"}},[a("b-button-group",[a("b-button",{attrs:{type:"submit",variant:"primary"}},[t._v("Submit")])],1)],1)],1)],1)],1)],1)])],1)}),[],!1,null,null,null);e.default=l.exports},Dt6l:function(t,e,a){"use strict";function s(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var a=[],s=!0,r=!1,i=void 0;try{for(var n,o=t[Symbol.iterator]();!(s=(n=o.next()).done)&&(a.push(n.value),!e||a.length!==e);s=!0);}catch(t){r=!0,i=t}finally{try{s||null==o.return||o.return()}finally{if(r)throw i}}return a}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return r(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return r(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function r(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,s=new Array(e);a<e;a++)s[a]=t[a];return s}var i={mounted:function(){for(var t=0,e=Object.entries(this.pageFlashes);t<e.length;t++){var a=s(e[t],2),r=a[0],i=a[1];i&&("success"==r&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=r,this.msg=i,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var e=this;_.each(t,(function(t,a){t&&("success"==a&&e.$emit("onSuccess",!0),e.dismissCountDown=3,e.variant=a,e.msg=t,e.pageFlashes[a]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},n=a("KHd+"),o=Object(n.a)(i,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(e){t.dismissCountDown=e},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);e.a=o.exports},gwhN:function(t,e,a){"use strict";var s={props:["notif"],components:{SidebarItem:a("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"super.dashboard",index:"super.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"User Management",link:"super.user.*",index:"super.user.index",icon:"fas fa-fw fa-user"},{id:2,title:"Memo Management",link:"super.memo_management.*",index:"super.memo_management.index",icon:"fas fa-fw fa-file"},{id:3,title:"Reference",link:"#",icon:"fas fa-fw fa-folder",child:[{title:"Position",link:"super.ref_position.*",index:"super.ref_position.index"},{title:"Title",link:"super.ref_title.*",index:"super.ref_title.index"},{title:"Approver",link:"super.ref_approver.*",index:"super.ref_approver.index"},{title:"Type Memo",link:"super.ref_type_memo.*",index:"super.ref_type_memo.index"}]},{id:4,title:"Maintenance",link:"super.maintenance.*",index:"super.maintenance.index",icon:"fas fa-fw fa-wrench"}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},r=a("KHd+"),i={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},n={components:{Sidebar:Object(r.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[a("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("super.dashboard")}},[a("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("SuperMenu WebSHF")])]),t._v(" "),a("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),a("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),a("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"text-center d-none d-md-inline"},[e("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(r.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("nav",{staticClass:"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"},[t._m(0),t._v(" "),a("ul",{staticClass:"navbar-nav ml-auto"},[t._m(1),t._v(" "),a("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))]),t._v(" "),a("b-avatar",{attrs:{variant:"primary",icon:"person-badge",size:"2rem"}})],1),t._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[a("button",{staticClass:"dropdown-item",on:{click:function(e){t.show=!0}}},[a("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])])])]),t._v(" "),a("b-modal",{attrs:{title:"Logout","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[a("b-button",{attrs:{variant:"secondary"},on:{click:function(e){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),a("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(e){t.show=e},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[e("i",{staticClass:"fa fa-bars"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[e("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[e("div",{staticClass:"input-group"},[e("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),e("div",{staticClass:"input-group-append"},[e("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[e("i",{staticClass:"fas fa-search fa-sm"})])])])])])])}],!1,null,null,null).exports,Footer:Object(r.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("footer",{staticClass:"sticky-footer bg-white"},[e("div",{staticClass:"container my-auto"},[e("div",{staticClass:"copyright text-center my-auto"},[e("span",[this._v("Copyright © Your Website 2020")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},o=Object(r.a)(n,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"wrapper"}},[e("Sidebar"),this._v(" "),e("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[e("div",{attrs:{id:"content"}},[e("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),e("main",[e("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),e("Footer")],1)],1)}),[],!1,null,null,null);e.a=o.exports},jMhu:function(t,e,a){"use strict";var s={props:{items:{type:Array}}},r=a("KHd+"),i=Object(r.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ol",{staticClass:"breadcrumb"},t._l(t.items,(function(e){return a("li",{key:e.title,staticClass:"breadcrumb-item",class:{active:e.active}},[e.active?a("span",[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")]):a("inertia-link",{attrs:{href:e.param?t.route(e.href,e.param):t.route(e.href)}},[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);e.a=i.exports},rYOV:function(t,e,a){"use strict";var s={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var e=0;e<t.child.length;e++)if(this.route().current(t.child[e].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},r=a("KHd+"),i=Object(r.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",t._l(t.items,(function(e){return a("li",{key:e.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(e)?"active":""},[1==t.isArrayRoutes(e)?a("div",[a("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(e)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+e.title+"Page","aria-expanded":"false","aria-controls":e.title+"Page"}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(e)?a("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(e)?"show":"",attrs:{id:e.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[a("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(e.child,(function(e,s){return a("inertia-link",{key:s,class:t.isRoute(e.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(e.index)}},[e.badge?a("span",[a("span",{class:!t.isRoute(e.link)&&"font-weight-bold"},[t._v(t._s(e.title))]),t._v(" "),a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})])]):a("span",[t._v(t._s(e.title)+" ")])])})),1)]):t._e()]):a("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(e.index)}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);e.a=i.exports}}]);