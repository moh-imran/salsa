new Vue({
    el:'#nationalResultData',
    data: {
        nationalResultData : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadNationalResultDataList();
    },
    watch: {

    },
    methods:
        {
            deleteNationalResultData:function(id)
            {
                this.$http.delete('/admin/national-result-data/' + id).then((response) => {
                    // successfuly done

                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page
                    this.loadNationalResultDataList('/admin/get-national-result-data?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadNationalResultDataList('/admin/get-national-result-data?page=1&search=');
                }else{
                    this.loadNationalResultDataList('/admin/get-national-result-data?page='+this.page+'&search=')
                }
            },
            
            loadNationalResultDataList: function(url = false){
                if(url == false){
                    url = '/admin/get-national-result-data?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.nationalResultData = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
