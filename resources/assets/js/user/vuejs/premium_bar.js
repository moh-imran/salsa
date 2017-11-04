new Vue({
    el: '#skolval',
    data: {
        suggestions : [],
        search: '',
        searchCommunityId: '',
        schoolWarningThreshold: '',
        slider_schools: {},
        lastSchool : {},
        topSchool : {}
    },
    created: function () {

        /// function being called on page load
        //this.loadCurrentLocation();
        this.loadSchools();
        // this.hidesuggestions();
    },
    watch: {

    },
    methods: {
        loadSchools: function(){
            self = this;
            setTimeout(function(){
            self.$http.get('get-premium-bar-schools').then((response) => {                
                self.slider_schools = '';
                self.lastSchool= '';
                self.topSchool= '';
                if(response.body.data != ''){
					
                    self.slider_schools = response.body.data.all_school_of_community;
                    self.lastSchool = response.body.data.all_school_of_community[0];
                    index_last_school = response.body.data.all_school_of_community.length - 1;
                    self.topSchool = response.body.data.all_school_of_community[index_last_school];
                                     
                }
            }, (response) => {

            })},  1500 );
        }
   
    }
});