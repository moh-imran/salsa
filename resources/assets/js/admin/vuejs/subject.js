new Vue({
    el:'#subject',
    data: {
        subjects : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function() {
        this.loadSubjectList();
    },
    watch: {

    },
    methods:{
        deleteCommunity:function(id)
        {
            this.$http.delete('/admin/subject/' + id).then((response) => {
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
                this.loadSubjectList('/admin/get-subject?page='+this.page+'&search=')
            }else if(this.page < 1){
                this.loadSubjectList('/admin/get-subject?page=1&search=');
            }else{
                this.loadSubjectList('/admin/get-subject?page='+this.page+'&search=')
            }
        },
        loadSubjectList: function(url = false){
            if(url == false){
                url = '/admin/get-subject?search=';
            }
            if(this.search != ''){
                url = url+''+this.search;
            }
            if(this.orderBy != ''){
                url = url+'&orderBy='+this.orderBy;
            }
            this.$http.get(url) .then ((response) => {
                this.pagingData = response.body;
                this.subjects = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                // error occur
            });

        }

    }
});
