!function(a){function t(o){if(e[o])return e[o].exports;var s=e[o]={i:o,l:!1,exports:{}};return a[o].call(s.exports,s,s.exports,t),s.l=!0,s.exports}var e={};return t.m=a,t.c=e,t.i=function(a){return a},t.d=function(a,t,e){Object.defineProperty(a,t,{configurable:!1,enumerable:!0,get:e})},t.n=function(a){var e=a&&a.__esModule?function(){return a["default"]}:function(){return a};return t.d(e,"a",e),e},t.o=function(a,t){return Object.prototype.hasOwnProperty.call(a,t)},t.p="",t(t.s=0)}([function(a,t){new Vue({el:"#schoolSalsaValue",data:{schoolSalsaValues:{},pagingData:{},pagingUrl:"",search:"",orderBy:"",page:""},created:function(){this.loadSchoolSalsaValueList()},watch:{},methods:{deleteSchoolSalsaValue:function(a){this.$http["delete"]("/admin/school-salsa-value/"+a).then(function(a){},function(a){})},"goto":function(){this.page>this.pagingData.last_page?(this.page=this.pagingData.last_page,this.loadSchoolSalsaValueList("/admin/get-school-salsa-value?page="+this.page+"&search=")):this.page<1?this.loadSchoolSalsaValueList("/admin/get-school-salsa-value?page=1&search="):this.loadSchoolSalsaValueList("/admin/get-school-salsa-value?page="+this.page+"&search=")},loadSchoolSalsaValueList:function(a){var t=this;void 0===a&&(a=!1),0==a&&(a="/admin/get-school-salsa-value?search="),""!=this.search&&(a=a+""+this.search),""!=this.orderBy&&(a=a+"&orderBy="+this.orderBy),this.$http.get(a).then(function(a){t.pagingData=a.body,t.schoolSalsaValues=a.body.data},function(a){})}}})}]);