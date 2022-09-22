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
                                                <input name="fullname" type="text" id="fullname" class="fullname" maxlength="45" disabled value="<?php echo $member['fullname'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Email liên hệ:
                                            </td>
                                            <td>
                                                <input disabled name="email" type="text" id="email1" class="email1" maxlength="50" value="<?php echo $member['email'] ?>" />
                                                <input name="email_original" type="hidden" class="email1" maxlength="50" value="<?php echo $member['email'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Mật khẩu mới:
                                            </td>
                                            <td>
                                                <input name="password" type="password" class="password"  value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Nhập lại Mật khẩu mới:
                                            </td>
                                            <td>
                                                <input name="re_password" type="password" class="re_password" value="" />
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="btn-group mt20 uk-text-center">
                                    <button type="submit" value="update" name="update" class="btn-update">Cập nhật</button>
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
