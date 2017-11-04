new Vue({
    el:'#qualifyUpperSecData',
    data: {
        qualifyUpperSecData : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadQualifyUpperSecDataList();
    },
    watch: {

    },
    methods:
        {
            deleteQualifyUpperSecData:function(id)
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
                    this.loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page=1&search=');
                }else{
                    this.loadQualifyUpperSecDataList('/admin/get-qualify-upper-sec-data?page='+this.page+'&search=')
                }
            },
            
            loadQualifyUpperSecDataList: function(url = false){
                if(url == false){
                    url = '/admin/get-qualify-upper-sec-data?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.qualifyUpperSecData = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
