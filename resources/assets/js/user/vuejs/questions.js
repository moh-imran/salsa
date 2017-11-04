
//Vue.component('one-child', {
//  template: '<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">\n\
//             <input class="form-control" placeholder="Ålder på barn 1" type="text">\n\
//             </div>\n\
//             <button v-on:click="$emit(\'remove\')">X</button>'  
//})

new Vue({
    el: '#register',
    data: {
        clients: {},
        selected: '2',
        children: [],
        errors: [],
        success: [],
        email:'',
        password:'',
        post_number: ''
    },
    created: function () {
        /// function being called on page load
        this.children_by_default();
    },

    watch: {

    },
    methods: {

        children_by_default: function () {

            var data = {
                    };
            
            for (var i = 1; i < 3; i++) {
                        console.log('get the error', i);
                        data.id = i - 1;
                        data.value = '';
                        this.children[i - 1] = data;
                        console.log("data of the array", this.children);
                        //console.log("data of the array",data);
                        data = {};
                    }
//            
//            this.$http.get('/account-info').then((response) => {
//
//                //alert();
//                console.log('data of info',response.body.data[0]);
//                
//                var data = {
//                    };
//                this.errors = [];
//                
//                if (response.body.status == 'success') {
//                   
//                   console.log('success: ', response.body);
//                   var child_data = response.body.data[0];
//                   var user_data = response.body.data[1];
//                   if(user_data.email){
//                       this.email = user_data.email;
//                   }
//                   this.selected = 0;
//                   
//                   if(!(child_data.post_code)){
//                       this.post_number = 'Ange ditt postnummer';
//                   }
//                   else{
//                       this.post_number = child_data.post_code;
//                   }
//                    
//                    if (child_data.child_1_age) {
//                        
//                        this.selected++;
//                        data.id = 0;
//                        data.value = child_data.child_1_age;
//                        this.children[0] = data; 
//                        data = {};
//                    }
//                    if (child_data.child_2_age) {
//                        this.selected++;
//                        data.id = '1';
//                        data.value = child_data.child_2_age;
//                        this.children[1] = data;
//                        data = {};
//                    }
//                    if (child_data.child_3_age) {
//                        this.selected++;
//                        data.id = 2;
//                        data.value = child_data.child_3_age;
//                        this.children[2] = data;
//                        data = {};
//                    }
//                    if (child_data.child_4_age) {
//                        this.selected++;
//                        data.id = 3;
//                        data.value = child_data.child_4_age;
//                        this.children[3] = data;
//                        data = {};
//                    }
//                    if (child_data.child_5_age) {
//                        this.selected++;
//                        data.id = 4;
//                        data.value = child_data.child_5_age;
//                        this.children[4] = data;
//                        data = {};
//                    }
//                    console.log('total kids are', this.children);
//
//                } else {
//                    console.log('here it is: ', response.body.message);
//                    
//                    for (var i = 1; i < 3; i++) {
//                        console.log('get the error', i);
//                        data.id = i - 1;
//                        data.value = '';
//                        this.children[i - 1] = data;
//                        console.log("data of the array", this.children);
//                        //console.log("data of the array",data);
//                        data = {};
//                    }
//                }
//            }, (response) => {
//                // error occur
//            });


        },
        select_children: function () {
            //this.children = [];
            var data = {
            };
            var children_num = parseInt(this.selected);

            //children_num + 1
            var i = 1;
            if((this.children).length){
                i = (this.children).length+1;
                if(i>5){
                    i=5;
                }
            } 
            
            //alert((this.children).length);
            if((this.children).length > children_num){                                
                
                //alert('less');
                for(var m=((this.children).length)-1; m>children_num-1; m--){
                    
                    this.children.splice(m, 1);
                    //this.children.pop(m);
                    console.log(this.children);
                }
            }
            else{
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
            //this.children.pop(id);
            console.log('children array', this.children);
        },

        add_children_data: function () {


            var childrens_obj = [];
            
            console.log('children 1111', this.children);
            for (var j = 0; j < this.children.length; j++) {
                
                childrens_obj[j] = this.children[j];
            }

            this.children['post_number'] = this.post_number;

            var save_children_data_obj = [];
            save_children_data_obj[0] = this.post_number;
            save_children_data_obj[1] = childrens_obj;
            save_children_data_obj[2] = this.email;
            save_children_data_obj[3] = this.password;
            console.log('children ages', j);

            this.$http.post('/save-children-info', save_children_data_obj).then((response) => {
                //response = json.parse(response);
               // console.log(response.body.data);
                this.errors = [];
                this.success = [];
                if (response.body.status == 'success') {

                    //this.success.push(response.body.message);
                    window.location = '/map';
                } else {
                    console.log('here it is: ', response.body.message);
                    this.errors.push(response.body.message);

                }


            }, (response) => {
                // error occur
            });
        }




    }
});
