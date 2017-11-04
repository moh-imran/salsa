new Vue({
    el:'#setting',
    data: {
        settings : {},
        pagingData:{},
        suggestions: [],
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: '',
        search: ''
    },
    created: function()
    {
        this.loadSettingList();
    },
    watch: {

    },
    methods:
    {
            deleteSetting:function(id)
            {
                this.$http.delete('/admin/setting/' + id).then((response) => {
                    // successfuly done
                    $("#"+id).remove();
                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page;
                    this.loadSettingList('/admin/get-setting?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadSettingList('/admin/get-setting?page=1&search=');
                }else{
                    this.loadSettingList('/admin/get-setting?page='+this.page+'&search=')
                }
            },
            loadSettingList: function(url = false){                
                if(url == false){
                    url = '/admin/get-setting?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                console.log(url);
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                    this.settings = response.body.data;
                    this.search = this.settings[2].value;
                    
                    console.log(this.pagingData);

                }, (response) => {
                    // error occur
                });

            },
            changeStatus: function(status, index){
                this.settings[index]['status'] = status;
                this.$http.get('/admin/change-setting-status/'+this.settings[index]['id']+'/'+status).then((response) => {
                    // successfuly done

                }, (response) => {
                        // error occur
                });

            },
        hidesuggestions: function () {
            setTimeout(function () {
                $('#suggestion-box').hide()
            }, 500);
        },
        selectCommunity: function (event) {
            $('#suggestion-box').show();
            if (event.key == 'Enter') {
                return;
            }
            if (this.search == '') {
                this.suggestions = '';
                return;
            }
            //replace all slashes to **s**;
            search = this.search.split('/').join('**s**');
            this.$http.get('select-community/' + search).then((response) => {
                this.suggestions = response.body;

            }, (response) => {

            });
        },
        selectedVal: function (community_code, community_title) {


            this.suggestions = '';
            this.search = community_title;
            //this.searchCommunityId = community_code;
            //this.loadSchools(0);
        }
    }
});
