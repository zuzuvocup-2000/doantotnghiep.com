<?php
	$footer_menu = get_menu(['keyword' => 'menu-footer','language' => 'vi','output' => 'array']);
?>

<footer class="footer">
    <div class="footer-main">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
               <?php if(isset($footer_menu['data']) && is_array($footer_menu['data']) && count($footer_menu['data'])){   ?>
                  <?php foreach($footer_menu['data'] as $key => $val){ ?>
                  <?php if($key > 1) break; ?>
                <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                    <div class="ft-item">
                        <h2 class="title"><span><?php echo $val['title'] ?></span></h2>
                        <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                        <ul class="uk-list uk-clearfix footer-menu">
                           <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                            <li><a href="<?php echo write_url($valChild['canonical']) ?>" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a></li>
                           <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
               <?php }} ?>
                <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                     <?php foreach($footer_menu['data'] as $key => $val){ ?>
                     <?php if($key <= 1) continue; ?>
                    <div class="ft-item">
                        <h2 class="title"><span><?php echo $val['title'] ?></span></h2>
                        <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
                        <ul class="uk-list uk-clearfix footer-menu link">
                           <?php foreach($val['children'] as $keyChild => $valChild){ ?>
                             <li><a href="<?php echo write_url($valChild['canonical']) ?>" title="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a></li>
                          <?php } ?>
                        </ul>
                        <?php } ?>
                        <h3 class="title"><span>HỖ TRỢ</span></h3>
                        <div class="phone">Số điện thoại: <span><?php echo $general['contact_hotline'] ?></span></div>
                        <div class="email">Email: <span><?php echo $general['contact_email'] ?></span></div>
                    </div>
                  <?php } ?>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                    <div class="ft-item">
                        <h2 class="title"><span>KẾT NỐI VỚI CHÚNG TÔI</span></h2>
                        <ul class="uk-list uk-clearfix footer-menu social uk-flex uk-flex-middle">
                            <li><a class="facebook" href="<?php echo $general['social_facebook'] ?>" title="face"><i class="fab fa-facebook-f fa-fw"></i></a></li>
                            <li><a class="linkedin" href="" title="linkedin"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
                            <li><a class="twitter" href="<?php echo $general['social_twitter'] ?>" title="twitter"><i class="fab fa-twitter fa-fw"></i></a></li>
                        </ul>
                        <h3 class="title"><span>TẢI ỨNG DỤNG TRÊN ĐIỆN THOẠI</span></h3>
                        <div class="appstore"><a href="" title=""><i class="fab fa-apple fa-fw"></i> Appstore</a></div>
                        <div class="ggplay"><a href="" title=""><i class="fab fa-google-play fa-fw"></i> Google Play</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-text">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-small-1-1 uk-width-medium-8-10">
                    <div class="text"><?php echo $general['intro_description'] ?></div>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-2-10">
                    <div class="thumb">
                        <a class="image img-cover" href="" title=""><img src="public/frontend/resources/img/20150827110756-dadangky.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>



<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=103609027035330&autoLogAppEvents=1" nonce="nv2ghxM1"></script>
