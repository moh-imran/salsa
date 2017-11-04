
new Vue({
    el: '#customer_edit',
    data: {
        clients: {},
        selected: 'Select',
        children: [],
        errors: [],
        success: [],
        email: '',
        name: '',
        phone: '',
        subscription_date: '',
        password: '',
        post_number: '',
        user_id:''
    },
    created: function () {
        /// function being called on page load
        this.children_by_default();
        


    },

    watch: {

    },
    methods: {

        children_by_default: function () {

            this.user_id  = window.location.href.split('/')[5]; 
            this.$http.get('/admin/get-one-client/'+ this.user_id).then((response) => {

                //alert();
                console.log('data of info', response.body.data[0]);

                var data = {
                };
                this.errors = [];

                if (response.body.status == 'success') {

                    var child_data = response.body.data[0];
                    var user_data = response.body.data[1];
                    
                    if(user_data){
                    if (user_data.name) {
                        this.name = user_data.name;
                        console.log('date of user', this.name);
                    }
                    if (user_data.email) {
                        this.email = user_data.email;
                    }
                    if (user_data.phone) {
                        this.phone = user_data.phone;
                    }
                    
                    if (user_data.subscription_ends_at) {
                        this.subscription_ends_at = user_data.subscription_date;
                    }
                }                  
                    this.selected = 0;
//                    if (!(child_data.post_code)) {
//                        //this.post_number = 'Ange ditt postnummer';
//                    } else {
//                        this.post_number = child_data.post_code;
//                    }
                    
                 if(child_data)
                  {
                        
                    if (child_data.child_1_age) {

                        this.selected++;
                        data.id = 0;
                        data.value = child_data.child_1_age;
                        this.children[0] = data;
                        data = {};
                    }
                    if (child_data.child_2_age) {
                        this.selected++;
                        data.id = '1';
                        data.value = child_data.child_2_age;
                        this.children[1] = data;
                        data = {};
                    }
                    if (child_data.child_3_age) {
                        this.selected++;
                        data.id = 2;
                        data.value = child_data.child_3_age;
                        this.children[2] = data;
                        data = {};
                    }
                    if (child_data.child_4_age) {
                        this.selected++;
                        data.id = 3;
                        data.value = child_data.child_4_age;
                        this.children[3] = data;
                        data = {};
                    }
                    if (child_data.child_5_age) {
                        this.selected++;
                        data.id = 4;
                        data.value = child_data.child_5_age;
                        this.children[4] = data;
                        data = {};
                    }
                    
                    
                }
                
                console.log('selected value is', this.selected);
                    if(this.selected == 0 || this.selected == null){
                        this.selected = 'Select';
                    }
                    console.log('total kids are', this.children);

                } else {
                    console.log('here it is: ', response.body.message);

                    for (var i = 1; i < 3; i++) {
                        console.log('get the error', i);
                        data.id = i - 1;
                        data.value = '';
                        this.children[i - 1] = data;
                        console.log("data of the array", this.children);
                        //console.log("data of the array",data);
                        data = {};
                    }
                }
            }, (response) => {
                // error occur
            });


        },
        
        select_children: function () {
            //this.children = [];
            var data = {
            };
            var children_num = parseInt(this.selected);

            //children_num + 1
            var i = 1;
            if ((this.children).length) {
                i = (this.children).length + 1;
                if (i > 5) {
                    i = 5;
                }
            }

            //alert((this.children).length);
            if ((this.children).length > children_num) {

                //alert('less');
                for (var m = ((this.children).length) - 1; m > children_num - 1; m--) {

                    this.children.splice(m, 1);
                    //this.children.pop(m);
                    console.log(this.children);
                }
            } else {
                for (i; i < children_num + 1; i++) {
                    console.log('get the error', i);
                    data.id = i - 1;
                    data.value = '';
                    this.children[i - 1] = data;
                    console.log("data of the array", this.children);
                    //console.log("data of the array",data);
                    data = {};
                }
            }
        },

        remove: function (id) {
            //this.children.$remove(id);
            this.children.splice(id, 1);
            this.selected = this.selected - 1;
            if( this.selected == 0){                
                this.selected = 'Select';
            }
            //this.children.pop(id);
            console.log('data of children', this.selected);
            console.log('children array', this.children);
        },

        add_children_data: function () {

            this.errors = [];
            var childrens_obj = [];

            console.log('children 1111', this.children);
            for (var j = 0; j < this.children.length; j++) {

                childrens_obj[j] = this.children[j];
            }

            this.children['post_number'] = this.post_number;

            var save_children_data_obj = [];
            if(this.name){
                save_children_data_obj[0] = this.name;
            }
            else{
                this.errors.push('please enter name.');
            }
            if(this.email){
                save_children_data_obj[1] = this.email;
            }
            else{
                this.errors.push('please enter email.');
            }
            if(this.phone){
                save_children_data_obj[2] = this.phone;
            }
//            else{
//                this.errors.push('please enter phone.');
//            }
            
            console.log('data of childs', childrens_obj);
            
            save_children_data_obj[3] = this.subscription_date;
            save_children_data_obj[4] = childrens_obj;
            save_children_data_obj[5] = this.user_id;
         
            console.log('children ages', j);
            if(this.name && this.email ){
            this.$http.post('/admin/save-cuctomer-info', save_children_data_obj).then((response) => {
                //response = json.parse(response);
                // console.log(response.body.data);
                this.errors = [];
                this.success = [];
                if (response.body.status == 'success') {

                    //this.success.push(response.body.message);
                    this.success.push('Information updated successfully');
                    window.location.href = '/admin/client';
                } else {
                    console.log('here it is: ', response.body.message);
                    this.errors.push(response.body.message);

                }


            }, (response) => {
                // error occur
            });
        }
        }




    }
});
