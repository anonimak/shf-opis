(window.webpackJsonp=window.webpackJsonp||[]).push([[38],{"7qKR":function(t,s,e){var a=e("rVsO");"string"==typeof a&&(a=[[t.i,a,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(a,n);a.locals&&(t.exports=a.locals)},Dt6l:function(t,s,e){"use strict";function a(t,s){return function(t){if(Array.isArray(t))return t}(t)||function(t,s){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var e=[],a=!0,n=!1,i=void 0;try{for(var o,r=t[Symbol.iterator]();!(a=(o=r.next()).done)&&(e.push(o.value),!s||e.length!==s);a=!0);}catch(t){n=!0,i=t}finally{try{a||null==r.return||r.return()}finally{if(n)throw i}}return e}(t,s)||function(t,s){if(!t)return;if("string"==typeof t)return n(t,s);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return n(t,s)}(t,s)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(t,s){(null==s||s>t.length)&&(s=t.length);for(var e=0,a=new Array(s);e<s;e++)a[e]=t[e];return a}var i={mounted:function(){for(var t=0,s=Object.entries(this.pageFlashes);t<s.length;t++){var e=a(s[t],2),n=e[0],i=e[1];i&&("success"==n&&this.$emit("onSuccess",!0),this.dismissCountDown=3,this.variant=n,this.msg=i,this.pageFlashes[index]=null)}},watch:{pageFlashes:{handler:function(t){var s=this;_.each(t,(function(t,e){t&&("success"==e&&s.$emit("onSuccess",!0),s.dismissCountDown=3,s.variant=e,s.msg=t,s.pageFlashes[e]=null)}))},deep:!0}},data:function(){return{variant:null,dismissCountDown:null,msg:""}}},o=e("KHd+"),r=Object(o.a)(i,(function(){var t=this,s=t.$createElement;return(t._self._c||s)("b-alert",{staticClass:"position-fixed fixed-top m-0 rounded-0",staticStyle:{"z-index":"2000"},attrs:{dismissible:"",fade:"",variant:t.variant},model:{value:t.dismissCountDown,callback:function(s){t.dismissCountDown=s},expression:"dismissCountDown"}},[t._v("\n  "+t._s(t.msg)+"\n")])}),[],!1,null,null,null);s.a=r.exports},"KHd+":function(t,s,e){"use strict";function a(t,s,e,a,n,i,o,r){var c,l="function"==typeof t?t.options:t;if(s&&(l.render=s,l.staticRenderFns=e,l._compiled=!0),a&&(l.functional=!0),i&&(l._scopeId="data-v-"+i),o?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},l._ssrRegister=c):n&&(c=r?function(){n.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:n),c)if(l.functional){l._injectStyles=c;var d=l.render;l.render=function(t,s){return c.call(s),d(t,s)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,c):[c]}return{exports:t,options:l}}e.d(s,"a",(function(){return a}))},gHwz:function(t,s,e){"use strict";e.r(s);var a=e("nkZ0"),n=e("Dt6l"),i={components:{Layout:a.a,FlashMsg:n.a},props:["dataMemo"]},o=e("KHd+"),r=Object(o.a)(i,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("Layout",[e("flash-msg"),t._v(" "),e("div",{staticClass:"card o-hidden border-0 shadow-lg"},[e("div",{staticClass:"card-body p-0"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[e("div",{staticClass:"p-5"},[e("div",[t.dataMemo?e("div",{staticClass:"col"},[e("h3",{staticClass:"text-primary mb-4 text-center"},[e("strong",[t._v("Memo Payment Verified ")]),t._v(" "),e("i",{staticClass:"fa fa-check"})]),t._v(" "),e("hr"),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[t._v("Title Memo")]),t._v(" "),e("div",{staticClass:"col"},[t._v(": "+t._s(t.dataMemo.title))])]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[t._v("Document No")]),t._v(" "),e("div",{staticClass:"col"},[t._v(": "+t._s(t.dataMemo.doc_no))])]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col"},[t._v("Status")]),t._v(" "),e("div",{staticClass:"col"},[t._v("\n                    :\n                    "),"submit"==t.dataMemo.status_payment?e("span",{staticClass:"badge badge-info"},[t._v("On process approving")]):t._e(),t._v(" "),"approve"==t.dataMemo.status_payment?e("span",{staticClass:"badge badge-success"},[t._v("Memo Approved")]):t._e(),t._v(" "),"reject"==t.dataMemo.status_payment?e("span",{staticClass:"badge badge-danger"},[t._v("Memo Rejected")]):t._e(),t._v(" "),"revisi"==t.dataMemo.status_payment?e("span",{staticClass:"badge badge-secondary"},[t._v("Memo Revised")]):t._e()])])]):e("div",{staticClass:"col"},[e("h2",{staticClass:"text-gray"},[e("strong",[t._v("Memo does not exist")]),t._v(" "),e("i",{staticClass:"fa fa-times"})])])])])])])])])],1)}),[],!1,null,null,null);s.default=r.exports},nkZ0:function(t,s,e){"use strict";var a={components:{},methods:{handleLogout:function(){alert("Ini Sudah Logout")}}},n=(e("tl26"),e("KHd+")),i=Object(n.a)(a,(function(){var t=this.$createElement,s=this._self._c||t;return s("main",{staticClass:"container-fluid vh-100 bg-main"},[s("div",{staticClass:"row justify-content-center align-items-center h-100"},[s("div",{staticClass:"col-xl-4 col-lg-4 col-md-9"},[this._t("default")],2)])])}),[],!1,null,"f526b1fa",null);s.a=i.exports},rVsO:function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,".bg-main[data-v-f526b1fa]{background-image:linear-gradient(180deg,#009688 10%,#055048);background-size:cover;height:100%}.bg-login-image[data-v-f526b1fa]{background:url(/img/svg/login.svg);width:25px;height:25px;background-position-x:0;background-position-y:0;background-size:4rem;background-position:50%;background-size:cover}",""])},tl26:function(t,s,e){"use strict";var a=e("7qKR");e.n(a).a}}]);