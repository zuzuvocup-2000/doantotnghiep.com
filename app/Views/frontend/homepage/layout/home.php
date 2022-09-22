<!DOCTYPE html>
<html lang="vi-VN">
	<head>
		<!-- CONFIG -->
		<base href="<?php echo BASE_URL ?>" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow" />
		<meta name="author" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta name="copyright" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta http-equiv="refresh" content="1800" />
		<link rel="icon" href="<?php echo $general['homepage_favicon'] ?>" type="image/png" sizes="30x30">
		<!-- GOOGLE -->
		<title><?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?></title>
		<meta name="description"  content="<?php echo isset($meta_description)?htmlspecialchars($meta_description):'';?>" />
		<?php echo isset($canonical)?'<link rel="canonical" href="'.$canonical.'" />':'';?>
		<meta property="og:locale" content="vi_VN" />
		<!-- for Facebook -->
		<meta property="og:title" content="<?php echo (isset($meta_title) && !empty($meta_title))?htmlspecialchars($meta_title):'';?>" />
		<meta property="og:type" content="<?php echo (isset($og_type) && $og_type != '') ? $og_type : 'article'; ?>" />
		<meta property="og:image" content="<?php echo (isset($meta_image) && !empty($meta_image)) ? $meta_image : base_url(isset($general['homepage_logo']) ? $general['homepage_logo'] : ''); ?>" />
		<?php echo isset($canonical)?'<meta property="og:url" content="'.$canonical.'" />':'';?>
		<meta property="og:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
		<meta property="og:site_name" content="<?php echo (isset($general['homepage_company'])) ? $general['homepage_company'] : ''; ?>" />
		<meta property="fb:admins" content=""/>
		<meta property="fb:app_id" content="" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?php echo isset($meta_title)?htmlspecialchars($meta_title):'';?>" />
		<meta name="twitter:description" content="<?php echo (isset($meta_description) && !empty($meta_description))?htmlspecialchars($meta_description):'';?>" />
		<meta name="twitter:image" content="<?php echo (isset($meta_image) && !empty($meta_image))?$meta_image:base_url((isset($general['homepage_logo'])) ? $general['homepage_logo']  : '');?>" />

		<script type="text/javascript">
	        var BASE_URL = '<?php echo BASE_URL; ?>';
	        var SUFFIX = '<?php echo HTSUFFIX; ?>';
	    </script>
		<?php echo $general['analytic_google_analytic'] ?>
		<?php echo $general['facebook_facebook_pixel'] ?>
		<?php echo view('frontend/homepage/common/head') ?>
      <link href="public/backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
	</head>
	<body class="body">
		<?php echo view('frontend/homepage/common/header') ?>
		<div class="page-wrapper">
			<?php echo view((isset($template)) ? $template : '') ?>
		</div>
		<?php echo view('frontend/homepage/common/footer') ?>
		<?php echo view('frontend/homepage/common/offcanvas') ?>
		<?php echo view('backend/dashboard/common/notification') ?>
      <script src="public/backend/plugin/ckeditor/ckeditor.js"></script>
      <script src="public/frontend/resources/function.js"></script>
      <script src="public/frontend/resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
      <script src="public/frontend/resources/plugins/fontawesome-free-6.1.2-web/js/all.min.js"></script>
      <script src="public/frontend/resources/uikit/js/uikit.min.js"></script>
      <script src="public/frontend/resources/uikit/js/uikit-slideshow.js"></script>
      <script src="public/frontend/resources/uikit/js/components/accordion.min.js"></script>
      <script src="public/frontend/resources/uikit/js/components/lightbox.min.js"></script>
      <script src="public/frontend/resources/uikit/js/components/sticky.min.js"></script>
      </script><script src="public/backend/js/plugins/toastr/toastr.min.js"></script>
      <script type="text/javascript">
          var swiper = new Swiper(".mySwiper", {
              spaceBetween: 10,
              slidesPerView: 4,
              freeMode: true,
              watchSlidesProgress: true,
              navigation: {
                  nextEl: ".swiper-button-next",
                  prevEl: ".swiper-button-prev",
              },
          });
          var swiper2 = new Swiper(".mySwiper2", {
              spaceBetween: 10,
              navigation: {
                  nextEl: ".swiper-button-next",
                  prevEl: ".swiper-button-prev",
              },
              thumbs: {
                  swiper: swiper,
              },
          });
          $(document).ready(function(){
              $('.mobile-menu-bar').on('click', function(){
                  var navigation = $('.navigation');
                  navigation.slideToggle();
                  return false;
              });
              $(window).bind('scroll', function () {
                  if ($(window).scrollTop() > 50) {
                      // $('.contact-header').addClass('display-none');
                      $('.header').addClass('background-header');
                      $('.mobile-header').addClass('background-header');

                  } else {
                      // $('.contact-header').removeClass('display-none');
                      $('.header').removeClass('background-header');
                      $('.mobile-header').removeClass('background-header');
                  }
              });
              $('.owl-slide').owlCarousel({
                  loop:true,
                  // margin:10,
                  nav:false,
                  dots:false,
                  autoplay:true,
                  autoplayTimeout:2000,
                  responsive:{
                      0:{
                          items:1
                      },
                      600:{
                          items:1
                      },
                      1000:{
                          items:1
                      }
                  }
              });
              $('.owl-hot-project').owlCarousel({
                  loop:true,
                  margin:10,
                  nav:true,
                  dots:false,
                  autoplay:true,
                  autoplayTimeout:3000,
                  responsive:{
                      0:{
                          items:1
                      },
                      600:{
                          items:3
                      },
                      1000:{
                          items:4
                      }
                  }
              });
              $('.owl-plan').owlCarousel({
                  loop:false,
                  nav:false,
                  dots:false,
                  autoplay:true,
                  autoplayTimeout:3000,
                  responsive:{
                      0:{
                          items:1
                      },
                      600:{
                          items:1
                      },
                      1000:{
                          items:1
                      }
                  }
              });
          });
      </script>
      <script>//<![CDATA[
      $('input.input-qty').each(function() {
        var $this = $(this),
          qty = $this.parent().find('.is-form'),
          min = Number($this.attr('min')),
          max = Number($this.attr('max'))
        if (min == 0) {
          var d = 0
        } else d = min
        $(qty).on('click', function() {
          if ($(this).hasClass('minus')) {
            if (d > min) d += -1
          } else if ($(this).hasClass('plus')) {
            var x = Number($this.val()) + 1
            if (x <= max) d += 1
          }
          $this.attr('value', d).val(d)
        })
      })
      //]]></script>

   
	</body>
</html>
