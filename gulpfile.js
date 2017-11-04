const elixir = require('laravel-elixir');
//var elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');



/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
       .webpack('app.js', 'public/js/vue.js');


    ///styles for user-side
        mix.styles([

        'user/bootstrap.min.css',
        'user/style_desktop.css'
        ], 'public/user_assets/css/main.css');

        mix.styles([
        'user/jquery.mCustomScrollbar.css'
        ], 'public/user_assets/css/mCustomScrollbar.css');
    /// scripts for user-side    
    mix.scripts([
        'user/html5shiv.min.js',
        'user/jquery-3.1.0.min.js',
        'user/bootstrap.js',
        
        'user/typeahead.bundle.min.js'
    ], 'public/user_assets/scripts/main.js');

    // script for google analytics
    mix.scripts([
        'user/google-analytics.js'
    ], 'public/user_assets/scripts/google-analytics.js');

    /// scripts for scroll bar in school comparison page
    mix.scripts([
        'user/jquery.mCustomScrollbar.concat.min.js'
    ], 'public/user_assets/scripts/mCustomScrollbar.js');

    mix.styles([
        'admin/icons/icomoon/styles.css',
        'admin/bootstrap.css',
        'admin/core.css',
        'admin/components.css',
        'admin/colors.css'
        ], 'public/css/admin/admin_login.css');

    mix.scripts([
        'admin/plugins/loaders/pace.min.js',
        'admin/core/jquery.min.js',
        'admin/core/bootstrap.min.js',
        'admin/plugins/loaders/blockui.min.js',
        'admin/plugins/forms/styling/uniform.min.js',
        'admin/plugins/forms/styling/switch.min.js',
        'admin/plugins/forms/validation/validate.min.js',
        'admin/pages/login_validation.js',
        'admin/pages/form_checkboxes_radios.js'
    ], 'public/js/admin/admin_login.js');

    mix.styles([
        'admin/google-fonts.css',
        'admin/bootstrap.css',
        'admin/core.css',
        'admin/components.css',
        'admin/colors.css',
        'admin/icons/fontawesome/styles.min.css',
        'admin/icons/icomoon/styles.css',
        'admin/animate.min.css',
        'admin/app.css'
    ], 'public/css/admin/admin.css');

    mix.scripts([
        'admin/plugins/loaders/pace.min.js',
        'admin/core/jquery.min.js',
        'admin/jquery-ui.min.js',
        'admin/core/bootstrap.min.js',
        'admin/plugins/loaders/blockui.min.js',
        'admin/plugins/visualization/d3/d3.min.js',
        'admin/plugins/visualization/d3/d3_tooltip.js',
        'admin/plugins/forms/styling/uniform.min.js',
        'admin/plugins/forms/styling/switchery.min.js',
        'admin/plugins/forms/styling/switch.min.js',
        'admin/plugins/forms/inputs/touchspin.min.js',
        'admin/plugins/forms/selects/bootstrap_multiselect.js',
        'admin/plugins/ui/moment/moment.min.js',
        'admin/plugins/pickers/daterangepicker.js',
        'admin/plugins/ui/nicescroll.min.js',
        'admin/plugins/ui/prism.min.js',
        'admin/plugins/tables/footable/footable.min.js',
        'admin/plugins/tables/datatables/datatables.min.js',
        'admin/plugins/forms/selects/select2.min.js',
        'admin/plugins/pickers/anytime.min.js',
        'admin/plugins/pickers/pickadate/picker.js',
        'admin/plugins/pickers/pickadate/picker.date.js',
        'admin/plugins/pickers/pickadate/picker.time.js',
        'admin/plugins/pickers/pickadate/legacy.js',
        'admin/plugins/forms/validation/validate.min.js',
        'admin/plugins/notifications/sweet_alert.min.js',
        'admin/plugins/trees/fancytree_all.min.js',
        'admin/plugins/trees/fancytree_childcounter.js',
        'admin/jquery.weekpicker.js',
        'admin/numeral.min.js',
        'admin/pages/layout_fixed_custom.js',
        'admin/pages/form_input_groups.js',
        'admin/pages/form_checkboxes_radios.js',
        'admin/pages/form_select2.js',
        'admin/pages/picker_date.js',
        'admin/pages/form_validation.js',
        'admin/pages/components_buttons.js',
        'admin/core/app.js'
    ], 'public/js/admin/admin.js');

    mix.scripts([
        'admin/require.js',
        'admin/dashboard.js'
    ], 'public/js/admin/dashboard.js');

    mix.webpack('admin/vuejs/user.js', 'public/js/admin/vuejs/user.js');

    mix.webpack('admin/vuejs/community.js', 'public/js/admin/vuejs/community.js');

    mix.webpack('admin/vuejs/school.js', 'public/js/admin/vuejs/school.js');

    mix.webpack('admin/vuejs/grade9data.js', 'public/js/admin/vuejs/grade9data.js');

    mix.webpack('admin/vuejs/import.js', 'public/js/admin/vuejs/import.js');

    mix.webpack('admin/vuejs/nationalResultData.js', 'public/js/admin/vuejs/nationalResultData.js');

    mix.webpack('admin/vuejs/schoolSalsaValue.js', 'public/js/admin/vuejs/schoolSalsaValue.js');

    mix.webpack('admin/vuejs/qualifyUpperSecData.js', 'public/js/admin/vuejs/qualifyUpperSecData.js');

    mix.webpack('admin/vuejs/schoolPupilTeacherStat.js', 'public/js/admin/vuejs/schoolPupilTeacherStat.js');

    mix.webpack('admin/vuejs/communitySalsaValue.js', 'public/js/admin/vuejs/communitySalsaValue.js');

    mix.webpack('admin/vuejs/subject.js', 'public/js/admin/vuejs/subject.js');

    mix.webpack('admin/vuejs/colorcode.js', 'public/js/admin/vuejs/colorcode.js');

    mix.webpack('admin/vuejs/client.js', 'public/js/admin/vuejs/client.js');
    
    //// vue js files for user side
    mix.webpack('user/vuejs/skolval.js', 'public/js/user/vuejs/skolval.js');

    mix.webpack('user/vuejs/school_comparison.js', 'public/js/user/vuejs/school_comparison.js');
	
    mix.webpack('user/vuejs/map.js', 'public/js/user/vuejs/map.js');
	
    mix.webpack('user/vuejs/account.js', 'public/js/user/vuejs/account.js');
	
    mix.webpack('user/vuejs/customer_edit.js', 'public/js/user/vuejs/customer_edit.js');
	
    mix.webpack('user/vuejs/home.js', 'public/js/user/vuejs/home.js');
	
    mix.webpack('user/vuejs/premium_bar.js', 'public/js/user/vuejs/premium_bar.js');
	
    mix.webpack('user/vuejs/questions.js', 'public/js/user/vuejs/questions.js');
});

