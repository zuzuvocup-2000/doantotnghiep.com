<nav class="navbar-default navbar-static-side" role="navigation">
    <?php
    $user = authentication();
    $uri = service('uri');
    $uri = current_url(true);
    $uriModule = $uri->getSegment(2);
    $uriModule_name = $uri->getSegment(3);
    $baseController = new App\Controllers\BaseController();
    $sidebar = new App\Controllers\Api\Sidebar\Sidebar();
    // pre($sidebar);
    $language = $baseController->currentLanguage();
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="min-width:48px;height:48px;" />
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold" style="color:#fff"><?php echo $user['fullname'] ?></strong>
                        </span> <span class="text-muted text-xs block"><?php echo $user['job'] ?> <b class="caret" style="color: #8095a8"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?php echo base_url('backend/user/profile/profile/'.$user['id']) ?>">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="<?php echo ( $uriModule == 'product' ) ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-desktop"></i> <span class="nav-label">QL Bất động sản</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/catalogue/index') ?>">QL Danh mục BĐS</a></li>
                        <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/price/index') ?>">QL Khoảng Giá</a></li>
                        <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/type/index') ?>">QL Loại BĐS</a></li>
                        <li class="<?php echo ( $uriModule_name == 'product') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/product/product/index') ?>">QL BĐS</a></li>
                    </ul>
                </li>
                <li class="<?php echo ( $uriModule == 'article') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-file"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_article', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/catalogue/index') ?>"><?php echo translate('cms_lang.sidebar.sb_article_catalogue', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'article') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/article/article/index') ?>"><?php echo translate('cms_lang.sidebar.sb_article', $language) ?></a></li>
                    </ul>
                </li>
               <li class="<?php echo ( $uriModule == 'project') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-camera-retro" aria-hidden="true"></i> <span class="nav-label">QL Dự Án</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/project/catalogue/index') ?>">QL Nhóm Dự Án</a></li>
                        <li class="<?php echo ( $uriModule_name == 'project') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/project/project/index') ?>">QL Dự Án</a></li>
                        <li class="<?php echo ( $uriModule_name == 'project') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/project/type/index') ?>">QL Loại Dự Án</a></li>
                    </ul>
                </li>

                <li class="<?php echo ( $uriModule == 'member') ? 'active'  : '' ?>">
                   <a href="index.html"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label">Quản lý Member</span> <span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                       <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url(convertUrl('backend.member.catalogue.index')) ?>">QL Nhóm Member</a></li>
                       <li class="<?php echo ( $uriModule_name == 'broker') ? 'active'  : '' ?>"><a href="<?php echo base_url(convertUrl('backend.member.member.index')) ?>">QL Member</a></li>
                   </ul>
              </li>

                <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'catalogue') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/catalogue/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user_catalogue', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'user') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/user/user/index') ?>"><?php echo translate('cms_lang.sidebar.sb_user', $language) ?></a></li>
                    </ul>
                </li>

                <li class="<?php echo ( $uriModule == 'contact' || $uriModule == 'comment') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-id-card" aria-hidden="true"></i> <span class="nav-label">QL Liên hệ</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'contact') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/contact/contact/index') ?>"><?php echo translate('cms_lang.sidebar.sb_contact', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'comment') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/comment/comment/index') ?>">QL Comment</a></li>
                    </ul>
                </li>
                <li class="<?php echo ( $uriModule == 'language' || $uriModule == 'system' || $uriModule == 'panel' || $uriModule == 'slide' || $uriModule == 'widget' || $uriModule == 'menu') ? 'active'  : '' ?>">
                    <a href="index.html"><i class="fa fa-cog"></i> <span class="nav-label"><?php echo translate('cms_lang.sidebar.sb_setting', $language) ?></span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="<?php echo ( $uriModule_name == 'slide') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/slide/slide/index') ?>"><?php echo translate('cms_lang.sidebar.sb_slide', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'panel') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/panel/panel/index') ?>"><?php echo translate('cms_lang.sidebar.sb_panel', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'general') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/system/general/index') ?>"><?php echo translate('cms_lang.sidebar.sb_general', $language) ?></a></li>
                        <li class="<?php echo ( $uriModule_name == 'menu') ? 'active'  : '' ?>"><a href="<?php echo base_url('backend/menu/menu/listmenu') ?>"><?php echo translate('cms_lang.sidebar.sb_menu', $language) ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
