<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo BASE_URL; ?>">
    <title>LOGIN | <?php echo COMPANY_NAME ?> SYSTEM V2.0</title>

    <link href="<?php echo ASSET_BACKEND; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo ASSET_BACKEND; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>css/customize.css" rel="stylesheet">
    <?php  
        $css = [
            ASSET_BACKEND.'css/plugins/toastr/toastr.min.css',
        ];
    ?>
    <?php foreach($css as $key => $val){
        echo '<link href="'.$val.'" rel="stylesheet">';
    } ?>
    <style>
        #toast-container>.toast-success:before {
            content: "";
        }
    </style>
    <script src="public/backend/js/jquery-3.1.1.min.js"></script>
</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold"><?php echo COMPANY_NAME ?> SYSTEM V.2.0+</h2>

                <p>
                    Hệ thống CMS được phát triển bằng Framework Codeigniter 4 - PHP 7.3 - MySQL 5.6
                </p>

                <p>
                    Sản phẩm bắt đầu phát triển vào năm 2021 và đã qua nhiều lần chỉnh sửa và nâng cấp hệ thống nhằm nâng cao chất lượng hệ thống
                </p>

                <p>
                    Website được viết theo chuẩn Restful Controllers và có thể dễ dàng nâng cấp lên Restful API thông qua các Services và Respositories
                </p>

            </div>
            <div class="col-md-6">
                <div class="ibox-content">

                    <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                    
                    <form class="m-t" method="post" action="">
                        <div class="form-group">
                            <input type="text" required name="otp" value="<?php echo set_value('otp') ?>" class="form-control" placeholder="Nhập vào mã OTP của bạn">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Xác nhận mã OTP</button>

                        <a href="<?php echo base_url(BACKEND_DIRECTORY); ?>">
                            <small>Đăng nhập?</small>
                        </a>
                    </form>
                    <p class="m-t">
                        <small>Hệ thống quản trị nội dung <?php echo COMPANY_NAME ?> 2022 Version 2.0</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                <?php echo COMPANY_NAME ?> Copyright <?php echo date('Y'); ?>
            </div>
            <div class="col-md-6 text-right">
               <small>© 2021-2022</small>
            </div>
        </div>
    </div>
    <?php
        $script = [
            ASSET_BACKEND.'js/plugins/toastr/toastr.min.js',
        ];
    ?>
    <?php foreach($script as $key => $val){
        echo '<script src="'.$val.'"></script>';
    } ?>
    <?php echo view('backend/dashboard/common/notification') ?>
</body>

</html>
