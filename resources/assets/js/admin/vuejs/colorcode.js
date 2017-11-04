Vue.config.warnExpressionErrors = false;
Vue.config.debug = false;

var vm = new Vue({
    el:'#colorcode',
    data: function() {
        return {
            colorcodes: {},
            pagingData: {},
            pagingUrl: '',
            search: '',
            orderBy: '',
            page: '',
            previous_label: '1',
            editdata: {status : '', is_free : '', much_higher_when_greater_than: '', above_when_greater_than: '',
                is_reverse: '', below_when_less_than: '', much_below_when_less_than: '', key: '',
                label: '', id: '', index: ''}
        }
    },
    created: function() {
        this.loadColorcodesList();
    },
    watch: {

    },
    methods:{
        editColorcode: function(id, index){
            this.editdata.id = this.colorcodes[index].id;
            this.editdata.index = index;
            this.editdata.status = this.colorcodes[index].status;
            this.editdata.is_free = this.colorcodes[index].is_free;
            this.editdata.is_reverse = this.colorcodes[index].is_reverse;
            this.editdata.much_higher_when_greater_than = this.colorcodes[index].much_higher_when_greater_than;
            this.editdata.above_when_greater_than = this.colorcodes[index].above_when_greater_than;
            //this.editdata.average_when_greater_than = this.colorcodes[index].average_when_greater_than;
            this.editdata.below_when_less_than = this.colorcodes[index].below_when_less_than;
            this.editdata.much_below_when_less_than = this.colorcodes[index].much_below_when_less_than;
            this.editdata.key = this.colorcodes[index].key;
            this.editdata.label = this.colorcodes[index].label;
            $('#modal_edit').modal('show');
        },
        updateColorcode: function(){
            this.$http.post('/admin/edit-colorcode/'+this.editdata.id, this.editdata).then((response) => {

                this.colorcodes[this.editdata.index].much_below_when_less_than = this.editdata.much_below_when_less_than;
                this.colorcodes[this.editdata.index].below_when_less_than = this.editdata.below_when_less_than;
                //this.colorcodes[this.editdata.index].average_when_greater_than = this.editdata.average_when_greater_than;
                this.colorcodes[this.editdata.index].above_when_greater_than = this.editdata.above_when_greater_than;
                this.colorcodes[this.editdata.index].much_higher_when_greater_than = this.editdata.much_higher_when_greater_than;
                this.colorcodes[this.editdata.index].is_free = this.editdata.is_free;
                this.colorcodes[this.editdata.index].is_reverse = this.editdata.is_reverse;
                this.colorcodes[this.editdata.index].status = this.editdata.status;
                $('#modal_edit').modal('hide');

            }, (response) => {
                // error occur
            });
        },
        deleteColorcode:function(id) {
            this.$http.delete('/admin/colorcodes/' + id).then((response) => {
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
                this.loadColorcodesList('/admin/get-colorcode?page='+this.page+'&search=')
            }else if(this.page < 1){
                this.loadColorcodesList('/admin/get-colorcode?page=1&search=');
            }else{
                this.loadColorcodesList('/admin/get-colorcode?page='+this.page+'&search=')
            }
        },
        loadColorcodesList: function(url = false){

            if(url == false){
                url = '/admin/get-colorcode?search=';
            }
            if(this.search != ''){
                url = url+''+this.search;
            }
            if(this.orderBy != ''){
                url = url+'&orderBy='+this.orderBy;
            }
            this.$http.get(url) .then ((response) => {
                this.pagingData = response.body;
            this.colorcodes = response.body.data;
            //console.log(this.pagingData);

        }, (response) => {
                // error occur
            });

        },
        changeStatus: function(status, index){
            this.colorcodes[index]['status'] = status;
            this.$http.get('/admin/change-colorcode-status/'+this.colorcodes[index]['id']+'/'+status).then((response) => {
                // successfuly done

            }, (response) => {
                // error occur
            });
        },
        changeReverse: function(is_reverse, index){
            this.colorcodes[index]['is_reverse'] = is_reverse;
            this.$http.get('/admin/change-colorcode-reverse/'+this.colorcodes[index]['id']+'/'+status).then((response) => {
                // successfuly done

            }, (response) => {
                // error occur
            });

        }

    }
});