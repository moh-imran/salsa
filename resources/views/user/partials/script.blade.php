<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>                                                
<script src="{{ asset('user_assets/scripts/main.js')}}"></script>
<script src="{{ asset('user_assets/scripts/google-analytics.js')}}"></script>