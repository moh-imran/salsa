new Vue({
    el:'#community',
    data: {
        communities : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function() {
        this.loadCommunityList();
    },
    watch: {

    },
    methods:{
        deleteCommunity:function(id)
        {
            this.$http.delete('/admin/community/' + id).then((response) => {
                // successfuly done
                $("#"+id).remove();
            }, (response) => {
                // error occur
            });
        },
        goto: function(){
            if(this.page > this.pagingData.last_page){
                this.page = this.pagingData.last_page;
                this.loadCommunityList('/admin/get-community?page='+this.page+'&search=')
            }else if(this.page < 1){
                this.loadCommunityList('/admin/get-community?page=1&search=');
            }else{
                this.loadCommunityList('/admin/get-community?page='+this.page+'&search=')
            }
        },
        loadCommunityList: function(url = false){
            if(url == false){
                url = '/admin/get-community?search=';
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
                this.communities = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                // error occur
            });

        }

    }
});
