new Vue({
    el:'#school',
    data: {
        schools : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadSchoolList();
    },
    watch: {

    },
    methods:
    {
            deleteSchool:function(id)
            {
                this.$http.delete('/admin/school/' + id).then((response) => {
                    // successfuly done
                    $("#"+id).remove();
                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page;
                    this.loadSchoolList('/admin/get-school?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadSchoolList('/admin/get-school?page=1&search=');
                }else{
                    this.loadSchoolList('/admin/get-school?page='+this.page+'&search=')
                }
            },
            loadSchoolList: function(url = false){
                if(url == false){
                    url = '/admin/get-school?search=';
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
                    this.schools = response.body.data;
                    console.log(this.pagingData);

                }, (response) => {
                    // error occur
                });

            },
            changeStatus: function(status, index){
                this.schools[index]['status'] = status;
                this.$http.get('/admin/change-school-status/'+this.schools[index]['id']+'/'+status).then((response) => {
                    // successfuly done

                }, (response) => {
                        // error occur
                });

            }

    }
});
