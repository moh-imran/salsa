!function(a){function t(n){if(e[n])return e[n].exports;var i=e[n]={i:n,l:!1,exports:{}};return a[n].call(i.exports,i,i.exports,t),i.l=!0,i.exports}var e={};return t.m=a,t.c=e,t.i=function(a){return a},t.d=function(a,t,e){Object.defineProperty(a,t,{configurable:!1,enumerable:!0,get:e})},t.n=function(a){var e=a&&a.__esModule?function(){return a["default"]}:function(){return a};return t.d(e,"a",e),e},t.o=function(a,t){return Object.prototype.hasOwnProperty.call(a,t)},t.p="",t(t.s=0)}([function(a,t){new Vue({el:"#communitySalsaValue",data:{communitySalsaValues:{},pagingData:{},pagingUrl:"",search:"",orderBy:"",page:""},created:function(){this.loadCommunitySalsaValueList()},watch:{},methods:{deleteCommunitySalsaValueData:function(a){this.$http["delete"]("/admin/community-salsa-value/"+a).then(function(a){},function(a){})},"goto":function(){this.page>this.pagingData.last_page?(this.page=this.pagingData.last_page,this.loadCommunitySalsaValueList("/admin/get-community-salsa-value?page="+this.page+"&search=")):this.page<1?this.loadCommunitySalsaValueList("/admin/get-community-salsa-value?page=1&search="):this.loadCommunitySalsaValueList("/admin/get-community-salsa-value?page="+this.page+"&search=")},loadCommunitySalsaValueList:function(a){var t=this;void 0===a&&(a=!1),0==a&&(a="/admin/get-community-salsa-value?search="),""!=this.search&&(a=a+""+this.search),""!=this.orderBy&&(a=a+"&orderBy="+this.orderBy),this.$http.get(a).then(function(a){t.pagingData=a.body,t.communitySalsaValues=a.body.data},function(a){})}}})}]);