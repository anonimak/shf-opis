(window.webpackJsonp=window.webpackJsonp||[]).push([[26],{"23xE":function(t,e,a){"use strict";var s=a("GVGN");a.n(s).a},"3sLf":function(t,e,a){(t.exports=a("I1BE")(!1)).push([t.i,".table td.fit[data-v-002d5492],.table th.fit[data-v-002d5492]{white-space:nowrap;width:1%}",""])},"9Qmd":function(t,e,a){"use strict";var s={props:["notif"],components:{SidebarItem:a("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"admin.dashboard",index:"admin.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"Master",link:"#",icon:"fas fa-fw fa-folder",child:[{title:"Branch Office",link:"admin.branch.*",index:"admin.branch.index"},{title:"Department",link:"admin.department.*",index:"admin.department.index"},{title:"Employee",link:"admin.employee.*",index:"admin.employee.index"}]}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},i=a("KHd+"),r={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},n={components:{Sidebar:Object(i.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[a("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("admin.dashboard")}},[a("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("WebSHF")])]),t._v(" "),a("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),a("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),a("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"text-center d-none d-md-inline"},[e("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(i.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("nav",{staticClass:"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"},[t._m(0),t._v(" "),a("ul",{staticClass:"navbar-nav ml-auto"},[t._m(1),t._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow mx-1"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"alertsDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("i",{staticClass:"fas fa-bell fa-fw"}),t._v(" "),t.alertstatus?a("span",{staticClass:"badge badge-danger badge-counter"},[t._v("3+")]):t._e()]),t._v(" "),t.alertstatus?a("div",{staticClass:"dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"alertsDropdown"}},[a("h6",{staticClass:"dropdown-header"},[t._v("Alerts Center")]),t._v(" "),t._m(2),t._v(" "),t._m(3),t._v(" "),t._m(4),t._v(" "),a("a",{staticClass:"dropdown-item text-center small text-gray-500",attrs:{href:"#"}},[t._v("Show All Alerts")])]):t._e()]),t._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow mx-1"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"messagesDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("i",{staticClass:"fas fa-envelope fa-fw"}),t._v(" "),t.messagestatus?a("span",{staticClass:"badge badge-danger badge-counter"},[t._v("7")]):t._e()]),t._v(" "),t.messagestatus?a("div",{staticClass:"dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"messagesDropdown"}},[a("h6",{staticClass:"dropdown-header"},[t._v("Message Center")]),t._v(" "),t._m(5),t._v(" "),t._m(6),t._v(" "),t._m(7),t._v(" "),t._m(8),t._v(" "),a("a",{staticClass:"dropdown-item text-center small text-gray-500",attrs:{href:"#"}},[t._v("Read More Messages")])]):t._e()]),t._v(" "),a("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))])]),t._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[t._m(9),t._v(" "),a("div",{staticClass:"dropdown-divider"}),t._v(" "),a("button",{staticClass:"dropdown-item",on:{click:function(e){t.show=!0}}},[a("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])])])]),t._v(" "),a("b-modal",{attrs:{title:"Logout","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[a("b-button",{attrs:{variant:"secondary"},on:{click:function(e){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),a("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(e){t.show=e},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[e("i",{staticClass:"fa fa-bars"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[e("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[e("div",{staticClass:"input-group"},[e("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),e("div",{staticClass:"input-group-append"},[e("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[e("i",{staticClass:"fas fa-search fa-sm"})])])])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"mr-3"},[e("div",{staticClass:"icon-circle bg-primary"},[e("i",{staticClass:"fas fa-file-alt text-white"})])]),this._v(" "),e("div",[e("div",{staticClass:"small text-gray-500"},[this._v("December 12, 2019")]),this._v(" "),e("span",{staticClass:"font-weight-bold"},[this._v("A new monthly report is ready to download!")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"mr-3"},[e("div",{staticClass:"icon-circle bg-success"},[e("i",{staticClass:"fas fa-donate text-white"})])]),this._v(" "),e("div",[e("div",{staticClass:"small text-gray-500"},[this._v("December 7, 2019")]),this._v("\n            $290.29 has been deposited into your account!\n          ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"mr-3"},[e("div",{staticClass:"icon-circle bg-warning"},[e("i",{staticClass:"fas fa-exclamation-triangle text-white"})])]),this._v(" "),e("div",[e("div",{staticClass:"small text-gray-500"},[this._v("December 2, 2019")]),this._v("\n            Spending Alert: We've noticed unusually high spending for your\n            account.\n          ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"dropdown-list-image mr-3"},[e("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/fn_BT9fwg_E/60x60",alt:""}}),this._v(" "),e("div",{staticClass:"status-indicator bg-success"})]),this._v(" "),e("div",{staticClass:"font-weight-bold"},[e("div",{staticClass:"text-truncate"},[this._v("\n              Hi there! I am wondering if you can help me with a problem I've\n              been having.\n            ")]),this._v(" "),e("div",{staticClass:"small text-gray-500"},[this._v("Emily Fowler · 58m")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"dropdown-list-image mr-3"},[e("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/AU4VPcFN4LE/60x60",alt:""}}),this._v(" "),e("div",{staticClass:"status-indicator"})]),this._v(" "),e("div",[e("div",{staticClass:"text-truncate"},[this._v("\n              I have the photos that you ordered last month, how would you\n              like them sent to you?\n            ")]),this._v(" "),e("div",{staticClass:"small text-gray-500"},[this._v("Jae Chun · 1d")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"dropdown-list-image mr-3"},[e("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/CS2uCrpNzJY/60x60",alt:""}}),this._v(" "),e("div",{staticClass:"status-indicator bg-warning"})]),this._v(" "),e("div",[e("div",{staticClass:"text-truncate"},[this._v("\n              Last month's report looks great, I am very happy with the\n              progress so far, keep up the good work!\n            ")]),this._v(" "),e("div",{staticClass:"small text-gray-500"},[this._v("Morgan Alvarez · 2d")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item d-flex align-items-center",attrs:{href:"#"}},[e("div",{staticClass:"dropdown-list-image mr-3"},[e("img",{staticClass:"rounded-circle",attrs:{src:"https://source.unsplash.com/Mv9hjnEUHR4/60x60",alt:""}}),this._v(" "),e("div",{staticClass:"status-indicator bg-success"})]),this._v(" "),e("div",[e("div",{staticClass:"text-truncate"},[this._v("\n              Am I a good boy? The reason I ask is because someone told me\n              that people say this to all dogs, even if they aren't good...\n            ")]),this._v(" "),e("div",{staticClass:"small text-gray-500"},[this._v("Chicken the Dog · 2w")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"dropdown-item",attrs:{href:"#"}},[e("i",{staticClass:"fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"}),this._v("\n          Settings\n        ")])}],!1,null,null,null).exports,Footer:Object(i.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("footer",{staticClass:"sticky-footer bg-white"},[e("div",{staticClass:"container my-auto"},[e("div",{staticClass:"copyright text-center my-auto"},[e("span",[this._v("Copyright © Your Website 2020")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},o=Object(i.a)(n,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"wrapper"}},[e("Sidebar"),this._v(" "),e("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[e("div",{attrs:{id:"content"}},[e("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),e("main",[e("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),e("Footer")],1)],1)}),[],!1,null,null,null);e.a=o.exports},Dt6l:function(t,e,a){"use strict";function s(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var a=[],s=!0,i=!1,r=void 0;try{for(var n,o=t[Symbol.iterator]();!(s=(n=o.next()).done)&&(a.push(n.value),!e||a.length!==e);s=!0);}catch(t){i=!0,r=t}finally{try{s||null==o.return||o.return()}finally{if(i)throw r}}return a}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return i(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return i(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,s=new Array(e);a<e;a++)s[a]=t[a];return s}var r={mounted:function(){for(var t=0,e=Object.entries(this.pageFlashes);t<e.length;t++){var a=s(e[t],2),i=a[0],r=a[1];r&&("success"==i&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=i,this.msg=r,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var e=this;_.each(t,(function(t,a){t&&("success"==a&&e.$emit("onSuccess",!0),e.dismissCountDown=3,e.variant=a,e.msg=t,e.pageFlashes[a]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},n=a("KHd+"),o=Object(n.a)(r,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(e){t.dismissCountDown=e},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);e.a=o.exports},GVGN:function(t,e,a){var s=a("3sLf");"string"==typeof s&&(s=[[t.i,s,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};a("aET+")(s,i);s.locals&&(t.exports=s.locals)},"KHd+":function(t,e,a){"use strict";function s(t,e,a,s,i,r,n,o){var l,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=a,d._compiled=!0),s&&(d.functional=!0),r&&(d._scopeId="data-v-"+r),n?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(n)},d._ssrRegister=l):i&&(l=o?function(){i.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:i),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,e){return l.call(e),c(t,e)}}else{var u=d.beforeCreate;d.beforeCreate=u?[].concat(u,l):[l]}return{exports:t,options:d}}a.d(e,"a",(function(){return s}))},VeUk:function(t,e,a){"use strict";a.r(e);var s=a("9Qmd"),i=a("Dt6l"),r=a("jMhu"),n={props:{dataBranch:{type:Array,default:[]},dataPosition:{type:Array,default:[]},errors:{type:Object,default:{}},indexEmpHistory:{type:Number,default:null}},watch:{checkboxdatenow:function(t){t?this.form.year_finished=null:this.id_form&&(this.form.year_finished=this.bckup_year_finished)}},data:function(){return{form:{id_branch:null,id_position:null,year_started:null,year_finished:null},bckup_year_finished:null,checkboxdatenow:!0,id_form:null,modalTitle:""}},methods:{getData:function(){if(null!==this.indexEmpHistory){this.modalTitle="Edit History";var t=this.$page.employee_detail[this.indexEmpHistory];t.year_finished&&(this.checkboxdatenow=!1),this.id_form=t.id,this.bckup_year_finished=t.year_finished,this.form=Object.assign({},this.form,{id_branch:t.id_branch,id_position:t.id_position,year_started:t.year_started,year_finished:t.year_finished})}else this.modalTitle="Add New History"},resetModal:function(){this.form={id_branch:null,id_position:null,year_started:null,year_finished:null},this.id_form=null,this.checkboxdatenow=!0,this.bckup_year_finished=null},handleOk:function(t){t.preventDefault(),this.handleSubmit()},handleSubmit:function(){var t=this;this.id_form?this.$inertia.put(route("admin.employee.history.update",[this.$page.employee.id,this.id_form]),this.form).then((function(){0===Object.entries(t.errors).length&&t.$nextTick((function(){t.$bvModal.hide("modal-prevent-closing")}))})):this.$inertia.post(route("admin.employee.history.store",this.$page.employee.id),this.form).then((function(){0===Object.entries(t.errors).length&&t.$nextTick((function(){t.$bvModal.hide("modal-prevent-closing")}))}))}}},o=a("KHd+"),l=Object(o.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-modal",{ref:"modal",attrs:{id:"modal-prevent-closing",title:t.modalTitle,"ok-title":"Save"},on:{show:t.getData,hidden:t.resetModal,ok:t.handleOk}},[a("form",{ref:"form",on:{submit:function(e){return e.stopPropagation(),e.preventDefault(),t.handleSubmit(e)}}},[a("b-form-group",{attrs:{id:"input-group-title",label:"Branch:","label-for":"input-title","invalid-feedback":t.errors.id_branch?t.errors.id_branch[0]:"",state:!t.errors.id_branch&&null}},[a("v-select",{attrs:{label:"branch_name",placeholder:"-- Select Branch --",options:t.dataBranch,reduce:function(t){return t.id},required:!t.form.id_branch},model:{value:t.form.id_branch,callback:function(e){t.$set(t.form,"id_branch",e)},expression:"form.id_branch"}})],1),t._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Position:","label-for":"input-title","invalid-feedback":t.errors.id_position?t.errors.id_position[0]:"",state:!t.errors.id_position&&null}},[a("v-select",{attrs:{label:"position_name",placeholder:"-- Select Position --",options:t.dataPosition,reduce:function(t){return t.id},required:!t.form.id_position},model:{value:t.form.id_position,callback:function(e){t.$set(t.form,"id_position",e)},expression:"form.id_position"}})],1),t._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"Start Date:","label-for":"input-title","invalid-feedback":t.errors.year_started?t.errors.year_started[0]:"",state:!t.errors.year_started&&null}},[a("b-form-datepicker",{staticClass:"mb-2",attrs:{id:"yearstarted-datepicker",placeholder:"Start Date","date-format-options":{year:"numeric",month:"numeric",day:"numeric"},locale:"id",state:!t.errors.year_started&&null},model:{value:t.form.year_started,callback:function(e){t.$set(t.form,"year_started",e)},expression:"form.year_started"}})],1),t._v(" "),a("b-form-group",{attrs:{id:"input-group-title",label:"End Date:","label-for":"input-title","invalid-feedback":t.errors.year_finished?t.errors.year_finished[0]:"",state:!t.errors.year_finished&&null}},[a("b-form-datepicker",{staticClass:"mb-2",attrs:{id:"yearfinished-datepicker",disabled:t.checkboxdatenow,placeholder:"End Date","date-format-options":{year:"numeric",month:"numeric",day:"numeric"},locale:"id",state:!t.errors.year_finished&&null},model:{value:t.form.year_finished,callback:function(e){t.$set(t.form,"year_finished",e)},expression:"form.year_finished"}})],1),t._v(" "),a("b-form-checkbox",{staticClass:"mb-2",attrs:{id:"checkbox-1",name:"checkbox-1",value:!0,"unchecked-value":!1},model:{value:t.checkboxdatenow,callback:function(e){t.checkboxdatenow=e},expression:"checkboxdatenow"}},[t._v("\n        Until now\n      ")])],1)])],1)}),[],!1,null,null,null).exports,d={props:["employee","employee_detail","dataBranch","dataPosition","errors","flash","breadcrumbItems","userinfo","notif","perPage","__edit","__destroy_history"],metaInfo:{title:"Admin Employee"},data:function(){return{itemClicked:null}},components:{Layout:s.a,FlashMsg:i.a,Breadcrumb:r.a,ModalFormEmpHistory:l},methods:{submitDelete:function(t){this.$inertia.delete(route(this.__destroy_history,[this.employee.id,t]))},showMsgBoxDeleteHistory:function(t){var e=this;this.$bvModal.msgBoxConfirm("Please confirm that you want to delete this history.",{title:"Please Confirm",size:"sm",buttonSize:"sm",okVariant:"danger",okTitle:"YES",cancelTitle:"NO",footerClass:"p-2",hideHeaderClose:!1,centered:!0}).then((function(a){return a&&e.submitDelete(t)})).catch((function(t){}))}}},c=(a("23xE"),Object(o.a)(d,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[a("flash-msg"),t._v(" "),a("b-button",{staticClass:"float-right",attrs:{type:"button",variant:"dark"}},[t._v("Delete")]),t._v(" "),t.employee.terminated_at?t._e():a("b-button",{staticClass:"float-right mr-2",attrs:{type:"button",variant:"outline-danger"}},[t._v("Terminate")]),t._v(" "),a("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[a("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Detail Employee "+t._s(t.employee.nik))])]),t._v(" "),a("breadcrumb",{attrs:{items:t.breadcrumbItems}}),t._v(" "),a("div",{staticClass:"row"},[a("b-col",[a("b-card",{staticClass:"mb-2"},[a("b-row",[a("b-col",[a("inertia-link",{directives:[{name:"b-tooltip",rawName:"v-b-tooltip.hover.bottom",value:"Edit Employee",expression:"'Edit Employee'",modifiers:{hover:!0,bottom:!0}}],staticClass:"text-secondary float-right",attrs:{href:t.route(t.__edit,t.employee.id)}},[a("i",{staticClass:"fa fa-edit",attrs:{"aria-hidden":"true"}})]),t._v(" "),a("h4",[t._v("Personal Info")]),t._v(" "),a("hr"),t._v(" "),a("table",{staticClass:"table table-borderless"},[a("tbody",[a("tr",[a("th",{staticClass:"fit"},[t._v("Full Name")]),t._v(" "),a("td",[t._v(t._s(t.employee.firstname+" "+t.employee.lastname))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Title")]),t._v(" "),a("td",[t._v(t._s(t.employee.title&&t.employee.title.title_name))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Gender")]),t._v(" "),a("td",[t._v(t._s("L"===t.employee.gender?"Male":"Female"))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("NIK")]),t._v(" "),a("td",[t._v(t._s(t.employee.nik))])])])]),t._v(" "),a("h4",{staticClass:"mt-5"},[t._v("Contact Info")]),t._v(" "),a("hr"),t._v(" "),a("table",{staticClass:"table table-borderless"},[a("tbody",[a("tr",[a("th",{staticClass:"fit"},[t._v("Email")]),t._v(" "),a("td",[t._v(t._s(t.employee.email))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Mobile Phone")]),t._v(" "),a("td",[t._v(t._s(t.employee.mobile))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Telephone")]),t._v(" "),a("td",[t._v(t._s(t.employee.phone))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Telephone 2")]),t._v(" "),a("td",[t._v(t._s(t.employee.phone_two))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Address")]),t._v(" "),a("td",[t._v(t._s(t.employee.address))])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Address 2")]),t._v(" "),a("td",[t._v(t._s(t.employee.address_two))])])])]),t._v(" "),a("h4",{staticClass:"mt-5"},[t._v("Employee Info")]),t._v(" "),a("hr"),t._v(" "),a("table",{staticClass:"table table-borderless"},[a("tbody",[a("tr",[a("th",{staticClass:"fit"},[t._v("Hired Date")]),t._v(" "),a("td",[t._v("\n                    "+t._s(t._f("moment")(t.employee.hired_at,"DD/MM/YYYY"))+"\n                  ")])]),t._v(" "),a("tr",[a("th",{staticClass:"fit"},[t._v("Start Branch")]),t._v(" "),a("td",[t._v("\n                    "+t._s(t.employee.branch.branch_name)+"\n                  ")])]),t._v(" "),t.employee.terminated_at?a("tr",{staticClass:"text-danger"},[a("th",{staticClass:"fit"},[t._v("Terminate Date")]),t._v(" "),a("td",[t._v(t._s(t._f("moment")(t.employee.terminated_at,"DD/MM/YYYY")))])]):t._e()])])],1)],1)],1),t._v(" "),a("b-card",{staticClass:"mb-2"},[a("b-row",[a("b-col",[t.employee_detail.length>0?a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal.modal-prevent-closing",modifiers:{"modal-prevent-closing":!0}}],staticClass:"float-right",attrs:{size:"sm",variant:"primary"},on:{click:function(e){t.itemClicked=null}}},[a("i",{staticClass:"fa fa-plus"})]):t._e(),t._v(" "),a("h4",[t._v("Employee History")]),t._v(" "),a("hr"),t._v(" "),t.employee_detail.length>0?a("b-row",[a("b-col",[a("table",{staticClass:"table mt-4"},[a("thead",{staticClass:"thead-dark"},[a("tr",[a("th",{attrs:{scope:"col"}},[t._v("Position")]),t._v(" "),a("th",{attrs:{scope:"col"}}),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("Period")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v("Action")])])]),t._v(" "),a("tbody",t._l(t.employee_detail,(function(e,s){return a("tr",{key:e.id},[a("td",[a("em",[t._v(t._s(e.position.position_name))]),t._v(" in\n                        "+t._s(e.branch.branch_name)+"\n                      ")]),t._v(" "),a("td"),t._v(" "),a("td",[a("em",[a("span",[t._v("\n                            "+t._s(t._f("moment")(e.year_started,"DD MMMM YYYY"))+" ")]),t._v("-\n                          "),e.year_started&&e.year_finished?a("span",[t._v(t._s(t._f("moment")(e.year_finished,"DD MMMM YYYY")))]):a("span",[t._v("now")])])]),t._v(" "),a("td",[a("b-button-group",{attrs:{size:"sm"}},[a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal.modal-prevent-closing",modifiers:{"modal-prevent-closing":!0}}],attrs:{variant:"primary"},on:{click:function(e){t.itemClicked=s}}},[a("i",{staticClass:"fa fa-edit",attrs:{"aria-hidden":"true"}})]),t._v(" "),a("b-button",{attrs:{href:"#",variant:"danger"},on:{click:function(a){return t.showMsgBoxDeleteHistory(e.id)}}},[a("i",{staticClass:"fa fa-trash-alt",attrs:{"aria-hidden":"true"}})])],1)],1)])})),0)])])],1):a("b-row",{attrs:{"align-h":"center"}},[a("b-button",{directives:[{name:"b-modal",rawName:"v-b-modal.modal-prevent-closing",modifiers:{"modal-prevent-closing":!0}}],attrs:{variant:"primary"},on:{click:function(e){t.itemClicked=null}}},[t._v("Add Employee History")])],1)],1)],1)],1)],1)],1),t._v(" "),a("modal-form-emp-history",{attrs:{dataBranch:t.dataBranch,dataPosition:t.dataPosition,errors:t.errors,indexEmpHistory:t.itemClicked}})],1)}),[],!1,null,"002d5492",null));e.default=c.exports},jMhu:function(t,e,a){"use strict";var s={props:{items:{type:Array}}},i=a("KHd+"),r=Object(i.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ol",{staticClass:"breadcrumb"},t._l(t.items,(function(e){return a("li",{key:e.title,staticClass:"breadcrumb-item",class:{active:e.active}},[e.active?a("span",[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")]):a("inertia-link",{attrs:{href:e.param?t.route(e.href,e.param):t.route(e.href)}},[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);e.a=r.exports},rYOV:function(t,e,a){"use strict";var s={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var e=0;e<t.child.length;e++)if(this.route().current(t.child[e].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},i=a("KHd+"),r=Object(i.a)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",t._l(t.items,(function(e){return a("li",{key:e.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(e)?"active":""},[1==t.isArrayRoutes(e)?a("div",[a("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(e)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+e.title+"Page","aria-expanded":"false","aria-controls":e.title+"Page"}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(e)?a("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(e)?"show":"",attrs:{id:e.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[a("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(e.child,(function(e,s){return a("inertia-link",{key:s,class:t.isRoute(e.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(e.index)}},[e.badge?a("span",[a("span",{class:!t.isRoute(e.link)&&"font-weight-bold"},[t._v(t._s(e.title))]),t._v(" "),a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})])]):a("span",[t._v(t._s(e.title)+" ")])])})),1)]):t._e()]):a("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(e.index)}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);e.a=r.exports}}]);