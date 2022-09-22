<ul class="manage-menu">
   <li>
       <span>Quản lý tin đăng</span>
       <ul class="property-management">
            <li url="/publish/handler/Handler.ashx?command=1&amp;status=1" class="">
               Tin đã duyệt <span id="ctl00_content_approved">(<b> 0 </b>)</span>
            </li>
            <li url="/publish/handler/Handler.ashx?command=1&amp;status=0" class="">
               Tin chờ duyệt <span id="ctl00_content_hold">(<b> 0 </b>)</span>
            </li>
            <li url="/publish/handler/Handler.ashx?command=1&amp;status=2" class="">
               Tin không được duyệt <span id="ctl00_content_unapprove">(<b> 0 </b>)</span>
            </li>
            <li url="/publish/handler/Handler.ashx?command=1&amp;status=4" class="">
               Tin tạm dừng đăng <span id="ctl00_content_stoppublish">(<b> 0 </b>)</span>
            </li>
            <li url="/publish/handler/Handler.ashx?command=1&amp;status=5" class="selected">
               Tin hết hạn <span id="ctl00_content_expired">(<b> 0 </b>)</span>
            </li>
       </ul>
   </li>
   <li>
       <span>Tiện ích</span>
       <ul class="utils-management">
            <li url="">Số dư/ Lịch sử giao dịch</li>
            <li style="display: none;" url="/publish/form/MobileCardForm.aspx">Nạp tiền vào tài khoản <img src="/publish/img/gold.gif" /></li>

            <li url="">Mua lượt <b>Up</b> tin <img src="public/frontend/resources/img/buyup.gif" /></li>
       </ul>
   </li>
   <li>
       <span>Tài khoản cá nhân</span>
       <ul class="personality-management">
            <li><a href="<?php echo write_url('member/info') ?>" style="color:#000">Thông tin tài khoản</a></li>
            <li ><a href="<?php echo write_url('member/changePassword') ?>" style="color:#000">Thay đổi mật khẩu</a></li>
       </ul>
   </li>
</ul>
