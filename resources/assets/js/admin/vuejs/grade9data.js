new Vue({
    el:'#grade9data',
    data: {
        grade9data : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadGrade9dataList();
    },
    watch: {

    },
    methods:
        {
            deletegrade9data:function(id)
            {
                this.$http.delete('/admin/grade9data/' + id).then((response) => {
                    // successfuly done
                    $("#"+id).remove();
                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page
                    this.loadGrade9dataList('/admin/get-grade9data?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadGrade9dataList('/admin/get-grade9data?page=1&search=');
                }else{
                    this.loadGrade9dataList('/admin/get-grade9data?page='+this.page+'&search=')
                }
            },
            loadGrade9dataList: function(url = false){
                if(url == false){
                    url = '/admin/get-grade9data?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.grade9data = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
