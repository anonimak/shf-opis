(window.webpackJsonp=window.webpackJsonp||[]).push([[19],{Dt6l:function(t,a,e){"use strict";function n(t,a){return function(t){if(Array.isArray(t))return t}(t)||function(t,a){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var e=[],n=!0,i=!1,r=void 0;try{for(var o,s=t[Symbol.iterator]();!(n=(o=s.next()).done)&&(e.push(o.value),!a||e.length!==a);n=!0);}catch(t){i=!0,r=t}finally{try{n||null==s.return||s.return()}finally{if(i)throw r}}return e}(t,a)||function(t,a){if(!t)return;if("string"==typeof t)return i(t,a);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return i(t,a)}(t,a)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(t,a){(null==a||a>t.length)&&(a=t.length);for(var e=0,n=new Array(a);e<a;e++)n[e]=t[e];return n}var r={mounted:function(){for(var t=0,a=Object.entries(this.pageFlashes);t<a.length;t++){var e=n(a[t],2),i=e[0],r=e[1];r&&("success"==i&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=i,this.msg=r,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var a=this;_.each(t,(function(t,e){t&&("success"==e&&a.$emit("onSuccess",!0),a.dismissCountDown=3,a.variant=e,a.msg=t,a.pageFlashes[e]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},o=e("KHd+"),s=Object(o.a)(r,(function(){var t=this,a=t.$createElement;return(t._self._c||a)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(a){t.dismissCountDown=a},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);a.a=s.exports},EWPF:function(t,a,e){"use strict";var n={props:["notif"],components:{SidebarItem:e("rYOV").a},data:function(){return{itemsNav:[{id:0,title:"Dashboard",link:"user.dashboard",index:"user.dashboard",icon:"fas fa-fw fa-tachometer-alt"},{id:1,title:"Memo",link:"#",icon:"fas fa-fw fa-clipboard",badge:this.notif.confirmed_paymentmemo||this.notif.memo_branch,child:[{title:"New Memo",link:"user.memo.create",index:"user.memo.create"},{title:"Draft",link:"user.memo.draft.*",index:"user.memo.draft.index"},{title:"Status Memo",link:"user.memo.statusmemo.*",index:"user.memo.statusmemo.index"},{title:"Status Payment",link:"user.memo.statuspayment.*",index:"user.memo.statuspayment.index"},{title:"Status PO",link:"user.memo.statuspo.*",index:"user.memo.statuspo.index"}]},{id:2,title:"Approval",link:"#",icon:"fas fa-fw fa-clipboard-check",badge:this.notif.approval_memo||this.notif.approval_memo_payment||this.notif.approval_memo_po,child:[{title:"Approval Memo",link:"user.memo.approval.memo.*",index:"user.memo.approval.memo.index",badge:this.notif.approval_memo},{title:"Approval Payment",link:"user.memo.approval.payment.*",index:"user.memo.approval.payment.index",badge:this.notif.approval_memo_payment},{title:"Approval PO",link:"user.memo.approval.po.*",index:"user.memo.approval.po.index",badge:this.notif.approval_memo_po}]}]}},methods:{sidebarMenuHandle:function(){window.innerWidth,$(window).width()<480&&$(".sidebar").hasClass("toggled")}},beforeMount:function(){var t=this.$inertia.page.props.userinfo,a=t.employee.overtake,e=t.employee.confirmed_payment;a&&this.itemsNav[1].child.push({title:"Status Memo Branch",link:"user.memo.statustakeovermemobranch.*",index:"user.memo.statustakeovermemobranch.index",badge:this.notif.memo_branch},{title:"Status Payment Branch",link:"user.memo.statustakeoverpaymentbranch.*",index:"user.memo.statustakeoverpaymentbranch.index"}),e&&this.itemsNav[1].child.push({title:"Confirm Payment",link:"user.memo.confirmpayment.*",index:"user.memo.confirmpayment.index",badge:this.notif.confirmed_paymentmemo})},mounted:function(){this.isMobile()&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide")),$("#sidebarToggle, #sidebarToggleTop").on("click",(function(t){$("body").toggleClass("sidebar-toggled"),$(".sidebar").toggleClass("toggled"),$(".sidebar").hasClass("toggled")&&$(".sidebar .collapse").collapse("hide")})),$(window).resize((function(){$(window).width()<768&&$(".sidebar .collapse").collapse("hide"),$(window).width()<480&&!$(".sidebar").hasClass("toggled")&&($("body").addClass("sidebar-toggled"),$(".sidebar").addClass("toggled"),$(".sidebar .collapse").collapse("hide"))}))},created:function(){window.addEventListener("resize",this.sidebarMenuHandle)},destroyed:function(){window.removeEventListener("resize",this.sidebarMenuHandle)}},i=e("KHd+"),r=Object(i.a)(n,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("ul",{staticClass:"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",attrs:{id:"accordionSidebar"}},[e("inertia-link",{staticClass:"sidebar-brand d-flex align-items-center",attrs:{href:t.route("user.dashboard")}},[e("div",{staticClass:"sidebar-brand-text mx-3"},[t._v("User E-Memo")])]),t._v(" "),e("hr",{staticClass:"sidebar-divider my-0"}),t._v(" "),e("sidebar-item",{attrs:{items:t.itemsNav}}),t._v(" "),e("hr",{staticClass:"sidebar-divider d-none d-md-block"}),t._v(" "),t._m(0)],1)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("div",{staticClass:"text-center d-none d-md-inline"},[a("button",{staticClass:"rounded-circle border-0",attrs:{id:"sidebarToggle"}})])}],!1,null,null,null).exports,o=e("o0o1"),s=e.n(o);function l(t,a,e,n,i,r,o){try{var s=t[r](o),l=s.value}catch(t){return void e(t)}s.done?a(l):Promise.resolve(l).then(n,i)}var c,d,u={props:["userdata","notif"],data:function(){return{show:!1,alertstatus:null,messagestatus:null,url_mark_read_notif:"user.api.notification.read"}},mounted:function(){},methods:{onClickNotification:function(t){var a=this;this.getMarkReadNotif(t.id).then((function(e){e.data.is_read||(a.notif.unreadNotification--,a.notif.notification=a.notif.notification.map((function(a){return a.id===t.id&&(a.read_at=moment().format()),a})))})),this.$inertia.replace(t.data.url)},getMarkReadNotif:(c=s.a.mark((function t(a){return s.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.abrupt("return",axios.get(route(this.url_mark_read_notif,a)));case 1:case"end":return t.stop()}}),t,this)})),d=function(){var t=this,a=arguments;return new Promise((function(e,n){var i=c.apply(t,a);function r(t){l(i,e,n,r,o,"next",t)}function o(t){l(i,e,n,r,o,"throw",t)}r(void 0)}))},function(t){return d.apply(this,arguments)})}},m=Object(i.a)(u,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("nav",{staticClass:"\n    navbar navbar-expand navbar-light\n    bg-white\n    topbar\n    mb-4\n    static-top\n    shadow\n  ",class:t.isMobile()?"fixed-top":"static-top"},[t.isMobile()?t._e():e("button",{staticClass:"btn btn-link d-md-none rounded-circle mr-3",attrs:{id:"sidebarToggleTop"}},[e("i",{staticClass:"fa fa-bars"})]),t._v(" "),t.isMobile()?e("inertia-link",{attrs:{href:"#"}},[e("img",{attrs:{src:"/images/brand.png",alt:"",height:"24px"}})]):t._e(),t._v(" "),e("ul",{staticClass:"navbar-nav ml-auto"},[e("li",{staticClass:"nav-item dropdown no-arrow"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"notifDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"true"}},[e("i",{staticClass:"fas fa-bell fa-fw"}),t._v(" "),t.notif.unreadNotification>0?e("span",{staticClass:"badge badge-danger badge-counter"},[t._v(t._s(t.notif.unreadNotification>10?"10+":t.notif.unreadNotification))]):t._e()]),t._v(" "),e("div",{staticClass:"\n          dropdown-list dropdown-menu dropdown-menu-right\n          shadow\n          animated--grow-in\n        ",attrs:{"aria-labelledby":"notifDropdown"}},[e("h6",{staticClass:"dropdown-header"},[t._v("Notifications")]),t._v(" "),t.notif.notification.length>0?e("div",t._l(t.notif.notification,(function(a){return e("a",{key:a.id,staticClass:"dropdown-item d-flex",attrs:{href:"#"},on:{click:function(e){return t.onClickNotification(a)}}},[e("div",{staticClass:"col px-0"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[e("div",{staticClass:"small",class:a.read_at?["text-gray-500"]:["text-"+a.data.content.type," font-weight-bold"]},[t._v("\n                    "+t._s(a.data.content.doc_no)+"\n                  ")])]),t._v(" "),e("div",{staticClass:"col"},[e("div",{staticClass:"small float-right",class:a.read_at?"text-gray-400":"text-gray-700"},[t._v("\n                    "+t._s(t._f("moment")(a.created_at,"D/M/YY,h:mm a"))+"\n                  ")])])]),t._v(" "),e("div",{staticClass:"row mb-1"},[e("div",{staticClass:"col-12 font-weight-bold text-truncate",class:a.read_at?"text-gray-500":""},[t._v("\n                  "+t._s(a.data.content.caption)+"\n                ")])]),t._v(" "),e("span",{class:a.read_at?"text-gray-500":"font-italic"},[t._v(t._s(a.data.content.subject))])])])})),0):e("div",[e("span",{staticClass:"dropdown-item text-gray-500 font-italic"},[t._v("No notification found.")])])])]),t._v(" "),e("div",{staticClass:"topbar-divider d-none d-sm-block"}),t._v(" "),e("li",{staticClass:"nav-item dropdown no-arrow"},[e("a",{staticClass:"nav-link dropdown-toggle",attrs:{href:"#",id:"userDropdown",role:"button","data-toggle":"dropdown","aria-haspopup":"true","aria-expanded":"false"}},[e("span",{staticClass:"mr-2 d-none d-lg-inline text-gray-600 small"},[t._v(t._s(t.userdata.name))]),t._v(" "),e("b-avatar",{attrs:{variant:"primary",icon:"person-badge",size:"2rem"}})],1),t._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"userDropdown"}},[e("inertia-link",{staticClass:"dropdown-item",attrs:{href:t.route("user.setting.changepassword.index")}},[e("i",{staticClass:"fas fa-key fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Change Password\n        ")]),t._v(" "),e("div",{staticClass:"dropdown-divider"}),t._v(" "),e("button",{staticClass:"dropdown-item",on:{click:function(a){t.show=!0}}},[e("i",{staticClass:"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"}),t._v("\n          Logout\n        ")])],1)])]),t._v(" "),e("b-modal",{attrs:{title:"Logout",centered:"","header-bg-variant":"primary","header-text-variant":"light"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[e("b-button",{attrs:{variant:"secondary"},on:{click:function(a){t.show=!1}}},[t._v(" Cancel ")]),t._v(" "),e("b-link",{staticClass:"btn btn-primary",attrs:{size:"sm",href:t.route("logout")}},[t._v("\n        Log out\n      ")])]},proxy:!0}]),model:{value:t.show,callback:function(a){t.show=a},expression:"show"}},[t._v("\n    You will be log out\n    ")])],1)}),[],!1,null,null,null).exports,p={props:["notif"],data:function(){return{isOvertakeMemo:!1,isConfirmedPayment:!1,prevScrollpos:0}},beforeMount:function(){var t=this.$inertia.page.props.userinfo,a=t.employee.overtake,e=t.employee.confirmed_payment;this.isOvertakeMemo=a,this.isConfirmedPayment=e},mounted:function(){this.prevScrollpos=0,this.actionHideShowNav()},methods:{actionHideShowNav:function(){this.prevScrollpos=window.pageYOffset,window.onscroll=function(){var t=window.pageYOffset;this.prevScrollpos>t?$("#bottom-navbar").slideDown(100):$("#bottom-navbar").slideUp(100),this.prevScrollpos=t}}}},v=(e("fZLT"),{components:{Sidebar:r,Navbar:m,BottomNavbar:Object(i.a)(p,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("nav",{staticClass:"\n    navbar\n    border-top\n    navbar-expand\n    d-lg-none d-xl-none\n    fixed-bottom\n    bottom-navbar\n  ",attrs:{id:"bottom-navbar"}},[e("ul",{staticClass:"navbar-nav nav-justified mx-auto w-100"},[e("li",{staticClass:"nav-item"},[e("inertia-link",{staticClass:"nav-link",class:{active:t.isRoute("user.dashboard")||t.isRoute("user.setting.*")},attrs:{href:t.route("user.dashboard")}},[e("span",{staticClass:"icon-notif"},[e("i",{staticClass:"bx bx-home-alt"})]),t._v(" "),e("span",{staticClass:"title small d-block"},[t._v("Home")])])],1),t._v(" "),e("li",{staticClass:"nav-item"},[e("inertia-link",{staticClass:"nav-link",class:{active:t.isRoute("user.memo.draft.*")},attrs:{href:t.route("user.memo.draft.index")}},[e("span",{staticClass:"icon-notif"},[e("i",{staticClass:"bx bx-box"})]),t._v(" "),e("span",{staticClass:"title small d-block"},[t._v("Draft")])])],1),t._v(" "),e("li",{staticClass:"nav-item"},[e("inertia-link",{staticClass:"nav-link",class:{active:t.isRoute("user.memo.create")},attrs:{href:t.route("user.memo.create")}},[e("span",{staticClass:"icon-notif"},[e("i",{staticClass:"bx bx-plus-circle"})]),t._v(" "),e("span",{staticClass:"title small d-block"},[t._v("Create")])])],1),t._v(" "),e("li",{staticClass:"nav-item"},[e("div",{staticClass:"dropdown dropup"},[e("a",{staticClass:"nav-link nav-icon",class:{active:t.isRoute("user.memo.statusmemo.*")||t.isRoute("user.memo.statuspayment.*")||t.isRoute("user.memo.statuspo.*")||t.isRoute("user.memo.statustakeovermemobranch.*")||t.isRoute("user.memo.statustakeoverpaymentbranch.*")||t.isRoute("user.memo.confirmpayment.*")},attrs:{href:"#",id:"dropdownMenuButtonStatus","data-toggle":"dropdown"}},[e("span",{staticClass:"icon-notif"},[e("i",{staticClass:"bx bx-info-square"}),t._v(" "),t.notif.memo_branch||t.notif.confirmed_paymentmemo?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1),t._v(" "),e("span",{staticClass:"title small d-block"},[t._v("Status")])]),t._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"dropdownMenuButtonStatus"}},[e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.statusmemo.*")},attrs:{href:t.route("user.memo.statusmemo.index")}},[t._v("Memo\n          ")]),t._v(" "),e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.statuspayment.*")},attrs:{href:t.route("user.memo.statuspayment.index")}},[t._v("Payment\n          ")]),t._v(" "),e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.statuspo.*")},attrs:{href:t.route("user.memo.statuspo.index")}},[t._v("PO\n          ")]),t._v(" "),t.isOvertakeMemo?e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.statustakeovermemobranch.*")},attrs:{href:t.route("user.memo.statustakeovermemobranch.index")}},[t._v("Memo Branch\n            "),t.notif.memo_branch?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1):t._e(),t._v(" "),t.isOvertakeMemo?e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.statustakeoverpaymentbranch.*")},attrs:{href:t.route("user.memo.statustakeoverpaymentbranch.index")}},[t._v("Payment Branch\n          ")]):t._e(),t._v(" "),t.isConfirmedPayment?e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.confirmpayment.*")},attrs:{href:t.route("user.memo.confirmpayment.index")}},[t._v("Confirm Payment\n            "),t.notif.confirmed_paymentmemo?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1):t._e()],1)])]),t._v(" "),e("li",{staticClass:"nav-item"},[e("div",{staticClass:"dropdown dropup"},[e("a",{staticClass:"nav-link nav-icon",class:{active:t.isRoute("user.memo.approval.memo.*")||t.isRoute("user.memo.approval.payment.*")||t.isRoute("user.memo.approval.po.*")},attrs:{href:"#",id:"dropdownMenuButtonApproval","data-toggle":"dropdown"}},[e("span",{staticClass:"icon-notif"},[e("i",{staticClass:"bx bx-list-check"}),t._v(" "),t.notif.approval_memo||t.notif.approval_memo_payment||t.notif.approval_memo_po?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1),t._v(" "),e("span",{staticClass:"title small d-block"},[t._v("Approval")])]),t._v(" "),e("div",{staticClass:"dropdown-menu dropdown-menu-right shadow animated--grow-in",attrs:{"aria-labelledby":"dropdownMenuButtonApproval"}},[e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.approval.memo.*")},attrs:{href:t.route("user.memo.approval.memo.index")}},[t._v("Memo\n            "),t.notif.approval_memo?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1),t._v(" "),e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.approval.payment.*")},attrs:{href:t.route("user.memo.approval.payment.index")}},[t._v("Payment\n            "),t.notif.approval_memo_payment?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1),t._v(" "),e("inertia-link",{staticClass:"dropdown-item",class:{active:t.isRoute("user.memo.approval.po.*")},attrs:{href:t.route("user.memo.approval.po.index")}},[t._v("PO\n            "),t.notif.approval_memo_po?e("b-badge",{staticClass:"notif-badge",attrs:{pill:"",variant:"primary"}},[t._v("!")]):t._e()],1)],1)])])])])}),[],!1,null,"2d278c0c",null).exports,Footer:Object(i.a)({},(function(){var t=this.$createElement;this._self._c;return this._m(0)}),[function(){var t=this.$createElement,a=this._self._c||t;return a("footer",{staticClass:"sticky-footer bg-white"},[a("div",{staticClass:"container my-auto"},[a("div",{staticClass:"copyright text-center my-auto"},[a("span",[this._v("Copyright © PT Sinarmas Hana Finance 2021")])])])])}],!1,null,null,null).exports},props:["userinfo","notif"],data:function(){return{sound:new Audio("/sound/notification.mp3")}},methods:{handleLogout:function(){alert("Ini Sudah Logout")}},created:function(){var t=this;window.Echo.private("App.User.".concat(this.userinfo.id)).notification((function(a){switch(a.type){case"App\\Notifications\\ApprovalNotification":t.notif.unreadNotification++,t.sound.play();var e={created_at:moment().format(),data:{content:a.content,url:a.url},id:a.id,notifiable_id:t.userinfo.id,notifiable_type:"AppUser",read_at:null,type:"AppNotificationsApprovalNotification",updated_at:moment().format()};t.notif.notification.unshift(e)}}))}}),f=(e("xpOo"),Object(i.a)(v,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{attrs:{id:"wrapper"}},[t.isMobile()?t._e():e("Sidebar",{attrs:{notif:t.notif}}),t._v(" "),e("div",{staticClass:"d-flex flex-column",attrs:{id:"content-wrapper"}},[e("div",{style:t.isMobile()&&{"margin-bottom":"5rem"},attrs:{id:"content"}},[e("Navbar",{attrs:{userdata:t.userinfo,notif:t.notif}}),t._v(" "),t.isMobile()?e("BottomNavbar",{attrs:{notif:t.notif}}):t._e(),t._v(" "),e("main",[e("div",{staticClass:"container-fluid",style:t.isMobile()&&{"margin-top":"6rem"}},[t._t("default")],2)])],1),t._v(" "),t.isMobile()?t._e():e("Footer")],1)],1)}),[],!1,null,null,null));a.a=f.exports},JAR3:function(t,a,e){var n=e("Vvqk");"string"==typeof n&&(n=[[t.i,n,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,i);n.locals&&(t.exports=n.locals)},SdS2:function(t,a,e){var n=e("lgEA");"string"==typeof n&&(n=[[t.i,n,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(n,i);n.locals&&(t.exports=n.locals)},Vvqk:function(t,a,e){(t.exports=e("I1BE")(!1)).push([t.i,"nav[data-v-2d278c0c]{border-radius:20px 20px 0 0;padding:.9rem .5rem 0}nav ul.navbar-nav li.nav-item a[data-v-2d278c0c]:hover,nav ul.navbar-nav li.nav-item a:hover.nav-link[data-v-2d278c0c]{color:#006e63}nav ul.navbar-nav li.nav-item a.nav-link[data-v-2d278c0c]{padding:0!important;font-size:24px;display:inline-grid;color:#3a3b45;z-index:1}nav ul.navbar-nav li.nav-item a.nav-link span.title[data-v-2d278c0c]{display:none!important;font-size:10px}nav ul.navbar-nav li.nav-item a.nav-link.active[data-v-2d278c0c]{color:#009688;transform:translateY(-10%);transition:transform .5s cubic-bezier(.075,.82,.165,1);font-size:26px}nav ul.navbar-nav li.nav-item a.nav-link.active>span.title[data-v-2d278c0c],nav ul.navbar-nav li.nav-item a.nav-link.active span.notif-badge[data-v-2d278c0c]{display:block!important}nav ul.navbar-nav li.nav-item .icon-notif[data-v-2d278c0c]{height:28px;position:relative!important;margin-left:auto;margin-right:auto}nav ul.navbar-nav li.nav-item .dropdown[data-v-2d278c0c]{display:block}nav ul.navbar-nav li.nav-item .dropdown .dropdown-item>span.notif-badge[data-v-2d278c0c]{display:inline-block!important;font-size:60%}nav ul.navbar-nav li.nav-item .dropdown .dropdown-item.active>span.notif-badge[data-v-2d278c0c]{background-color:#fff;color:#009688}nav ul.navbar-nav li.nav-item .dropdown .icon-notif>span.notif-badge[data-v-2d278c0c],nav ul.navbar-nav li.nav-item .dropdown a.nav-link.active>.icon-notif>span.notif-badge[data-v-2d278c0c]{position:absolute;top:-3px;right:-4px;display:block;font-size:35%}nav .navbar-nav .active>.nav-link[data-v-2d278c0c],nav .navbar-nav .nav-link.active[data-v-2d278c0c],nav .navbar-nav .nav-link.show[data-v-2d278c0c],nav .navbar-nav .show>.nav-link[data-v-2d278c0c]{color:#009688}.bottom-navbar[data-v-2d278c0c]{background:#fff}",""])},fZLT:function(t,a,e){"use strict";var n=e("JAR3");e.n(n).a},iRsK:function(t,a,e){"use strict";e.r(a);var n=e("EWPF"),i=e("Dt6l"),r=e("jMhu"),o={metaInfo:{title:"Change Password"},props:["_token","userinfo","notif","breadcrumbItems","errors","__postUpdate"],components:{Layout:n.a,FlashMsg:i.a,Breadcrumb:r.a},data:function(){return{submitState:!1,form:{password:"",password_confirmation:""}}},methods:{submit:function(){var t=this;this.submitState||(this.submitState=!0,this.$inertia.put(route(this.__postUpdate),this.form).then((function(){return t.submitState=!1})))}}},s=e("KHd+"),l=Object(s.a)(o,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("layout",{attrs:{userinfo:t.userinfo,notif:t.notif}},[e("flash-msg"),t._v(" "),e("div",{staticClass:"d-sm-flex align-items-center justify-content-between mb-4"},[e("h1",{staticClass:"h3 mb-0 text-gray-800"},[t._v("Change Password")])]),t._v(" "),e("breadcrumb",{attrs:{items:t.breadcrumbItems}}),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12"},[e("b-card",{attrs:{"no-body":""}},[e("b-form",{attrs:{id:"form"},on:{submit:function(a){return a.preventDefault(),t.submit(a)}}},[e("b-card-body",[e("b-col",{attrs:{col:"",lg:"3",md:"auto"}},[e("b-form-group",{attrs:{id:"input-group-title",label:"New Password:","label-for":"input-title","invalid-feedback":t.errors.password?t.errors.password[0]:"",state:!t.errors.password&&null}},[e("b-form-input",{attrs:{id:"input-title",type:"password",name:"password",placeholder:"New Password",state:!t.errors.password&&null,trim:""},model:{value:t.form.password,callback:function(a){t.$set(t.form,"password",a)},expression:"form.password"}})],1),t._v(" "),e("b-form-group",{attrs:{id:"input-group-title",label:"Confirm Password:","label-for":"input-title","invalid-feedback":t.errors.password_confirmation?t.errors.password_confirmation[0]:"",state:!t.errors.password_confirmation&&null}},[e("b-form-input",{attrs:{id:"input-title",type:"password",name:"password",placeholder:"Confirm Password",state:!t.errors.password_confirmation&&null,trim:""},model:{value:t.form.password_confirmation,callback:function(a){t.$set(t.form,"password_confirmation",a)},expression:"form.password_confirmation"}})],1)],1),t._v(" "),e("b-row",{attrs:{"align-h":"center"}},[e("b-button-group",[e("b-button",{attrs:{type:"submit",variant:"primary"}},[t._v("Submit")]),t._v(" "),e("b-button",{attrs:{type:"reset",variant:"secondary"}},[t._v("Reset")])],1)],1)],1)],1)],1)],1)])],1)}),[],!1,null,null,null);a.default=l.exports},jMhu:function(t,a,e){"use strict";var n={props:{items:{type:Array}}},i=e("KHd+"),r=Object(i.a)(n,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("ol",{staticClass:"breadcrumb"},t._l(t.items,(function(a){return e("li",{key:a.title,staticClass:"breadcrumb-item",class:{active:a.active}},[a.active?e("span",[a.icon?e("i",{staticClass:"fas",class:a.icon}):t._e(),t._v("\n      "+t._s(a.title)+"\n    ")]):e("inertia-link",{attrs:{href:a.param?t.route(a.href,a.param):t.route(a.href)}},[a.icon?e("i",{staticClass:"fas",class:a.icon}):t._e(),t._v("\n      "+t._s(a.title)+"\n    ")])],1)})),0)}),[],!1,null,null,null);a.a=r.exports},lgEA:function(t,a,e){(t.exports=e("I1BE")(!1)).push([t.i,"body.modal-open{overflow:scroll!important}",""])},ls82:function(t,a,e){var n=function(t){"use strict";var a=Object.prototype,e=a.hasOwnProperty,n="function"==typeof Symbol?Symbol:{},i=n.iterator||"@@iterator",r=n.asyncIterator||"@@asyncIterator",o=n.toStringTag||"@@toStringTag";function s(t,a,e,n){var i=a&&a.prototype instanceof d?a:d,r=Object.create(i.prototype),o=new x(n||[]);return r._invoke=function(t,a,e){var n="suspendedStart";return function(i,r){if("executing"===n)throw new Error("Generator is already running");if("completed"===n){if("throw"===i)throw r;return k()}for(e.method=i,e.arg=r;;){var o=e.delegate;if(o){var s=_(o,e);if(s){if(s===c)continue;return s}}if("next"===e.method)e.sent=e._sent=e.arg;else if("throw"===e.method){if("suspendedStart"===n)throw n="completed",e.arg;e.dispatchException(e.arg)}else"return"===e.method&&e.abrupt("return",e.arg);n="executing";var d=l(t,a,e);if("normal"===d.type){if(n=e.done?"completed":"suspendedYield",d.arg===c)continue;return{value:d.arg,done:e.done}}"throw"===d.type&&(n="completed",e.method="throw",e.arg=d.arg)}}}(t,e,o),r}function l(t,a,e){try{return{type:"normal",arg:t.call(a,e)}}catch(t){return{type:"throw",arg:t}}}t.wrap=s;var c={};function d(){}function u(){}function m(){}var p={};p[i]=function(){return this};var v=Object.getPrototypeOf,f=v&&v(v(C([])));f&&f!==a&&e.call(f,i)&&(p=f);var h=m.prototype=d.prototype=Object.create(p);function b(t){["next","throw","return"].forEach((function(a){t[a]=function(t){return this._invoke(a,t)}}))}function g(t,a){var n;this._invoke=function(i,r){function o(){return new a((function(n,o){!function n(i,r,o,s){var c=l(t[i],t,r);if("throw"!==c.type){var d=c.arg,u=d.value;return u&&"object"==typeof u&&e.call(u,"__await")?a.resolve(u.__await).then((function(t){n("next",t,o,s)}),(function(t){n("throw",t,o,s)})):a.resolve(u).then((function(t){d.value=t,o(d)}),(function(t){return n("throw",t,o,s)}))}s(c.arg)}(i,r,n,o)}))}return n=n?n.then(o,o):o()}}function _(t,a){var e=t.iterator[a.method];if(void 0===e){if(a.delegate=null,"throw"===a.method){if(t.iterator.return&&(a.method="return",a.arg=void 0,_(t,a),"throw"===a.method))return c;a.method="throw",a.arg=new TypeError("The iterator does not provide a 'throw' method")}return c}var n=l(e,t.iterator,a.arg);if("throw"===n.type)return a.method="throw",a.arg=n.arg,a.delegate=null,c;var i=n.arg;return i?i.done?(a[t.resultName]=i.value,a.next=t.nextLoc,"return"!==a.method&&(a.method="next",a.arg=void 0),a.delegate=null,c):i:(a.method="throw",a.arg=new TypeError("iterator result is not an object"),a.delegate=null,c)}function y(t){var a={tryLoc:t[0]};1 in t&&(a.catchLoc=t[1]),2 in t&&(a.finallyLoc=t[2],a.afterLoc=t[3]),this.tryEntries.push(a)}function w(t){var a=t.completion||{};a.type="normal",delete a.arg,t.completion=a}function x(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(y,this),this.reset(!0)}function C(t){if(t){var a=t[i];if(a)return a.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var n=-1,r=function a(){for(;++n<t.length;)if(e.call(t,n))return a.value=t[n],a.done=!1,a;return a.value=void 0,a.done=!0,a};return r.next=r}}return{next:k}}function k(){return{value:void 0,done:!0}}return u.prototype=h.constructor=m,m.constructor=u,m[o]=u.displayName="GeneratorFunction",t.isGeneratorFunction=function(t){var a="function"==typeof t&&t.constructor;return!!a&&(a===u||"GeneratorFunction"===(a.displayName||a.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,o in t||(t[o]="GeneratorFunction")),t.prototype=Object.create(h),t},t.awrap=function(t){return{__await:t}},b(g.prototype),g.prototype[r]=function(){return this},t.AsyncIterator=g,t.async=function(a,e,n,i,r){void 0===r&&(r=Promise);var o=new g(s(a,e,n,i),r);return t.isGeneratorFunction(e)?o:o.next().then((function(t){return t.done?t.value:o.next()}))},b(h),h[o]="Generator",h[i]=function(){return this},h.toString=function(){return"[object Generator]"},t.keys=function(t){var a=[];for(var e in t)a.push(e);return a.reverse(),function e(){for(;a.length;){var n=a.pop();if(n in t)return e.value=n,e.done=!1,e}return e.done=!0,e}},t.values=C,x.prototype={constructor:x,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(w),!t)for(var a in this)"t"===a.charAt(0)&&e.call(this,a)&&!isNaN(+a.slice(1))&&(this[a]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var a=this;function n(e,n){return o.type="throw",o.arg=t,a.next=e,n&&(a.method="next",a.arg=void 0),!!n}for(var i=this.tryEntries.length-1;i>=0;--i){var r=this.tryEntries[i],o=r.completion;if("root"===r.tryLoc)return n("end");if(r.tryLoc<=this.prev){var s=e.call(r,"catchLoc"),l=e.call(r,"finallyLoc");if(s&&l){if(this.prev<r.catchLoc)return n(r.catchLoc,!0);if(this.prev<r.finallyLoc)return n(r.finallyLoc)}else if(s){if(this.prev<r.catchLoc)return n(r.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<r.finallyLoc)return n(r.finallyLoc)}}}},abrupt:function(t,a){for(var n=this.tryEntries.length-1;n>=0;--n){var i=this.tryEntries[n];if(i.tryLoc<=this.prev&&e.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var r=i;break}}r&&("break"===t||"continue"===t)&&r.tryLoc<=a&&a<=r.finallyLoc&&(r=null);var o=r?r.completion:{};return o.type=t,o.arg=a,r?(this.method="next",this.next=r.finallyLoc,c):this.complete(o)},complete:function(t,a){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&a&&(this.next=a),c},finish:function(t){for(var a=this.tryEntries.length-1;a>=0;--a){var e=this.tryEntries[a];if(e.finallyLoc===t)return this.complete(e.completion,e.afterLoc),w(e),c}},catch:function(t){for(var a=this.tryEntries.length-1;a>=0;--a){var e=this.tryEntries[a];if(e.tryLoc===t){var n=e.completion;if("throw"===n.type){var i=n.arg;w(e)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,a,e){return this.delegate={iterator:C(t),resultName:a,nextLoc:e},"next"===this.method&&(this.arg=void 0),c}},t}(t.exports);try{regeneratorRuntime=n}catch(t){Function("r","regeneratorRuntime = r")(n)}},o0o1:function(t,a,e){t.exports=e("ls82")},rYOV:function(t,a,e){"use strict";var n={props:{items:Array},methods:{isArrayRoutes:function(t){return!(void 0===t.child||!Array.isArray(t.child))},checkStatusRoutes:function(t){if(void 0!==t.child&&Array.isArray(t.child)){for(var a=0;a<t.child.length;a++)if(this.route().current(t.child[a].link))return!0;return!1}if(this.isRoute(t.link))return!0}}},i=e("KHd+"),r=Object(i.a)(n,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",t._l(t.items,(function(a){return e("li",{key:a.id,staticClass:"nav-item",class:1==t.checkStatusRoutes(a)?"active":""},[1==t.isArrayRoutes(a)?e("div",[e("a",{staticClass:"nav-link",class:1==t.checkStatusRoutes(a)?"":"collapsed",attrs:{href:"#","data-toggle":"collapse","data-target":"#"+a.title+"Page","aria-expanded":"false","aria-controls":a.title+"Page"}},[e("i",{class:a.icon}),t._v(" "),e("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?e("span",[e("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()]),t._v(" "),1==t.isArrayRoutes(a)?e("div",{staticClass:"collapse",class:1==t.checkStatusRoutes(a)?"show":"",attrs:{id:a.title+"Page","aria-labelledby":"headingPage","data-parent":"#accordionSidebar"}},[e("div",{staticClass:"bg-white py-2 collapse-inner rounded"},t._l(a.child,(function(a,n){return e("inertia-link",{key:n,class:t.isRoute(a.link)?"collapse-item active":"collapse-item",attrs:{href:t.route(a.index)}},[a.badge?e("span",[e("span",{class:!t.isRoute(a.link)&&"font-weight-bold"},[t._v(t._s(a.title))]),t._v(" "),e("span",{staticClass:"float-right"},[e("i",{staticClass:"fas fa-exclamation-circle"})])]):e("span",[t._v(t._s(a.title)+" ")])])})),1)]):t._e()]):e("inertia-link",{staticClass:"nav-link",attrs:{href:t.route(a.index)}},[e("i",{class:a.icon}),t._v(" "),e("span",[t._v(t._s(a.title))]),t._v(" "),a.badge?e("span",{staticClass:"float-right"},[e("i",{staticClass:"fas fa-exclamation-circle"})]):t._e()])],1)})),0)}),[],!1,null,null,null);a.a=r.exports},xpOo:function(t,a,e){"use strict";var n=e("SdS2");e.n(n).a}}]);