new Vue({
    el:'#client',
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
        deleteCustomer:function(id)        
        {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this line item!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF5350",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        $.ajax({
                            method: "DELETE",
                            "_token": $('#token').val(),
                            url  : '/admin/client/' + id, // the url where we want to POST
                        }).done(function(data) {
                            window.location.href = window.location.pathname + window.location.search + window.location.hash;
//                        swal({
//                                title: "Deleted!",
//                                text: "Your record has been deleted.",
//                                confirmButtonColor: "#66BB6A",
//                                type: "success"
//                            },
//                            function()
//                            {
//                                $("#"+id).remove();
//                                //$(obj).closest('tr').addClass('animated flipOutX').submit(obj);
//                                //$(document).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
//                                //    $(obj).closest('tr').remove();
//                                //});
//                                //$(obj).closest('form').submit();
//                            });
                        //});

                      });
                    }
                    else {
//                        swal({
//                            title: "Cancelled",
//                            text: "Your record is safe :)",
//                            confirmButtonColor: "#2196F3",
//                            type: "error"
//                        });
                    }
                });
               
                //window.location.reload('');
                
        },
        reset_search: function(){
            this.search = '';
        },
        goto: function(){
            if(this.page > this.pagingData.last_page){
                this.page = this.pagingData.last_page;
                console.log(this.page);
                this.loadClientList('/admin/get-client?page='+this.page+'&search=')
            }else if(this.page < 1){
                this.loadClientList('/admin/get-client?page=1&search=');
            }else{
                this.loadClientList('/admin/get-client?page='+this.page+'&search=')
            }
        },
        loadClientList: function(url = false){
            if(url == false){
                url = '/admin/get-client?search=';
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
