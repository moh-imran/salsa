new Vue({
    el:'#schoolSalsaValue',
    data: {
        schoolSalsaValues : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadSchoolSalsaValueList();
    },
    watch: {

    },
    methods:
        {
            deleteSchoolSalsaValue:function(id)
            {
                this.$http.delete('/admin/school-salsa-value/' + id).then((response) => {
                    // successfuly done

                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page
                    this.loadSchoolSalsaValueList('/admin/get-school-salsa-value?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadSchoolSalsaValueList('/admin/get-school-salsa-value?page=1&search=');
                }else{
                    this.loadSchoolSalsaValueList('/admin/get-school-salsa-value?page='+this.page+'&search=')
                }
            },
            
            loadSchoolSalsaValueList: function(url = false){
                if(url == false){
                    url = '/admin/get-school-salsa-value?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.schoolSalsaValues = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
