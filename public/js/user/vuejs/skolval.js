!function(o){function t(s){if(n[s])return n[s].exports;var e=n[s]={i:s,l:!1,exports:{}};return o[s].call(e.exports,e,e.exports,t),e.l=!0,e.exports}var n={};return t.m=o,t.c=n,t.i=function(o){return o},t.d=function(o,t,n){Object.defineProperty(o,t,{configurable:!1,enumerable:!0,get:n})},t.n=function(o){var n=o&&o.__esModule?function(){return o["default"]}:function(){return o};return t.d(n,"a",n),n},t.o=function(o,t){return Object.prototype.hasOwnProperty.call(o,t)},t.p="",t(t.s=0)}([function(o,t){new Vue({el:"#skolval",data:{suggestions:[],search:"",searchCommunityId:"",schoolWarningThreshold:"",single_community_flag:"",slider_schools:{},lastSchool:{},topSchool:{}},created:function(){this.locationSetByUser()},watch:{},methods:{loadSchools:function(o){var t=this;o&&(this.searchCommunityId=""),this.suggestions="",$("#suggestion-box").hide(),search=this.search.split("/").join("**s**"),this.$http.get("get-community-schools/"+encodeURI(search)+"/"+this.searchCommunityId).then(function(o){t.slider_schools="",t.lastSchool="",t.topSchool="",""!=o.body.data&&(t.slider_schools=o.body.data.all_school_of_community,t.lastSchool=o.body.data.all_school_of_community[0],index_last_school=o.body.data.all_school_of_community.length-1,t.topSchool=o.body.data.all_school_of_community[index_last_school],t.schoolWarningThreshold=o.body.data.schoolWarningThreshold)},function(o){})},hidesuggestions:function(){setTimeout(function(){$("#suggestion-box").hide()},500)},selectedVal:function(o,t){this.suggestions="",$("#suggestion-box").hide(),this.search=t,this.searchCommunityId=o,this.loadSchools(0)},selectCommunity:function(o){var t=this;if($("#suggestion-box").show(),"Enter"!=o.key)return""==this.search?(this.suggestions="",void $("#suggestion-box").hide()):void this.$http.get("select-community/"+this.search).then(function(o){t.suggestions=o.body,$("#suggestion-box").show()},function(o){})},loadCurrentLocation:function(){function o(o){lat=o.coords.latitude,lng=o.coords.longitude,t.$http.get("current-location-community/"+lat+"/"+lng).then(function(o){""!=o.body.data&&(t.slider_schools=o.body.data.all_school_of_community,t.lastSchool=o.body.data.all_school_of_community[0],index_last_school=o.body.data.all_school_of_community.length-1,t.topSchool=o.body.data.all_school_of_community[index_last_school],t.search=o.body.data.community,t.schoolWarningThreshold=o.body.data.schoolWarningThreshold)},function(o){})}setTimeout(this.suggestions="",1e3),navigator.geolocation?navigator.geolocation.getCurrentPosition(o):x.innerHTML="Geolocation is not supported by this browser.";var t=this},locationSetByUser:function(){function o(o){var t=RegExp("[?&]"+o+"=([^&]*)").exec(window.location.search);return t&&decodeURIComponent(t[1].replace(/\+/g," "))}this.search=o("community"),this.single_community_flag=o("singleCommunityFlag"),this.loadSchools(this.search)}}})}]);