<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title><?= isset($pageTitle) ? $pageTitle : 'New Page' ?></title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />

    <link rel="stylesheet" href="/extra-assets/ijabo/ijaboCropTool.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link rel="stylesheet" href="/backend/src/plugins/sweetalert2/sweetalert2.css">
    <?= $this->renderSection('stylesheets') ?>
</head>

<body>

    <?php include 'inc/header.php' ?>

    <?php include 'inc/rightSidebar.php' ?>
    <?php include 'inc/leftSidebar.php' ?>


    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div>
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
            <?php include 'inc/footer.php' ?>
        </div>
    </div>

    <!-- js -->
    <script src="/backend/vendors/scripts/core.js"></script>
    <script src="/backend/vendors/scripts/script.min.js"></script>
    <script src="/backend/vendors/scripts/process.js"></script>
    <script src="/backend/vendors/scripts/layout-settings.js"></script>

    <script src="/extra-assets/ijabo/ijaboCropTool.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

    <script src="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>

    <script src="/backend/src/plugins/sweetalert2/sweetalert2.all.js"></script>
    <script src="/backend/src/plugins/sweetalert2/sweet-alert.init.js"></script>
    <script>
    $(document).on(
        "input change",
        "form input, form select, form textarea",
        function() {
            let name = $(this).attr("name");
            if (name) {
                $(this)
                    .closest("form")
                    .find("span." + name + "_error")
                    .text("");
            }
        }
    );
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-center",
            "timeOut": "3000"
        };
    });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>