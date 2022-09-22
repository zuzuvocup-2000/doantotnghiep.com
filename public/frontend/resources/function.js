(function($) {
	"use strict";
	var HT = {}; // Khai báo là 1 đối tượng

	/* MAIN VARIABLE */

	var $window = $(window),
	    $document = $(document),
		$carousel = $(".owl-slide");


	    // FUNCTION DECLARGE
	    $.fn.elExists = function() {
	        return this.length > 0;
	    };


      HT.triggerChangeCityAndDistrict = () => {
         if(typeof(cityid) != 'undefined' && cityid != ''){
            $('#city').val(cityid).trigger('change', [{'trigger':true}]);
            HT.changeCity(123);
         }
      }

      HT.changeCity = (param) => {
         $(document).on('change', '#city', function(e, data){
            let _this = $(this);
            let id = _this.val();
            let param = {
               'id' : id,
               'text' : '[Chọn Quận/Huyện]',
               'table' : 'vn_district',
               'trigger_district': (typeof(data) != 'undefined') ? true : false,
               'where' : {'provinceid' : id},
               'select' : 'districtid as id, name',
               'object' : '#district',
            };
            HT.getLocation(param);
         });
      }

      HT.changeDistrict = () => {
         $(document).on('change', '#district', function(){
            let _this = $(this);
            let id = _this.val();
            let param = {
               'id' : id,
               'text' : '[Chọn Phường/Xã]',
               'table' : 'vn_ward',
               'where' : {'districtid' : id},
               'select' : 'wardid as id, name',
               'object' : '#ward',
            };
            HT.getLocation(param);
         });
      }


      HT.convert_price = () => {
         $(document).ready(function(){
            $('.int').trigger('change')
         })

         $(document).on('click','.float, .int',function(){
            let data = $(this).val();
            if(data == 0){
               $(this).val('');
            }
         });
         $(document).on('keydown','.float, .int',function(e){
            let data = $(this).val();
            if(data == 0){
               let unicode=e.keyCode || e.which;
               if(unicode != 190){
                  $(this).val('');
               }
            }
         });

         $(document).on('change keyup blur','.int',function(){
            let data = $(this).val();
            if(data == '' ){
               $(this).val('0');
               return false;
            }
            data = data.replace(/\./gi, "");
            $(this).val(addCommas(data));
            data = data.replace(/\./gi, "");
            if(isNaN(data)){
               $(this).val('0');
               return false;
            }
         });
      }

      HT.getLocation = (param) => {
         if(districtid == '' || param.trigger_district == false) districtid = 0;
         if(wardid == ''  || param.trigger_ward == false) wardid = 0;

         let formURL = 'ajax/dashboard/get_location';
         $.post(formURL, {
            param: param},
            function(data){
               let json = JSON.parse(data);
               if(param.object == '#district'){
                  $(param.object).html(json.html).val(districtid).trigger('change');
               }else if(param.object == '#ward'){
                  $(param.object).html(json.html).val(wardid);
               }

            });
      }



	    // Document ready functions
	    $document.on('ready', function() {
	    	// HT.triggerChangeCityAndDistrict();
	    	// HT.changeCity();
    	   HT.convert_price();
	    });

})(jQuery);

$(document).ready(function(){



   $(document).on('change', '#city', function(e, data){
      console.log(12);
      let _this = $(this);
      let id = _this.val();
      let param = {
         'id' : id,
         'text' : '[Chọn Quận/Huyện]',
         'table' : 'vn_district',
         'trigger_district': (typeof(data) != 'undefined') ? true : false,
         'where' : {'provinceid' : id},
         'select' : 'districtid as id, name',
         'object' : '#district',
      };
      getLocation(param);
   });

   if(typeof(cityid) != 'undefined' && cityid != ''){
      $('#city').val(cityid).trigger('change', [{'trigger':true}]);
      // HT.changeCity(123);
   }

   $(document).on('change', '#district', function(){
      let _this = $(this);
      let id = _this.val();
      let param = {
         'id' : id,
         'text' : '[Chọn Phường/Xã]',
         'table' : 'vn_ward',
         'where' : {'districtid' : id},
         'select' : 'wardid as id, name',
         'object' : '#ward',
      };
      getLocation(param);
   });


   $(document).on('change', '#city_2', function(e, data){
      console.log(12);
      let _this = $(this);
      let id = _this.val();
      let param = {
         'id' : id,
         'text' : '[Chọn Quận/Huyện]',
         'table' : 'vn_district',
         'trigger_district': (typeof(data) != 'undefined') ? true : false,
         'where' : {'provinceid' : id},
         'select' : 'districtid as id, name',
         'object' : '#district_2',
      };
      getLocation_2(param);
   });
});

function getLocation_2(param){
   if(districtid == '' || param.trigger_district == false) districtid = 0;
   if(wardid == ''  || param.trigger_ward == false) wardid = 0;

   let formURL = 'ajax/dashboard/get_location';
   $.post(formURL, {
      param: param},
      function(data){
         let json = JSON.parse(data);
         if(param.object == '#district_2'){
            $(param.object).html(json.html).val(districtid).trigger('change');
         }else if(param.object == '#ward'){
            $(param.object).html(json.html).val(wardid);
         }

      });
}


function getLocation(param){
   if(districtid == '' || param.trigger_district == false) districtid = 0;
   if(wardid == ''  || param.trigger_ward == false) wardid = 0;

   let formURL = 'ajax/dashboard/get_location';
   $.post(formURL, {
      param: param},
      function(data){
         let json = JSON.parse(data);
         if(param.object == '#district'){
            $(param.object).html(json.html).val(districtid).trigger('change');
         }else if(param.object == '#ward'){
            $(param.object).html(json.html).val(wardid);
         }

      });
}

function addCommas(nStr){
   nStr = String(nStr);
   nStr = nStr.replace(/\./gi, "");
   let str ='';
   for (i = nStr.length; i > 0; i -= 3){
      a = ( (i-3) < 0 ) ? 0 : (i-3); 
      str= nStr.slice(a,i) + '.' + str; 
   }
   str= str.slice(0,str.length-1); 
   return str;
}

const editors = {};
function ckeditor5(elementId){
    CKEDITOR.replace( elementId, {
            height: 250,
            removeButtons: '',
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'forms' },
                { name: 'tools' },
                { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'colors' },
                { name: 'others' },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'styles' }
            ],
        });
}

$('.ck-editor').each(function(){
   ckeditor5($(this).attr('id'));
});