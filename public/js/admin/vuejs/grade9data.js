!function(a){function t(r){if(e[r])return e[r].exports;var n=e[r]={i:r,l:!1,exports:{}};return a[r].call(n.exports,n,n.exports,t),n.l=!0,n.exports}var e={};return t.m=a,t.c=e,t.i=function(a){return a},t.d=function(a,t,e){Object.defineProperty(a,t,{configurable:!1,enumerable:!0,get:e})},t.n=function(a){var e=a&&a.__esModule?function(){return a["default"]}:function(){return a};return t.d(e,"a",e),e},t.o=function(a,t){return Object.prototype.hasOwnProperty.call(a,t)},t.p="",t(t.s=0)}([function(a,t){new Vue({el:"#grade9data",data:{grade9data:{},pagingData:{},pagingUrl:"",search:"",orderBy:"",page:""},created:function(){this.loadGrade9dataList()},watch:{},methods:{deletegrade9data:function(a){this.$http["delete"]("/admin/grade9data/"+a).then(function(t){$("#"+a).remove()},function(a){})},"goto":function(){this.page>this.pagingData.last_page?(this.page=this.pagingData.last_page,this.loadGrade9dataList("/admin/get-grade9data?page="+this.page+"&search=")):this.page<1?this.loadGrade9dataList("/admin/get-grade9data?page=1&search="):this.loadGrade9dataList("/admin/get-grade9data?page="+this.page+"&search=")},loadGrade9dataList:function(a){var t=this;void 0===a&&(a=!1),0==a&&(a="/admin/get-grade9data?search="),""!=this.search&&(a=a+""+this.search),""!=this.orderBy&&(a=a+"&orderBy="+this.orderBy),this.$http.get(a).then(function(a){t.pagingData=a.body,t.grade9data=a.body.data},function(a){})}}})}]);