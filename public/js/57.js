(window.webpackJsonp=window.webpackJsonp||[]).push([[57],{"/hvw":function(e,t,a){"use strict";a.r(t);var r=a("gwhN"),i=a("Dt6l"),n=a("jMhu"),s={props:["_token","userinfo","notif","breadcrumbItems","dataDepartments","dataBranches","dataRefModuleApprovers","dataEmployee","errors","__store"],components:{Layout:r.a,FlashMsg:i.a,Breadcrumb:n.a},data:function(){return{submitState:!1,form:{name:"",refmoduleapprover:null,id_overtake:null,id_confirmed_payment_by:null,id_branch:null,department:null,with_po:!1,with_payment:!1,type:null},options:[{value:null,text:"--Please select a type memo--"},{value:"approval",text:"Approval"},{value:"payment",text:"Payment"}]}},watch:{"form.with_payment":function(e){e||(this.form.id_overtake=null,"payment"!=this.form.type&&(this.form.id_confirmed_payment_by=null))},"form.type":function(e){"payment"!=e&&(this.form.id_overtake=null,1!=this.form.with_payment&&(this.form.id_confirmed_payment_by=null))}},methods:{submit:function(){var e=this;this.submitState||(this.submitState=!0,this.$inertia.post(route(this.__store),this.form).then((function(){return e.submitState=!1})))}}},o=a("KHd+"),l=Object(o.a)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("layout",{attrs:{userinfo:e.userinfo,notif:e.notif}},[a("flash-msg"),e._v(" "),a("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[a("h1",{staticClass:"h3 mb-0 text-gray-800"},[e._v("Create New Reference Type Memo")])]),e._v(" "),a("breadcrumb",{attrs:{items:e.breadcrumbItems}}),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("b-card",{attrs:{"no-body":""}},[a("b-form",{attrs:{id:"form"},on:{submit:function(t){return t.preventDefault(),e.submit(t)}}},[a("b-card-body",[a("b-col",{attrs:{col:"",lg:"3",md:"auto"}},[a("b-form-group",{attrs:{id:"input-group-title",label:"Type Memo Name:","label-for":"input-title","invalid-feedback":e.errors.name?e.errors.name[0]:"",state:!e.errors.name&&null}},[a("b-form-input",{attrs:{id:"input-title",type:"text",name:"name",placeholder:"Type Memo Name",state:!e.errors.name&&null,trim:""},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),e._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Department:","label-for":"input-title","invalid-feedback":e.errors.department?e.errors.department[0]:"",state:!e.errors.department&&null,description:"Let this field blank for general memo."}},[a("v-select",{attrs:{placeholder:"-- Select Department --",label:"department_name",options:e.dataDepartments,reduce:function(e){return e.id},required:!e.form.department},model:{value:e.form.department,callback:function(t){e.$set(e.form,"department",t)},expression:"form.department"}})],1),e._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Branch:","label-for":"input-title","invalid-feedback":e.errors.id_branch?e.errors.id_branch[0]:"",state:!e.errors.id_branch&&null}},[a("v-select",{attrs:{placeholder:"-- Select Branch --",label:"branch_name",options:e.dataBranches,reduce:function(e){return e.id},required:!e.form.id_branch},model:{value:e.form.id_branch,callback:function(t){e.$set(e.form,"id_branch",t)},expression:"form.id_branch"}})],1),e._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Role Module Approver:","label-for":"input-title","invalid-feedback":e.errors.refmoduleapprover?e.errors.refmoduleapprover[0]:"",state:!e.errors.refmoduleapprover&&null}},[a("v-select",{attrs:{placeholder:"-- Select Module Approver --",label:"name",options:e.dataRefModuleApprovers,reduce:function(e){return e.id},required:!e.form.refmoduleapprover},model:{value:e.form.refmoduleapprover,callback:function(t){e.$set(e.form,"refmoduleapprover",t)},expression:"form.refmoduleapprover"}})],1),e._v(" "),a("b-form-checkbox",{attrs:{name:"checkbox-1",value:!0,"unchecked-value":!1},model:{value:e.form.with_po,callback:function(t){e.$set(e.form,"with_po",t)},expression:"form.with_po"}},[e._v("\n                with Purchase Order\n              ")]),e._v(" "),a("b-form-checkbox",{attrs:{name:"checkbox-2",value:!0,"unchecked-value":!1},model:{value:e.form.with_payment,callback:function(t){e.$set(e.form,"with_payment",t)},expression:"form.with_payment"}},[e._v("\n                with Payment\n              ")]),e._v(" "),a("b-form-group",{staticClass:"mt-2",attrs:{id:"input-group-title",label:"Type Memo","label-for":"input-title","invalid-feedback":e.errors.type?e.errors.type[0]:"",state:!e.errors.type&&null}},[a("b-form-select",{attrs:{placeholder:"-- Select Type Memo --",options:e.options},model:{value:e.form.type,callback:function(t){e.$set(e.form,"type",t)},expression:"form.type"}})],1),e._v(" "),e.form.with_payment?a("b-form-group",{staticClass:"mt-2",attrs:{id:"input-group-title",label:"Overtake Payment By:","label-for":"input-title","invalid-feedback":e.errors.id_overtake?e.errors.id_overtake[0]:"",state:!e.errors.id_overtake&&null,description:"Let this field blank if no need to overtake memo payment."}},[a("v-select",{attrs:{placeholder:"",label:"label",options:e.dataEmployee,reduce:function(e){return e.id},required:!e.form.id_overtake},model:{value:e.form.id_overtake,callback:function(t){e.$set(e.form,"id_overtake",t)},expression:"form.id_overtake"}})],1):e._e(),e._v(" "),e.form.with_payment||"payment"==e.form.type?a("b-form-group",{staticClass:"mt-2",attrs:{id:"input-group-title",label:"Confirmed Payment By:","label-for":"input-title","invalid-feedback":e.errors.id_confirmed_payment_by?e.errors.id_confirmed_payment_by[0]:"",state:!e.errors.id_confirmed_payment_by&&null,description:"Fill in this column to indicate the employee who is responsible for confirming payments."}},[a("v-select",{attrs:{placeholder:"",label:"label",options:e.dataEmployee,reduce:function(e){return e.id},required:!e.form.id_confirmed_payment_by},model:{value:e.form.id_confirmed_payment_by,callback:function(t){e.$set(e.form,"id_confirmed_payment_by",t)},expression:"form.id_confirmed_payment_by"}})],1):e._e()],1),e._v(" "),a("b-row",{attrs:{"align-h":"center"}},[a("b-button-group",[a("b-button",{attrs:{type:"submit",variant:"primary"}},[e._v("Submit")]),e._v(" "),a("b-button",{attrs:{type:"reset",variant:"secondary"}},[e._v("Reset")])],1)],1)],1)],1)],1)],1)])],1)}),[],!1,null,null,null);t.default=l.exports},Dt6l:function(e,t,a){"use strict";function r(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var a=[],r=!0,i=!1,n=void 0;try{for(var s,o=e[Symbol.iterator]();!(r=(s=o.next()).done)&&(a.push(s.value),!t||a.length!==t);r=!0);}catch(e){i=!0,n=e}finally{try{r||null==o.return||o.return()}finally{if(i)throw n}}return a}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return i(e,t);var a=Object.prototype.toString.call(e).slice(8,-1);"Object"===a&&e.constructor&&(a=e.constructor.name);if("Map"===a||"Set"===a)return Array.from(e);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return i(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,r=new Array(t);a<t;a++)r[a]=e[a];return r}var n={mounted:function(){for(var e=0,t=Object.entries(this.pageFlashes);e<t.length;e++){var a=r(t[e],2),i=a[0],n=a[1];n&&("success"==i&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=i,this.msg=n,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(e){var t=this;_.each(e,(function(e,a){e&&("success"==a&&t.$emit("onSuccess",!0),t.dismissCountDown=3,t.variant=a,t.msg=e,t.pageFlashes[a]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},s=a("KHd+"),o=Object(s.a)(n,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:e.variant},model:{value:e.dismissCountDown,callback:function(t){e.dismissCountDown=t},expression:"dismissCountDown"}},[e._v("\n  "+e._s(e.msg)+"\n")])}),[],!1,null,null,null);t.a=o.exports},gwhN:function(e,t,a){"use strict";var r={props:["notif"],components:{SidebarItem:a("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"super.dashboard",index:"super.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"User Management",link:"super.user.*",index:"super.user.index",icon:"fas fa-fw fa-user"},{id:2,title:"Memo Management",link:"super.memo_management.*",index:"super.memo_management.index",icon:"fas fa-fw fa-file"},{id:3,title:"Reference",link:"#",icon:"fas fa-fw fa-folder",child:[{title:"Position",link:"super.ref_position.*",index:"super.ref_position.index"},{title:"Title",link:"super.ref_title.*",index:"super.ref_title.index"},{title:"Approver",link:"super.ref_approver.*",index:"super.ref_approver.index"},{title:"Type Memo",link:"super.ref_type_memo.*",index:"super.ref_type_memo.index"}]},{id:4,title:"Maintenance",link:"super.maintenance.*",index:"super.maintenance.index",icon:"fas fa-fw fa-wrench"}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(e){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},i=a("KHd+"),n={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},s={components:{Sidebar:Object(i.a)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[a("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:e.route("super.dashboard")}},[a("div",{staticClass:"sidebar-brand-text mx-3"},[e._v("SuperMenu WebSHF")])]),e._v(" "),a("hr",{staticClass:"sidebar-divider my-0"}),e._v(" "),a("sidebar-item",{attrs:{items:e.itemsNav}}),e._v(" "),a("hr",{staticClass:"sidebar-divider d-none d-md-block"}),e._v(" "),e._m(0)],1)}),[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"text-center d-none d-md-inline"},[t("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(i.a)(n,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("nav",{staticClass:"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"},[e._m(0),e._v(" "),a("ul",{staticClass:"navbar-nav ml-auto"},[e._m(1),e._v(" "),a("div",{staticClass:"topbar-divider d-none d-sm-block"}),e._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[e._v(e._s(e.userdata.name))]),e._v(" "),a("b-avatar",{attrs:{variant:"primary",icon:"person-badge",size:"2rem"}})],1),e._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[a("button",{staticClass:"dropdown-item",on:{click:function(t){e.show=!0}}},[a("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),e._v("\n          Logout\n        ")])])])]),e._v(" "),a("b-modal",{attrs:{title:"Logout","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:e._u([{key:"modal-footer",fn:function(){return[a("b-button",{attrs:{variant:"secondary"},on:{click:function(t){e.show=!1}}},[e._v(" Cancel ")]),e._v(" "),a("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:e.route("logout")}},[e._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:e.show,callback:function(t){e.show=t},expression:"show"}},[e._v("\n    You will be log out\n    ")])],1)}),[function(){var e=this.$createElement,t=this._self._c||e;return t("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[t("i",{staticClass:"fa fa-bars"})])},function(){var e=this.$createElement,t=this._self._c||e;return t("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[t("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[t("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),t("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[t("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[t("div",{staticClass:"input-group"},[t("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),t("div",{staticClass:"input-group-append"},[t("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[t("i",{staticClass:"fas fa-search fa-sm"})])])])])])])}],!1,null,null,null).exports,Footer:Object(i.a)({},(function(){var e=this.$createElement;this._self._c;return this._m(0)}),[function(){var e=this.$createElement,t=this._self._c||e;return t("footer",{staticClass:"sticky-footer bg-white"},[t("div",{staticClass:"container my-auto"},[t("div",{staticClass:"copyright text-center my-auto"},[t("span",[this._v("Copyright © Your Website 2020")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},o=Object(i.a)(s,(function(){var e=this.$createElement,t=this._self._c||e;return t("div",{attrs:{id:"wrapper"}},[t("Sidebar"),this._v(" "),t("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[t("div",{attrs:{id:"content"}},[t("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),t("main",[t("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),t("Footer")],1)],1)}),[],!1,null,null,null);t.a=o.exports},jMhu:function(e,t,a){"use strict";var r={props:{items:{type:Array}}},i=a("KHd+"),n=Object(i.a)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("ol",{staticClass:"breadcrumb"},e._l(e.items,(function(t){return a("li",{key:t.title,staticClass:"breadcrumb-item",class:{active:t.active}},[t.active?a("span",[t.icon?a("i",{staticClass:"fas",class:t.icon}):e._e(),e._v("\n      "+e._s(t.title)+"\n    ")]):a("inertia-link",{attrs:{href:t.param?e.route(t.href,t.param):e.route(t.href)}},[t.icon?a("i",{staticClass:"fas",class:t.icon}):e._e(),e._v("\n      "+e._s(t.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);t.a=n.exports},rYOV:function(e,t,a){"use strict";var r={props:{items:Array},methods:{isArrayRoutes:function(e){return!(void 0===e.child||!Array.isArray(e.child))},checkStatusRoutes:function(e){if(void 0!==e.child&&Array.isArray(e.child)){for(var t=0;t<e.child.length;t++)if(this.route().current(e.child[t].link))return!0;return!1}if(this.isRoute(e.link))return!0}}},i=a("KHd+"),n=Object(i.a)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",e._l(e.items,(function(t){return a("li",{key:t.id,staticClass:"nav-item",class:1==e.checkStatusRoutes(t)?"active":""},[1==e.isArrayRoutes(t)?a("div",[a("a",{staticClass:"nav-link",class:1==e.checkStatusRoutes(t)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+t.title+"Page","aria-expanded":"false","aria-controls":t.title+"Page"}},[a("i",{class:t.icon}),e._v(" "),a("span",[e._v(e._s(t.title))]),e._v(" "),t.badge?a("span",[a("i",{staticClass:"fas fa-exclamation-circle"})]):e._e()]),e._v(" "),1==e.isArrayRoutes(t)?a("div",{staticClass:"collapse",class:1==e.checkStatusRoutes(t)?"show":"",attrs:{id:t.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[a("div",{staticClass:"bg-white py-2 collapse-inner rounded"},e._l(t.child,(function(t,r){return a("inertia-link",{key:r,class:e.isRoute(t.link)?"collapse-item active":"collapse-item",attrs:{href:e.route(t.index)}},[t.badge?a("span",[a("span",{class:!e.isRoute(t.link)&&"font-weight-bold"},[e._v(e._s(t.title))]),e._v(" "),a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})])]):a("span",[e._v(e._s(t.title)+" ")])])})),1)]):e._e()]):a("inertia-link",{staticClass:"nav-link",attrs:{href:e.route(t.index)}},[a("i",{class:t.icon}),e._v(" "),a("span",[e._v(e._s(t.title))]),e._v(" "),t.badge?a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})]):e._e()])],1)})),0)}),[],!1,null,null,null);t.a=n.exports}}]);