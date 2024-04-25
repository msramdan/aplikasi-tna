<script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('material/assets/js/app.js') }}"></script>
<script src=https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js></script>
<script src=https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@include('sweetalert::alert')
@stack('js')
