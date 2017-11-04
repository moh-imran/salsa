new Vue({
    el:'#children_info',
    data: {
        clients : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function() {
        this.loadClientList();
    },
    watch: {

    },
    methods:{
        deleteClient:function(id)
        {
            this.$http.delete('/admin/client/' + id).then((response) => {
                // successfuly done
                $("#"+id).remove();
            }, (response) => {
                // error occur
            });
        },
        goto: function(){
            if(this.page > this.pagingData.last_page){
                this.page = this.pagingData.last_page;
                console.log(this.page);
                this.loadClientList('/admin/get-children?page='+this.page+'&search=')
            }else if(this.page < 1){
                this.loadClientList('/admin/get-children?page=1&search=');
            }else{
                this.loadClientList('/admin/get-children?page='+this.page+'&search=')
            }
        },
        loadClientList: function(url = false){
            if(url == false){
                url = '/admin/get-children?search=';
            }
            if(this.search != ''){
                url = url+''+this.search;
            }
            if(this.orderBy != ''){
                url = url+'&orderBy='+this.orderBy;
            }
            this.$http.get(url) .then ((response) => {
                this.pagingData = response.body;
                this.clients = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                // error occur
            });

        }

    }
});
