!function(t){function a(n){if(e[n])return e[n].exports;var i=e[n]={i:n,l:!1,exports:{}};return t[n].call(i.exports,i,i.exports,a),i.l=!0,i.exports}var e={};return a.m=t,a.c=e,a.i=function(t){return t},a.d=function(t,a,e){Object.defineProperty(t,a,{configurable:!1,enumerable:!0,get:e})},a.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return a.d(e,"a",e),e},a.o=function(t,a){return Object.prototype.hasOwnProperty.call(t,a)},a.p="",a(a.s=0)}([function(t,a){new Vue({el:"#nationalResultData",data:{nationalResultData:{},pagingData:{},pagingUrl:"",search:"",orderBy:"",page:""},created:function(){this.loadNationalResultDataList()},watch:{},methods:{deleteNationalResultData:function(t){this.$http["delete"]("/admin/national-result-data/"+t).then(function(t){},function(t){})},"goto":function(){this.page>this.pagingData.last_page?(this.page=this.pagingData.last_page,this.loadNationalResultDataList("/admin/get-national-result-data?page="+this.page+"&search=")):this.page<1?this.loadNationalResultDataList("/admin/get-national-result-data?page=1&search="):this.loadNationalResultDataList("/admin/get-national-result-data?page="+this.page+"&search=")},loadNationalResultDataList:function(t){var a=this;void 0===t&&(t=!1),0==t&&(t="/admin/get-national-result-data?search="),""!=this.search&&(t=t+""+this.search),""!=this.orderBy&&(t=t+"&orderBy="+this.orderBy),this.$http.get(t).then(function(t){a.pagingData=t.body,a.nationalResultData=t.body.data},function(t){})}}})}]);