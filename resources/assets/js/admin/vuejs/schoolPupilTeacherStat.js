new Vue({
    el:'#schoolPupilTeacherStat',
    data: {
        schoolPupilTeacherStats : {},
        pagingData:{},
        pagingUrl: '',
        search: '',
        orderBy: '',
        page: ''
    },
    created: function()
    {
        this.loadSchoolPupilTeacherStatList();
    },
    watch: {

    },
    methods:
        {
            deleteSchoolPupilTeacherStatData:function(id)
            {
                this.$http.delete('/admin/school-pupil-teacher-stat/' + id).then((response) => {
                    // successfuly done

                }, (response) => {
                    // error occur
                });
            },
            goto: function(){
                if(this.page > this.pagingData.last_page){
                    this.page = this.pagingData.last_page
                    this.loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+this.page+'&search=')
                }else if(this.page < 1){
                    this.loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page=1&search=');
                }else{
                    this.loadSchoolPupilTeacherStatList('/admin/get-school-pupil-teacher-stat?page='+this.page+'&search=')
                }
            },
            
            loadSchoolPupilTeacherStatList: function(url = false){
                if(url == false){
                    url = '/admin/get-school-pupil-teacher-stat?search=';
                }
                if(this.search != ''){
                    url = url+''+this.search;
                }
                if(this.orderBy != ''){
                    url = url+'&orderBy='+this.orderBy;
                }
                this.$http.get(url) .then ((response) => {
                    this.pagingData = response.body;
                this.schoolPupilTeacherStats = response.body.data;
                console.log(this.pagingData);

            }, (response) => {
                    // error occur
                });

            }

        }
});
