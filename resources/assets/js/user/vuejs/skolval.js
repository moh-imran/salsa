new Vue({
    el: '#skolval',
    data: {
        suggestions : [],
        search: '',
        searchCommunityId: '',
        schoolWarningThreshold: '',
        single_community_flag:'',
        slider_schools: {},
        lastSchool : {},
        topSchool : {}
    },
    created: function () {

        /// function being called on page load
        //this.loadCurrentLocation();
        this.locationSetByUser();
        // this.hidesuggestions();
    },
    watch: {

    },
    methods: {
        loadSchools: function(clrId){
            if(clrId){
                this.searchCommunityId = '';
            }
            this.suggestions = '';
            $('#suggestion-box').hide();
            //replace all slashes to **s**;
            search = this.search.split('/').join('**s**');
            this.$http.get('get-community-schools/'+encodeURI(search)+'/'+this.searchCommunityId).then((response) => {
                this.slider_schools = '';
                this.lastSchool= '';
                this.topSchool= '';
                if(response.body.data != ''){
                    this.slider_schools = response.body.data.all_school_of_community;
                    this.lastSchool = response.body.data.all_school_of_community[0];
                    index_last_school = response.body.data.all_school_of_community.length - 1;
                    this.topSchool = response.body.data.all_school_of_community[index_last_school];
                    this.schoolWarningThreshold = response.body.data.schoolWarningThreshold;
                                     
                }
            }, (response) => {

            });
        },
        hidesuggestions:function(){
            setTimeout(function(){$('#suggestion-box').hide()}, 500);
        },
        selectedVal : function (community_code, community_title) {
            this.suggestions = '';
            $('#suggestion-box').hide();
            this.search = community_title;
            this.searchCommunityId = community_code;
            this.loadSchools(0);
        },
        selectCommunity: function(event){
            $('#suggestion-box').show();
            if(event.key == 'Enter'){
                return;
            }
            if(this.search == ''){
                this.suggestions = '';
                $('#suggestion-box').hide();
                return;
            }
            this.$http.get('select-community/'+this.search).then((response) => {
                this.suggestions = response.body;
                $('#suggestion-box').show();

        }, (response) => {

            });
        },
        loadCurrentLocation: function () {            
            setTimeout( this.suggestions = ''  , 1000 );
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
            else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            var self = this;
            function showPosition(position) {
                /*------------------show location------------------------*/
                lat = position.coords.latitude;
                lng = position.coords.longitude;
                self.$http.get('current-location-community/'+lat+'/'+lng).then((response) => {
                    if(response.body.data != ''){
                    self.slider_schools = response.body.data.all_school_of_community;
                    self.lastSchool = response.body.data.all_school_of_community[0];
                    index_last_school = response.body.data.all_school_of_community.length - 1;
                    self.topSchool = response.body.data.all_school_of_community[index_last_school];
                    self.search = response.body.data.community;
                    self.schoolWarningThreshold = response.body.data.schoolWarningThreshold;
                }
                }, (response) => {

                });
            }
        },
        locationSetByUser: function(){
            function getParameterByName(name) {
                var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
                return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
            }
             this.search = getParameterByName('community');
             this.single_community_flag = getParameterByName('singleCommunityFlag');
             
             this.loadSchools(this.search);
        }

    }
});