(window.webpackJsonp=window.webpackJsonp||[]).push([[31],{"3hz9":function(t,e,a){"use strict";var i={props:["title","caption","variant","idItemClicked"],data:function(){return{useMessage:!1,message:""}},methods:{actionHideModal:function(){this.$emit("handleHidden",!0),this.resetModal()},resetModal:function(){this.message="",this.useMessage=!1},onChangeCheckMessage:function(t){t||(this.message="")},handleOk:function(t){t.preventDefault(),this.handleSubmit()},handleSubmit:function(){var t=this;this.$emit("handleOk",{message:this.message,id:this.idItemClicked,variant:this.variant}),this.$nextTick((function(){t.$bvModal.hide("modal-prevent-closing")}))}}},s=a("KHd+"),n=Object(s.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-modal",{ref:"modal",attrs:{id:"modal-prevent-closing",title:t.title},on:{show:t.resetModal,hidden:t.actionHideModal,ok:t.handleOk}},[a("form",{ref:"form",on:{submit:function(e){return e.stopPropagation(),e.preventDefault(),t.handleSubmit(e)}}},[a("p",[t._v(t._s(t.caption))]),t._v(" "),a("b-form-group",{attrs:{"label-for":"name-input"}},[t.useMessage?a("b-form-textarea",{staticClass:"mb-2",attrs:{id:"textarea",placeholder:"Enter message...",rows:"3","max-rows":"6"},model:{value:t.message,callback:function(e){t.message=e},expression:"message"}}):t._e(),t._v(" "),a("b-form-checkbox",{attrs:{id:"checkbox-1",name:"checkbox-1",value:!0,"unchecked-value":!1},on:{change:t.onChangeCheckMessage},model:{value:t.useMessage,callback:function(e){t.useMessage=e},expression:"useMessage"}},[t._v("\n        With message\n      ")])],1)],1)])}),[],!1,null,null,null);e.a=n.exports},Dt6l:function(t,e,a){"use strict";function i(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var a=[],i=!0,s=!1,n=void 0;try{for(var o,r=t[Symbol.iterator]();!(i=(o=r.next()).done)&&(a.push(o.value),!e||a.length!==e);i=!0);}catch(t){s=!0,n=t}finally{try{i||null==r.return||r.return()}finally{if(s)throw n}}return a}(t,e)||function(t,e){if(!t)return;if("string"==typeof t)return s(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return s(t,e)}(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function s(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,i=new Array(e);a<e;a++)i[a]=t[a];return i}var n={mounted:function(){for(var t=0,e=Object.entries(this.pageFlashes);t<e.length;t++){var a=i(e[t],2),s=a[0],n=a[1];n&&("success"==s&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=s,this.msg=n,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var e=this;_.each(t,(function(t,a){t&&("success"==a&&e.$emit("onSuccess",!0),e.dismissCountDown=3,e.variant=a,e.msg=t,e.pageFlashes[a]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},o=a("KHd+"),r=Object(o.a)(n,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(e){t.dismissCountDown=e},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);e.a=r.exports},EWPF:function(t,e,a){"use strict";var i={props:["notif"],components:{SidebarItem:a("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"user.dashboard",index:"user.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"Memo",link:"#",icon:"fas fa-fw fa-clipboard",badge:this.notif.confirmed_paymentmemo,child:[{title:"New Memo",link:"user.memo.create",index:"user.memo.create"},{title:"Draft",link:"user.memo.draft.*",index:"user.memo.draft.index"},{title:"Status Memo",link:"user.memo.statusmemo.*",index:"user.memo.statusmemo.index"},{title:"Status Payment",link:"user.memo.statuspayment.*",index:"user.memo.statuspayment.index"},{title:"Status PO",link:"user.memo.statuspo.*",index:"user.memo.statuspo.index"}]},{id:2,title:"Approval",link:"#",icon:"fas fa-fw fa-clipboard-check",badge:this.notif.approval_memo||this.notif.approval_memo_payment||this.notif.approval_memo_po,child:[{title:"Approval Memo",link:"user.memo.approval.memo.*",index:"user.memo.approval.memo.index",badge:this.notif.approval_memo},{title:"Approval Payment",link:"user.memo.approval.payment.*",index:"user.memo.approval.payment.index",badge:this.notif.approval_memo_payment},{title:"Approval PO",link:"user.memo.approval.po.*",index:"user.memo.approval.po.index",badge:this.notif.approval_memo_po}]}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},beforeMount:function(){var t=this.$inertia.page.props.userinfo,e=t.employee.overtake,a=t.employee.confirmed_payment;e&&this.itemsNav[1].child.push({title:"Status Memo Branch",link:"user.memo.statustakeovermemobranch.*",index:"user.memo.statustakeovermemobranch.index"},{title:"Status Payment Branch",link:"user.memo.statustakeoverpaymentbranch.*",index:"user.memo.statustakeoverpaymentbranch.index"}),a&&this.itemsNav[1].child.push({title:"Confirm Payment",link:"user.memo.confirmpayment.*",index:"user.memo.confirmpayment.index",badge:this.notif.confirmed_paymentmemo})},mounted:function(){$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},s=a("KHd+"),n={props:["userdata"],data:function(){return{show:!1,alertstatus:null,messagestatus:null}}},o={components:{Sidebar:Object(s.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[a("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("user.dashboard")}},[a("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("User WebSHF")])]),t._v(" "),a("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),a("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),a("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"text-center d-none d-md-inline"},[e("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,Navbar:Object(s.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("nav",{staticClass:"\n    navbar navbar-expand navbar-light\n    bg-white\n    topbar\n    mb-4\n    static-top\n    shadow\n  "},[t._m(0),t._v(" "),a("ul",{staticClass:"navbar-nav ml-auto"},[t._m(1),t._v(" "),a("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),a("li",{staticClass:"nav-item dropdown no-arrow"},[a("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[a("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))]),t._v(" "),a("b-avatar",{attrs:{variant:"primary",icon:"person-badge",size:"2rem"}})],1),t._v(" "),a("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[a("inertia-link",{staticClass:"dropdown-item",attrs:{href:t.route("user.setting.changepassword.index")}},[a("i",{staticClass:"fas fa-key fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Change Password\n        ")]),t._v(" "),a("div",{staticClass:"dropdown-divider"}),t._v(" "),a("button",{staticClass:"dropdown-item",on:{click:function(e){t.show=!0}}},[a("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])],1)])]),t._v(" "),a("b-modal",{attrs:{title:"Logout",centered:"","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[a("b-button",{attrs:{variant:"secondary"},on:{click:function(e){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),a("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(e){t.show=e},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[e("i",{staticClass:"fa fa-bars"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"nav-item dropdown no-arrow d-sm-none"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"searchDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("i",{staticClass:"fas fa-search fa-fw"})]),this._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in",attrs:{"aria-labelledby":"searchDropdown"}},[e("form",{staticClass:"form-inline mr-auto w-100 navbar-search"},[e("div",{staticClass:"input-group"},[e("input",{staticClass:"form-control bg-light border-0 small",attrs:{type:"text",placeholder:"Search for...","aria-label":"Search","aria-describedby":"basic-addon2"}}),this._v(" "),e("div",{staticClass:"input-group-append"},[e("button",{staticClass:"btn btn-primary",attrs:{type:"button"}},[e("i",{staticClass:"fas fa-search fa-sm"})])])])])])])}],!1,null,null,null).exports,Footer:Object(s.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("footer",{staticClass:"sticky-footer bg-white"},[e("div",{staticClass:"container my-auto"},[e("div",{staticClass:"copyright text-center my-auto"},[e("span",[this._v("Copyright © PT Sinarmas Hana Finance 2021")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},r=Object(s.a)(o,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{attrs:{id:"wrapper"}},[e("Sidebar",{attrs:{notif:this.notif}}),this._v(" "),e("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[e("div",{attrs:{id:"content"}},[e("Navbar",{attrs:{userdata:this.userinfo}}),this._v(" "),e("main",[e("div",{staticClass:"container-fluid"},[this._t("default")],2)])],1),this._v(" "),e("Footer")],1)],1)}),[],!1,null,null,null);e.a=r.exports},"KHd+":function(t,e,a){"use strict";function i(t,e,a,i,s,n,o,r){var l,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=a,d._compiled=!0),i&&(d.functional=!0),n&&(d._scopeId="data-v-"+n),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},d._ssrRegister=l):s&&(l=r?function(){s.call(this,(d.functional?this.parent:this).$root.$options.shadowRoot)}:s),l)if(d.functional){d._injectStyles=l;var c=d.render;d.render=function(t,e){return l.call(e),c(t,e)}}else{var m=d.beforeCreate;d.beforeCreate=m?[].concat(m,l):[l]}return{exports:t,options:d}}a.d(e,"a",(function(){return i}))},W2Fo:function(t,e,a){!function(t){"use strict";!function(){if("undefined"!=typeof document){var t=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style"),a=" .timeline { padding: 0; position: relative; list-style: none; font-family: PingFangSC-light, Avenir, Helvetica, Arial, Hiragino Sans GB, Microsoft YaHei, sans-serif; -webkit-font-smoothing: antialiased; margin: 10px 20px; } .timeline:after { position: absolute; content: ''; left: 0; top: 0; width: 1px; height: 100%; background-color: var(--timelineTheme); } .timeline-item { position: relative; margin: 1.5em 0 0 28px; padding-bottom: 1.5em; border-bottom: 1px dotted var(--timelineTheme); } .timeline-item:last-child { border-bottom: none; } .timeline-circle { position: absolute; top: .28em; left: -34px; width: 10px; height: 10px; border-radius: 50%; border: 1px solid var(--timelineTheme); background-color: var(--timelineTheme); z-index: 1; box-sizing: content-box; } .timeline-circle.hollow { background-color: var(--timelineBg); } .timeline-title { position: relative; display: inline-block; /** * BFC inline-block 元素与其兄弟元素、子元素和父元素的外边距都不会折叠（包括其父元素和子元素） */ cursor: crosshair; margin: -.15em 0 15px 28px } .timeline-title:not(:first-child) { margin-top: 28px; } .timeline-title-circle { left: -36px; top: .15em; width: 16px; height: 16px; } .timeline-others { width: 40px; height: auto; top: .2em; left: -48px; line-height: 1; padding: 2px 0; text-align: center; border: none; background-color: var(--timelineBg); } ";e.type="text/css",e.styleSheet?e.styleSheet.cssText=a:e.appendChild(document.createTextNode(a)),t.appendChild(e)}}();var e={render:function(){var t=this.$createElement;return(this._self._c||t)("ul",{ref:"timeline",staticClass:"timeline"},[this._t("default")],2)},staticRenderFns:[],name:"Timeline",props:{timelineTheme:{type:String,default:"#dbdde0"},timelineBg:{type:String,default:"#fff"}},mounted:function(){var t=this.$refs.timeline;t.style.setProperty("--timelineTheme",this.timelineTheme),t.style.setProperty("--timelineBg",this.timelineBg)}};!function(){if("undefined"!=typeof document){var t=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",e.styleSheet?e.styleSheet.cssText="":e.appendChild(document.createTextNode("")),t.appendChild(e)}}();var a={name:"TimelineItemBase",props:{bgColor:{type:String,default:""},lineColor:{type:String,default:""},hollow:{type:Boolean,default:!1},fontColor:{type:String,default:"#37414a"}},data:function(){return{slotOthers:!1}},computed:{circleStyle:function(){if(this.bgColor||this.lineColor||this.hollow){var t={};return this.bgColor&&(t={"border-color":this.bgColor,"background-color":this.bgColor}),this.lineColor&&(t=Object.assign({},t,{"border-color":this.lineColor})),t}},itemStyle:function(){return{color:this.fontColor}},slotClass:function(){var t="";return this.slotOthers?t="timeline-others":this.hollow&&(t="hollow"),t}},mounted:function(){this.slotOthers=!!this.$refs.others.innerHTML}};!function(){if("undefined"!=typeof document){var t=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",e.styleSheet?e.styleSheet.cssText="":e.appendChild(document.createTextNode("")),t.appendChild(e)}}();var i={render:function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"timeline-item",style:this.itemStyle},[e("div",{ref:"others",staticClass:"timeline-circle",class:this.slotClass,style:this.circleStyle},[this._t("others")],2),this._v(" "),this._t("default")],2)},staticRenderFns:[],extends:a};!function(){if("undefined"!=typeof document){var t=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",e.styleSheet?e.styleSheet.cssText="":e.appendChild(document.createTextNode("")),t.appendChild(e)}}();var s={render:function(){var t=this.$createElement,e=this._self._c||t;return e("li",{staticClass:"timeline-title",style:this.itemStyle},[e("div",{ref:"others",staticClass:"timeline-circle timeline-title-circle",class:this.slotClass,style:this.circleStyle},[this._t("others")],2),this._v(" "),this._t("default")],2)},staticRenderFns:[],extends:a};"undefined"!=typeof window&&window.Vue&&(window.Vue.component(e.name,e),window.Vue.component(i.name,i),window.Vue.component(s.name,s)),t.Timeline=e,t.TimelineItem=i,t.TimelineTitle=s,Object.defineProperty(t,"__esModule",{value:!0})}(e)},jMhu:function(t,e,a){"use strict";var i={props:{items:{type:Array}}},s=a("KHd+"),n=Object(s.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("ol",{staticClass:"breadcrumb"},t._l(t.items,(function(e){return a("li",{key:e.title,staticClass:"breadcrumb-item",class:{active:e.active}},[e.active?a("span",[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")]):a("inertia-link",{attrs:{href:e.param?t.route(e.href,e.param):t.route(e.href)}},[e.icon?a("i",{staticClass:"fas",class:e.icon}):t._e(),t._v("\n      "+t._s(e.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);e.a=n.exports},n4UZ:function(t,e,a){"use strict";a.r(e);var i=a("EWPF"),s=a("Dt6l"),n=a("jMhu"),o=a("W2Fo"),r=a("3hz9"),l={props:["userinfo","notif","breadcrumbItems","dataMemo","dataTotalCost","proposeEmployee","memocost","attachments","__approving"],metaInfo:{title:"Preview Approval PO"},components:{Layout:i.a,FlashMsg:s.a,Breadcrumb:n.a,Timeline:o.Timeline,TimelineItem:o.TimelineItem,TimelineTitle:o.TimelineTitle,ModalFormMemoApproval:r.a},data:function(){return{timelinecolor:{success:"#1cc88a",info:"#36b9cc",danger:"#e74a3b",warning:"#f6c23e"},buttonClicked:"",idItemClicked:null,modalTitle:"",modalCaption:""}},methods:{actionApprove:function(t){this.buttonClicked="approve",this.idItemClicked=t,this.modalTitle="Modal Approve",this.modalCaption="Are you sure to approve?",this.$root.$emit("bv::show::modal","modal-prevent-closing","#btnShow")},actionNext:function(t){this.buttonClicked="approve",this.idItemClicked=t,this.modalTitle="Modal Acknowledge",this.modalCaption="Are you sure to next?",this.$root.$emit("bv::show::modal","modal-prevent-closing","#btnShow")},actionReject:function(t){this.buttonClicked="reject",this.idItemClicked=t,this.modalTitle="Modal Reject",this.modalCaption="Are you sure to reject?",this.$root.$emit("bv::show::modal","modal-prevent-closing","#btnShow")},handleHidden:function(){this.buttonClicked="",this.idItemClicked=null,this.modalTitle="",this.modalCaption=""},handleOk:function(t){var e=this;this.$inertia.put(route(this.__approving,t.id),t).then((function(){e.buttonClicked="",e.idItemClicked=null,e.modalTitle="",e.modalCaption=""}))},submitDelete:function(t){},showMsgBoxDelete:function(t){var e=this;this.$bvModal.msgBoxConfirm("Please confirm that you want to delete this reference approver.",{title:"Please Confirm",size:"sm",buttonSize:"sm",okVariant:"danger",okTitle:"YES",cancelTitle:"NO",footerClass:"p-2",hideHeaderClose:!1,centered:!0}).then((function(a){a&&e.submitDelete(t)})).catch((function(t){}))},reset:function(){this.form=mapValues(this.form,(function(){return null}))}}},d=a("KHd+"),c=Object(d.a)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[a("flash-msg"),t._v(" "),a("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[a("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Purchase Order "+t._s(t.dataMemo.po_no))])]),t._v(" "),a("breadcrumb",{attrs:{items:t.breadcrumbItems}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("b-card",{attrs:{"no-body":""}},[a("b-card-body",[a("b-row",{staticClass:"mb-2"},["approver"==t.dataMemo.approver_po.type_approver&&"submit"==t.dataMemo.approver_po.status?a("b-col",{staticClass:"mb-4",attrs:{col:"",lg:"12",md:"12"}},[a("b-button-group",{staticClass:"float-right"},[a("b-button",{attrs:{variant:"info"},on:{click:function(e){return t.actionApprove(t.dataMemo.approver_po.id)}}},[t._v("Approve")]),t._v(" "),a("b-button",{attrs:{variant:"warning"},on:{click:function(e){return t.actionReject(t.dataMemo.approver_po.id)}}},[t._v("Reject")])],1)],1):"approver"!=t.dataMemo.approver_po.type_approver&&"submit"==t.dataMemo.approver_po.status?a("b-col",{staticClass:"mb-4",attrs:{col:"",lg:"12",md:"12"}},[a("b-button-group",{staticClass:"float-right"},[a("b-button",{attrs:{variant:"info"},on:{click:function(e){return t.actionNext(t.dataMemo.approver_po.id)}}},[t._v("Next")])],1)],1):t._e(),t._v(" "),a("b-col",{attrs:{col:"",lg:"12",md:"auto"}},[a("h5",[t._v("Memo Information")]),t._v(" "),a("table",{staticClass:"table table-bordered"},[a("tbody",[a("tr",[a("td",[t._v("Proposed By")]),t._v(" "),a("td",[t._v("\n                      "+t._s(t.proposeEmployee.firstname+" "+t.proposeEmployee.lastname)+"\n                    ")])]),t._v(" "),a("tr",[a("td",[t._v("Status")]),t._v(" "),a("td",["submit"==t.dataMemo.status_po?a("b-badge",{attrs:{variant:"info"}},[t._v("On process approving PO")]):t._e(),t._v(" "),"approve"==t.dataMemo.status_po?a("b-badge",{attrs:{variant:"success"}},[t._v("Memo PO Approved")]):t._e(),t._v(" "),"reject"==t.dataMemo.status_po?a("b-badge",{attrs:{variant:"danger"}},[t._v("Memo PO Rejected")]):t._e()],1)]),t._v(" "),a("tr",[a("td",[t._v("Department")]),t._v(" "),a("td",[t._v("\n                      "+t._s(t.proposeEmployee.emp_history.position.department.department_name)+"\n                    ")])]),t._v(" "),a("tr",[a("td",[t._v("Title")]),t._v(" "),a("td",[t._v(t._s(t.dataMemo.title))])]),t._v(" "),a("tr",[a("td",[t._v("Doc. No")]),t._v(" "),a("td",[t._v(t._s(t.dataMemo.doc_no))])]),t._v(" "),a("tr",[a("td",[t._v("Type")]),t._v(" "),a("td",[t._v("Approval")])])])])]),t._v(" "),a("b-col",{attrs:{col:"",lg:"12",md:"auto"}},[a("h5",[t._v("Approver")]),t._v(" "),a("table",{staticClass:"table table-bordered mb-2"},[a("thead",{staticClass:"thead-dark"},[a("tr",[a("th",[t._v("Level")]),t._v(" "),a("th",[t._v("Approver Name")]),t._v(" "),a("th",[t._v("Position")]),t._v(" "),a("th",[t._v("Approver Type")]),t._v(" "),a("th",[t._v("Status")]),t._v(" "),a("th",[t._v("Message")])])]),t._v(" "),a("tbody",t._l(t.dataMemo.approvers_po,(function(e,i){return a("tr",{key:i},[a("td",[t._v("\n                      "+t._s(i+1)+"\n                    ")]),t._v(" "),a("td",[t._v("\n                      "+t._s(e.employee.firstname+" "+e.employee.lastname)+"\n                    ")]),t._v(" "),a("td",[t._v("\n                      "+t._s(e.employee.emp_history.position.position_name)+"\n                    ")]),t._v(" "),a("td",[t._v("\n                      "+t._s(e.type_approver)+"\n                    ")]),t._v(" "),a("td",["submit"==e.status?a("b-badge",{attrs:{variant:"info"}},[t._v("On Submit")]):t._e(),t._v(" "),"approve"==e.status?a("b-badge",{attrs:{variant:"success"}},[t._v("Approved")]):t._e(),t._v(" "),"reject"==e.status?a("b-badge",{attrs:{variant:"danger"}},[t._v("Rejected")]):t._e()],1),t._v(" "),a("td",[e.msg?a("p",[t._v(t._s(e.msg))]):a("span",[t._v("-")])])])})),0)]),t._v(" "),t.dataMemo&&t.dataMemo.histories.length>0?a("div",{staticClass:"card mb-4"},[a("div",{staticClass:"\n                    card-header\n                    py-3\n                    d-flex\n                    flex-row\n                    align-items-center\n                    justify-content-between\n                  "},[a("h6",{staticClass:"m-0 font-weight-bold text-primary"},[t._v("History")])]),t._v(" "),a("div",{staticClass:"card-body"},[a("div",{staticClass:"overflow-auto",staticStyle:{height:"218px"}},[a("timeline",t._l(t.dataMemo.histories,(function(e,i){return a("timeline-item",{key:i,attrs:{"bg-color":t.timelinecolor[e.type]}},[a("strong",[t._v("\n                          "+t._s(e.title)+"\n                          "),a("span",{staticClass:"float-right"},[a("small",{staticClass:"text-muted"},[a("em",[t._v("\n                                "+t._s(t._f("moment")(e.created_at,"D/M/YY,h:mm a"))+"\n                              ")])])])]),t._v(" "),a("p",[a("small",{staticClass:"text-muted"},[t._v(t._s(e.content))])])])})),1)],1)])]):t._e()])],1),t._v(" "),t.dataMemo.background&&"<p></p>"!=t.dataMemo.background?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Background")]),t._v(" "),a("div",{domProps:{innerHTML:t._s(t.dataMemo.background)}})])],1):t._e(),t._v(" "),t.dataMemo.information&&"<p></p>"!=t.dataMemo.information?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Information")]),t._v(" "),a("div",{domProps:{innerHTML:t._s(t.dataMemo.information)}})])],1):t._e(),t._v(" "),t.dataMemo.conclusion&&"<p></p>"!=t.dataMemo.conclusion?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Conclusion")]),t._v(" "),a("div",{domProps:{innerHTML:t._s(t.dataMemo.conclusion)}})])],1):t._e(),t._v(" "),t.memocost.length>0?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Cost/Expense")]),t._v(" "),a("b-table",{attrs:{bordered:"",items:t.memocost}})],1)],1):t._e(),t._v(" "),1==t.dataMemo.ref_table.with_payment||1==t.dataMemo.ref_table.with_po?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("table",{staticClass:"table table-stripped table-bordered"},[a("tbody",[a("tr",[a("th",{staticStyle:{width:"50%"}},[t._v("Sub Total")]),t._v(" "),a("td",{attrs:{nowrap:""}},[a("div",{staticStyle:{float:"left"}},[t._v("Rp")]),t._v(" "),a("div",{staticStyle:{float:"right"}},[t._v("\n                        "+t._s(Number(t.dataTotalCost.sub_total).toLocaleString())+"\n                      ")])])]),t._v(" "),a("tr",[a("th",{staticStyle:{width:"50%"}},[t._v("Pph23 (2%)")]),t._v(" "),a("td",{attrs:{nowrap:""}},[a("div",{staticStyle:{float:"left"}},[t._v("Rp")]),t._v(" "),a("div",{staticStyle:{float:"right"}},[t._v("\n                        "+t._s(Number(t.dataTotalCost.pph).toLocaleString())+"\n                      ")])])]),t._v(" "),a("tr",[a("th",{staticStyle:{width:"50%"}},[t._v("PPN (10%)")]),t._v(" "),a("td",{attrs:{nowrap:""}},[a("div",{staticStyle:{float:"left"}},[t._v("Rp")]),t._v(" "),a("div",{staticStyle:{float:"right"}},[t._v("\n                        "+t._s(Number(t.dataTotalCost.ppn).toLocaleString())+"\n                      ")])])]),t._v(" "),a("tr",[a("th",{staticStyle:{width:"50%"}},[t._v("Grand Total")]),t._v(" "),a("td",{attrs:{nowrap:""}},[a("div",{staticStyle:{float:"left"}},[t._v("Rp")]),t._v(" "),a("div",{staticStyle:{float:"right"}},[t._v("\n                        "+t._s(Number(t.dataTotalCost.grand_total).toLocaleString())+"\n                      ")])])])])])])],1):t._e(),t._v(" "),t.dataMemo.payment&&"<p></p>"!=t.dataMemo.payment?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Payment")]),t._v(" "),a("div",{domProps:{innerHTML:t._s(t.dataMemo.payment)}})])],1):t._e(),t._v(" "),t.attachments.length>0?a("b-row",{staticClass:"mb-2"},[a("b-col",[a("h5",[t._v("Attachment")]),t._v(" "),a("table",{staticClass:"table table-bordered"},[a("thead",{staticClass:"thead-dark"},[a("tr",[a("th",[t._v("file")])])]),t._v(" "),a("tbody",t._l(t.attachments,(function(e,i){return a("tr",{key:i},[a("a",{attrs:{href:e.name,target:"_blank",rel:"noopener noreferrer"}},[t._v("\n                      "+t._s(e.real_name)+"\n                    ")])])})),0)])])],1):t._e()],1)],1)],1)]),t._v(" "),a("modal-form-memo-approval",{attrs:{title:t.modalTitle,caption:t.modalCaption,variant:t.buttonClicked,idItemClicked:t.idItemClicked},on:{handleOk:t.handleOk,handleHidden:t.handleHidden}})],1)}),[],!1,null,null,null);e.default=c.exports},rYOV:function(t,e,a){"use strict";var i={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var e=0;e<t.child.length;e++)if(this.route().current(t.child[e].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},s=a("KHd+"),n=Object(s.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",t._l(t.items,(function(e){return a("li",{key:e.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(e)?"active":""},[1==t.isArrayRoutes(e)?a("div",[a("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(e)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+e.title+"Page","aria-expanded":"false","aria-controls":e.title+"Page"}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(e)?a("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(e)?"show":"",attrs:{id:e.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[a("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(e.child,(function(e,i){return a("inertia-link",{key:i,class:t.isRoute(e.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(e.index)}},[e.badge?a("span",[a("span",{class:!t.isRoute(e.link)&&"font-weight-bold"},[t._v(t._s(e.title))]),t._v(" "),a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})])]):a("span",[t._v(t._s(e.title)+" ")])])})),1)]):t._e()]):a("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(e.index)}},[a("i",{class:e.icon}),t._v(" "),a("span",[t._v(t._s(e.title))]),t._v(" "),e.badge?a("span",{staticClass:"float-right"},[a("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);e.a=n.exports}}]);