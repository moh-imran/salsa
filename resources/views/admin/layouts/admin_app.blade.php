<!DOCTYPE html>
<html lang="en">

@include('admin.partials.apphead')

<body class="login-cover">

<!-- Page container -->
<div class="page-container login-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

            @yield('content')
            <!-- Footer -->
            @include('admin.partials.footerapp')
            <!-- /footer -->
            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>