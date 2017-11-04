new Vue({
    el:'#import',
    methods:
        {
            importCommunities:function()
            {
                $("#img").show();
                this.$http.get('/import/communities').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Communities data updated successfully!');
                $('.community_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importSchools:function()
            {
                $("#img").show();
                this.$http.get('/import/schools').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Schools data updated successfully!');
                $('.school_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importpupilstats:function()
            {
                $("#img").show();
                this.$http.get('/import/pupil-stats').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Teachers data updated successfully!');
                $('.teacher_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importnationalresults:function()
            {
                $("#img").show();
                this.$http.get('/import/national-results').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('National test results data updated successfully!');
                $('.national_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importuppersecdata:function()
            {
                $("#img").show();
                this.$http.get('/import/upper-sec-data').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Qualified upper secondary schools data updated successfully!');
                $('.qualified_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importgrade9data:function()
            {
                $("#img").show();
                this.$http.get('/import/grade9-data').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Grades per subject data updated successfully!');
                $('.grade9_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            importschoolsalsavalues:function()
            {
                $("#img").show();
                this.$http.get('/import/school-salsa-values').then((response) => {
                    // successfuly done
                    $("#img").hide();
                $("#success-msg").show();
                $('.completed-msg').text('Salsa schools data updated successfully!');
                $('.salsa_status').text('Processed');

            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

            downloadfiles:function()
            {
                $("#img").show();
                this.$http.get('/import/download').then((response) => {
                    // successfuly done
                    $("#img").hide();
                    $("#success-msg").show();
            }, (response) => {
                // error occur
                $("#img").hide();
                $("#error-msg").show();
            });
            },

        }
});
