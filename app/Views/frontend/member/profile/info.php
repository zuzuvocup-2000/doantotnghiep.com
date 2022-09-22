<div id="infopage" class="infopage">
    <div class="uk-container uk-container-center">
        <div class="info-container">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-small-1-1 uk-width-medium-3-4">
                    <div class="content-box">
                       	<?php echo  (!empty($validate) && isset($validate)) ? '<div class="uk-alert uk-alert-danger">'.$validate.'</div>'  : '' ?>
                        <form class="user-infor-form" action="" method="post">
                            <div class="contact-infor">
                                <div class="user-infor-title">Thông tin liên hệ</div>
                                <table cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Tên liên hệ:
                                            </td>
                                            <td>
                                                <input name="fullname" type="text" id="fullname" class="fullname" maxlength="45" value="<?php echo $member['fullname'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Email liên hệ:
                                            </td>
                                            <td>
                                                <input name="email" type="text" id="email1" class="email1" maxlength="50" value="<?php echo $member['email'] ?>" />
                                                <input name="email_original" type="hidden" class="email1" maxlength="50" value="<?php echo $member['email'] ?>" />
                                            </td>
                                        </tr>
                                        <script>
                                           var cityid = '<?php echo (isset($_POST['city_id'])) ? $_POST['city_id'] : $member['cityid']; ?>';
                                           var districtid = '<?php echo (isset($_POST['district_id'])) ? $_POST['district_id'] : $member['districtid']; ?>'
                                           var wardid = ''
                                        </script>
                                        <tr>
                                            <td>
                                                Tỉnh/Thành phố:
                                            </td>
                                            <td>
                                                 <?php echo form_dropdown('cityid', $province, set_value('city_id'), 'id="city" class="tinh"');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Quận/Huyện:
                                            </td>
                                            <td>
                                                <?php echo form_dropdown('districtid', ['Chọn Quận/Huyện'], set_value('district_id'), 'class="demand" id="district"');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Di dộng:
                                            </td>
                                            <td>
                                                <input name="phone" type="text" id="phone1" class="phone1" maxlength="12" value="<?php echo $member['phone'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Loại tài khoản:
                                            </td>
                                            <td>
                                                <div class="uk-flex uk-flex-middle ml10">
                                                   <div class="uk-flex uk-flex-middle mr10">
                                                      <input value="1" name="catalogueid" type="radio" id="agent1" class="agent" style="width: 16px; height: 16px;" <?php echo ($member['catalogueid'] == 1) ? 'checked' : '' ?> /> <span>Cá nhân </span>
                                                   </div>
                                                   <div class="uk-flex uk-flex-middle">
                                                      <input value="2" name="catalogueid" type="radio" id="agent2" class="agent" <?php echo ($member['catalogueid'] == 2) ? 'checked' : '' ?> style="width: 16px; height: 16px;" />
                                                      <span>Nhà môi giới</span>
                                                   </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="btn-group mt20 uk-text-center">
                                    <button type="submit" value="update" name="update" class="btn-update">Cập nhật</button>
                                    <button class="btn-back">Trở lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-4">
                    <?php echo view(convertUrl('frontend.member.profile.include.aside')) ?>
                </div>
            </div>
        </div>
    </div>
</div>
