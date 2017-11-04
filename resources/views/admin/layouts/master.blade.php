<!DOCTYPE html>
<html lang="en">

@include('admin.partials.masterhead')

@yield('css')

<body class="navbar-top sidebar-xs">
{{ csrf_field() }}
<!-- Main navbar -->
@include('admin.partials.nav')
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		@include('admin.partials.sidebar')
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			@include('admin.partials.pageheader')
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
				@include('errors.success')
				@yield('content')
			<!-- Footer -->
				@include('admin.partials.footer')
			<!-- /footer -->
			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</div>
<!-- /page container -->
@yield('script')
</body>
</html>