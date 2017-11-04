new Vue({
    el:'#communitySalsaValue',
    data: {
        communitySalsaValues : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadCommunitySalsaValueList();
    },
    watch: {

    },
    methods:
        {
            deleteCommunitySalsaValueData:function(id)
            {
                this.$http.delete('/admin/community-salsa-value/' + id).then((response) => {
                    // successfuly done

                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page
                    this.loadCommunitySalsaValueList('/admin/get-community-salsa-value?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadCommunitySalsaValueList('/admin/get-community-salsa-value?page=1&search=');
                }else{
                    this.loadCommunitySalsaValueList('/admin/get-community-salsa-value?page='+this.page+'&search=')
                }
            },
            
            loadCommunitySalsaValueList: function(url = false){
                if(url == false){
                    url = '/admin/get-community-salsa-value?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.communitySalsaValues = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
