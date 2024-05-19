<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?=isset($pagetitle) ? $pagetitle : "New Page"?></title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('/backend/vendors/images/apple-touch-icon.png')?>" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('/backend/vendors/images/favicon-32x32.png')?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('/backend/vendors/images/favicon-16x16.png')?>" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/vendors/styles/core.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/vendors/styles/icon-font.min.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('backend/vendors/styles/style.css')?>" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <style>
    .label-approved {
        color: green;
        font-weight: bold;
    }

    .label-rejected {
        color: red;
        font-weight: bold;
    }

    .label-pending {
        color: orange;
        font-weight: bold;
    }
    </style>
    <?=$this->renderSection('style');?>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="<?=base_url('backend/vendors/scripts/core.js')?>"></script>
    <script src="<?=base_url('backend/vendors/scripts/script.min.js')?>"></script>
    <script src="<?=base_url('backend/vendors/scripts/process.js')?>"></script>
    <script src="<?=base_url('backend/vendors/scripts/layout-settings.js')?>"></script>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.data-table-export').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>
</head>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <!-- <div class="loader-logo">
					<img src="backend/vendors/images/deskapp-logo.svg" alt="" />
				</div> -->
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <?=view('include/header')?>
    <?=view('include/right_side_bar')?>
    <?=view('include/left_side_bar')?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <?=view('include/content')?>
            </div>
            <?=view('include/footer')?>
        </div>
    </div>


</body>

</html>