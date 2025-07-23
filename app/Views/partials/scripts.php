    <!-- jQuery library js -->
    <script src="<?= base_url('assets/js/lib/jquery-3.7.1.min.js') ?>"></script>
    <!-- Bootstrap js -->
    <script src="<?= base_url('assets/js/lib/bootstrap.bundle.min.js') ?>"></script>
    <!-- Apex Chart js -->
    <script src="<?= base_url('assets/js/lib/apexcharts.min.js') ?>"></script>
    <!-- Iconify Font js -->
    <script src="<?= base_url('assets/js/lib/iconify-icon.min.js') ?>"></script>
    <!-- jQuery UI js -->
    <script src="<?= base_url('assets/js/lib/jquery-ui.min.js') ?>"></script>
    <!-- Vector Map js -->
    <script src="<?= base_url('assets/js/lib/jquery-jvectormap-2.0.5.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/lib/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <!-- Popup js -->
    <script src="<?= base_url('assets/js/lib/magnifc-popup.min.js') ?>"></script>
    <!-- Slick Slider js -->
    <script src="<?= base_url('assets/js/lib/slick.min.js') ?>"></script>
    <!-- prism js -->
    <script src="<?= base_url('assets/js/lib/prism.js') ?>"></script>
    <!-- file upload js -->
    <script src="<?= base_url('assets/js/lib/file-upload.js') ?>"></script>
    <!-- audioplayer -->
    <script src="<?= base_url('assets/js/lib/audioplayer.js') ?>"></script>

    <!-- main js -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <!-- Data Table js -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>plugins/table/datatable/dt-global_style.css">
    <link href="<?php echo base_url(); ?>assets/customcss/tables/table-basic.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>plugins/table/datatable/datatables.js"></script>
    <script>
        $('.zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        });
    </script>
    <script src="<?php echo base_url();?>plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/jszip.min.js"></script>    
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
        $('.html5-extension').DataTable( {
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn btn-primary' },
                    { extend: 'csv', className: 'btn btn-primary' },
                    { extend: 'excel', className: 'btn btn-primary' },
                    { extend: 'print', className: 'btn btn-primary' }
                ]
            },
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        } );
    </script>