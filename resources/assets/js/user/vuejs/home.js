new Vue({
    el: '#login',
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
        this.routToSkolval();
        
        // this.hidesuggestions();
    },
    watch: {

    },
    methods: {
        
        hidesuggestions:function(){
           // alert('done');
            //setTimeout(function(){$('#suggestion-box').hide()}, 500);
            
        },
        selectedVal : function (community_code, community_title) {
            this.suggestions = '';
            $('#suggestion-box').hide();
            this.search = community_title;
            this.searchCommunityId = community_code;
            setTimeout( window.location.href = 'skolval?community='+ this.search+'&singleCommunityFlag='+this.single_community_flag  , 1500 );
            //this.routToSkolval();
            //this.loadSchools(0);
        },
        selectCommunity: function(event){
            
            
            $('#suggestion-box').show();
            if(event.key == 'Enter'){
                return;
            }
            if(this.search == ''){
                this.search = '';
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
                     self.search = response.body.data.community;
                     setTimeout( window.location.href = 'skolval?community='+ self.search+'&singleCommunityFlag='+self.single_community_flag  , 1500 );
                     
               }
                }, (response) => {

                });
            }
        },
        routToSkolval: function(){
            
            
            var url = '/admin/get-comm-setting?search=';
            var self = this;
            this.$http.get(url) .then ((response) => {
                   console.log('com-data', response.body.data[2].value);
                     
                    this.single_community_flag = response.body.data[2].status;
                    if(this.single_community_flag == 1){
                        this.search = response.body.data[2].value;
                    }
                    //self.searchCommunityId = response.body.data[2].key_options;
                    //setTimeout(window.location.href = 'skolval?community='+self.search, 3000);
                }, (response) => {
                    // error occur
            });
        
            
           
//            this.$http.get('go-to-skolval/'+ this.search).then((response) => {               				
//                
//            }, (response) => {
//
//            });
        },
        compareShools: function(){
            
            console.log('flago', this.single_community_flags);
            window.location.href = 'skolval?community='+this.search+'&singleCommunityFlag='+this.single_community_flag;
        }
        

    }
});