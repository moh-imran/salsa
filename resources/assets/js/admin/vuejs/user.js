new Vue({
    el:'#user',
    data : {
        processLine: false,
        seconds : 5,
        time : '',
        admins : [],
        items : [
            { message: 'Foo' },
            { message: 'Bar' },
            { message: 'Bar1' },
            { message: 'Bar2' },
            { message: 'Bar3' },
            { message: 'Bar4' }
        ],
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function() {
        this.loadAdminList();
    },
    methods:
        {
            timer: function (item, index) {
                this.admins[index].processLine = 1;
                var self = this;
                this.admins[index].time = window.setInterval(function(){
                    self.admins[index].seconds--;
                    if(self.admins[index].seconds == 0){
                        clearInterval(self.admins[index].time);
                        self.deleteUser(item, index);
                    }
                }, 1000);

            },
            clearTimer : function (index) {
                clearInterval(this.admins[index].time);
                this.admins[index].processLine = 0;
                this.admins[index].seconds = 5;
            },
            deleteUser:function(id, index)
            {
                this.$http.delete('/admin/user/' + id).then((response) => {
                    this.admins.splice(index, 1);
                }, (response) => {
                // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page;
                    console.log(this.page);
                    this.loadAdminList('/admin/get-admin?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadAdminList('/admin/get-admin?page=1&search=');
                }else{
                    this.loadAdminList('/admin/get-admin?page='+this.page+'&search=')
                }
            },
            loadAdminList: function(url = false){
                if(url == false){
                    url = '/admin/get-admin?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.admins = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
