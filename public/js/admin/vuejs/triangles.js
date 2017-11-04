Vue.config.warnExpressionErrors = false;
Vue.config.debug = false;

var vm = new Vue({
    el:'#triangles',
    data: function() {
        return {
            triangles: {},
            pagingData: {},
            pagingUrl: '',
            search: '',
            orderBy: '',
            page: ''
        }
    },
    created: function() {
        this.loadTrianglesList();
    },
    watch: {

    },
    methods:{
        deleteTriangles:function(id)
        {
            this.$http.delete('/admin/triangles/' + id).then((response) => {
                // successfuly done
                $("#"+id).remove();
            }, (response) => {
                // error occur
            });
        },
        goto: function(){
            if(this.page > this.pagingData.last_page){
                this.page = this.pagingData.last_page;
                //console.log(this.page);
                this.loadTrianglesList('/admin/get-triangles?page='+this.page)
            }else if(this.page < 1){
                this.loadTrianglesList('/admin/get-triangles?page=1');
            }else{
                this.loadTrianglesList('/admin/get-triangles?page='+this.page)
            }
        },
        loadTrianglesList: function(url = false){

            if(url == false){
                url = '/admin/get-triangles?search=';
            }
            if(this.search != ''){
                url = url+''+this.search;
            }
            if(this.orderBy != ''){
                url = url+'&orderBy='+this.orderBy;
            }
            this.$http.get(url) .then ((response) => {
                this.pagingData = response.body;
                this.triangles = response.body.data;
                //console.log(this.pagingData);

            }, (response) => {
                // error occur
            });

        },
        changeStatus: function(status, index){
            this.schools[index]['status'] = status;
            this.$http.get('/admin/change-triangle-status/'+this.schools[index]['id']+'/'+status).then((response) => {
                // successfuly done

            }, (response) => {
                // error occur
            });

        }

    }
});