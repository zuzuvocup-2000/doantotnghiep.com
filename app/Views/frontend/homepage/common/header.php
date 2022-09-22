<?php
   $model = new App\Models\AutoloadModel();
?>
<header class="header uk-visible-large" >
    <div class="header-top">
		<div class="uk-container uk-container-center">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-small-1-4">
					<div class="header-logo">
						<?php echo logo(); ?>
					</div>
				</div>
            <?php $headerSlide = get_slide(['keyword' => 'header-slide','language' => 'vi']) ?>
				<div class="uk-width-small-3-4">
               <?php if(isset($headerSlide) && is_array($headerSlide) && count($headerSlide)){ ?>
					<div class="header-slide">
						<div class="owl-carousel owl-theme owl-slide">
                     <?php foreach($headerSlide as $key => $val){ ?>
							<div class="item">
								<div class="thumb">
									<a href="<?php echo $val['canonical'] ?>" title="slide" class="image-slide img-cover">
										<img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>">
									</a>
								</div>
							</div>
                     <?php } ?>
						</div>
					</div>
               <?php } ?>
				</div>
			</div>
		</div>
	</div>
   <?php
      $member = (isset($_COOKIE['member'])) ? $_COOKIE['member'] : '';
      $member = json_decode($member, TRUE);
      $member = $model->_get_where([
         'select' => '*',
         'table' => 'member',
         'where' => [
            'id' => $member['id']
         ]
      ]);
   ?>
	<div class="header-widget">
		<div class="uk-container uk-container-center">
			<ul class="uk-flex uk-flex-middle uk-list uk-clearfix widget uk-flex-right">
				<li><a href="" title="" onclick="return false;">Mobile</a></li>
				<li><a href="<?php echo ((isset($member) && is_array($member) && count($member)) ? 'member/create.html' : '') ?>" title="" <?php echo (!isset($member) || is_array($member) == false || count($member) == 0 ) ? 'data-uk-modal="{target:\'#register\'}"'  : '' ?>>Đăng tin nhà đất</a></li>
            <?php if(!isset($member) || is_array($member) == false || count($member) == 0){ ?>
				<li><a href="" title="" data-uk-modal="{target:'#register'}">Đăng ký thành viên</a></li>
				<li><a href="" title="" data-uk-modal="{target:'#login'}">Đăng nhập</a></li>
            <?php }else{ ?>
               <li><a href="member/profile.html" title="Profile">Xin chào: <?php echo $member['fullname']; ?></a></li>
            <?php } ?>
			</ul>
			<div class="modal-none">
				<div id="register" class="uk-modal">
					<div class="uk-modal-dialog">
						<form action="" class="register-form member-register" method="post">
							<h2 class="heading-2"><span>Đăng ký thành viên</span></h2>
							<div class="ping mb10">
								<ul class="uk-clearfix">
									<li>Lưu ý: Giả mạo thông tin của cá nhân, tổ chức để tham gia hoạt động thương mại điện tử nhằm gây ảnh hưởng đến uy tín, cuộc sống của cá nhân, tổ chức có thể bị phạt tới 30 triệu đồng. <br>Xem thêm NĐ <b>52/2013/NĐ-CP</b>. Thông tin người đăng thật sự có thể được xác định thông qua địa chỉ ip của máy tính, điện thoại,...</li>
								</ul>
							</div>
                     <div class="form-field">
                        <label for="">Email liên hệ (<span>*</span>)</label>
                        <input required type="text" class="input-text" name="email">
                     </div>
							<div class="form-field">
								<label for="">Mật khẩu (<span>*</span>)</label>
								<input required  type="password" class="input-text" name="password">
							</div>
							<div class="form-field">
								<label for="">Nhập lại mật khẩu (<span>*</span>)</label>
								<input required type="password" class="input-text" name="re_password">
							</div>
							<div class="form-field">
								<label for="">Họ tên (<span>*</span>)</label>
								<input required type="text" class="input-text" name="fullname">
							</div>
							<div class="form-field">
								<label for="">Di động  (<span>*</span>)</label>
								<input required type="text" class="input-text" name="phone">
							</div>

                     <?php

                        $city = $model->_get_where([
                           'select' => '*',
                           'table' => 'vn_province',
                        ], TRUE);
                     ?>
							<div class="form-field">
								<label for="">Tỉnh/Thành phố (<span>*</span>)</label>
								<select name="cityid" id="city_2">
									<option value="0">[Chọn Tỉnh/Thành]</option>
                           <?php foreach($city as $key => $val){ ?>
									<option value="<?php echo $val['provinceid'] ?>"><?php echo $val['name'] ?></option>
                           <?php } ?>
								</select>
							</div>
							<div class="form-field">
								<label for="">Quận/Huyện (<span>*</span>)</label>
								<select name="districtid" id="district_2">
									<option value="0">Chọn Quận/Huyện </option>
								</select>
							</div>
							<div class="form-field uk-flex uk-flex-middle">
								<label for="">Loại tài khoản (<span>*</span>)</label>
								<div class="checkbox">
									<input value="1" name="catalogueid" type="radio" id="agent1" class="agent" style="width:16px; height:16px;display:inline-block;">
									Cá nhân
								</div>
								<div class="checkbox">
									<input value="2" name="catalogueid" type="radio" id="agent2" class="agent" style="width:16px; height:16px;display:inline-block;">
									Nhà môi giới
								</div>
							</div>
							<div class="form-field mt10 uk-text-right">
								<button type="submit" name="create" value="create" class="btn-register">Đăng ký</button>
								<button class="uk-modal-close uk-close">Thoát</button>
							</div>
						</form>
					</div>
				</div>
				<div id="login" class="uk-modal">
					<div class="uk-modal-dialog">
						<form action="" class="login-form" method="post">
							<h2 class="heading-2"><span>Đăng nhập</span></h2>
							<div class="form-field">
								<label for="">Email</label>
								<input name="email" type="text" >
							</div>
							<div class="form-field">
								<label for="">Mật khẩu</label>
								<input type="password" name="password" >
							</div>
							<div class="form-field pdcst">
								<span class="show-recover-form" >Quên mật khẩu ?</span>
								<a data-uk-modal="{target:'#register'}" class="show-register-form">Đăng ký</a>
							</div>
							<div class="form-field mt10 uk-text-center">
								<button class="btn-register">Đăng nhập</button>
								<button class="uk-modal-close uk-close">Thoát</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-menu">
      <?php $menu = get_menu(['keyword'=> 'main-menu','output' => 'array', 'language' => 'vi']) ?>
		<div class="uk-container uk-container-center">
         <?php if(isset($menu['data']) && is_array($menu['data']) && count($menu['data'])){ ?>
			<ul class="uk-list uk-clearfix uk-flex uk-flex-middle menu">
				<li><a class="home" href="/" title=""></a></li>
            <?php foreach($menu['data'] as $key => $val){ ?>
				<li>
					<a href="<?php echo write_url($val['canonical']) ?>" title="<?php echo $val['title'] ?>"><?php echo $val['title'] ?></a>
               <?php if(isset($val['children']) && is_array($val['children']) && count($val['children'])){ ?>
					<ul class="uk-list dropdown-menu uk-clearfix">
                  <?php foreach($val['children'] as $keyChild => $valChild){ ?>
						<li>
							<a href="<?php echo write_url($valChild['canonical']) ?>" ttile="<?php echo $valChild['title'] ?>"><?php echo $valChild['title'] ?></a>
                     <?php if(isset($valChild['children']) && count($valChild['children'])){ ?>
							<ul class="uk-list dropdown-menu2 uk-clearfix">
                        <?php foreach($valChild['children'] as $keyS => $valS){ ?>
								<li><a href="<?php echo write_url($valS['canonical']) ?>" ttile="<?php echo $valS['title'] ?>"><?php echo $valS['title'] ?></a></li>
                        <?php } ?>
							</ul>
                     <?php } ?>
						</li>
                  <?php } ?>
					</ul>
               <?php } ?>
				</li>
            <?php } ?>
			</ul>
         <?php } ?>
		</div>
	</div>
</header>
<header class="mobile-header uk-hidden-large">
	<section class="upper">
		<a class="moblie-menu-btn skin-1" href="#offcanvas" class="offcanvas" data-uk-offcanvas="{target:'#offcanvas'}">
			<span>Menu</span>
		</a>
		<div class="logo"><a href="" title="Logo"><img src="<?php echo $general['homepage_logo']; ?>" alt="Logo" /></a></div>
		<div class="mobile-hotline">
			<a class="value" href="tel:<?php echo $general['contact_hotline']; ?>" title="Tư vấn bán hàng"><?php echo $general['contact_hotline']; ?></a>
		</div>
	</section><!-- .upper -->
	<section class="lower">
		<div class="mobile-search">
			<form action="<?php echo site_url('tim-kiem'); ?>" method="" class="uk-form form">
				<input type="text" name="keyword" class="uk-width-1-1 input-text" placeholder="Bạn muốn tìm gì hôm nay?" />
				<button type="submit" name="" value="" class="btn-submit">Tìm kiếm</button>
			</form>
		</div>
	</section>
</header><!-- .mobile-header -->
<script type="text/javascript">
   $(document).ready(function(){

      $('.login-form').on('submit', function(){
         let _this = $(this);
         let formData = _this.serializeArray();
         $.post('ajax/member/login', // URL
         {
            post : formData
         }, function(json){ // Success
            if(json.flag == 1){
               alert(json.message);
               return false;
            }else{
               alert(json.message);
               location.reload();
            }

         },'json' );

         return false;
      });

      $('.member-register').on('submit', function(){
         let _this = $(this);
         let formData = _this.serializeArray();
         $.post('ajax/member/register', // URL
         {
            post : formData
         }, function(json){ // Success
            if(json.flag == 1){
               alert(json.message);
               return false;
            }else{
               alert(json.message);
               location.reload();
            }

         },'json' );


         return false;
      });
   });
</script>
