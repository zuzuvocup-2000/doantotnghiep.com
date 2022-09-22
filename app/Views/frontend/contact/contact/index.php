<div id="contactpage" class="contactpage">
    <div class="uk-container uk-container-center">
        <div class="contact-container">
            <div class="contact-container-head">
                <div class="uk-grid uk-grid-small border-custom">
                    <div class="uk-width-small-1-1 uk-width-medium-3-4">
                        <h1 class="heading-1">Thông tin góp ý - phản hồi của bạn sẽ giúp chúng tôi phục vụ bạn ngày càng tốt hơn</h1>
                        <div class="contact-form">
                            <form id="form" method="post" action="">
                                <div class="input-form">
                                    <div class="form-field">
                                        <div class="col1">Họ tên(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <input type="text" name="fullname" id="name" maxlength="30" placeholder="Nguyễn Văn A" />
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="col1">Email(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <input type="text" name="email" id="email" maxlength="100" placeholder="vidu@yahoo.com" />
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="col1">Điện thoại(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <input type="text" name="phone" id="phone" maxlength="20" placeholder="0976 804 401" />
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="col1">Địa chỉ(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <input type="text" name="address" id="address" maxlength="100" placeholder="330 Nguyễn Xí, Bình Thạnh, Hồ Chí Minh" />
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="col1">Tiêu đề(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <input type="text" name="title" id="title" maxlength="100" />
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="col1">Nội dung(<span class="note">*</span>)</div>
                                        <div class="col2">
                                            <textarea cols="5" name="message" id="content"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-field uk-text-right">
                                        <div class="col button">
                                            <input type="button" id="submit" value="Gửi" onclick="send()" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-1-4">
                        <div class="support">
                            <div class="head">Hỗ trợ trực tuyến</div>
                            <div class="item">
                                <div class="name">Hotline</div>
                                <div class="phone"><?php echo $general['contact_hotline'] ?></div>
                            </div>
                            <div class="item">
                                <div class="name">Email</div>
                                <div class="phone"><?php echo $general['contact_email'] ?></div>
                            </div>
                            <div class="item">
                                <div class="name">Địa chỉ</div>
                                <div class="phone"><?php echo $general['contact_address'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-container-foot">
               <div class="house-bottom-navigation">
                  <?php if(isset($province) && is_array($province) && count($province)){ ?>
                   <ul class="uk-list uk-clearfix">
                      <?php foreach($province as $key => $val){ ?>
                       <li>
                          <a href="<?php echo sell_city_url($val['name'], $val['provinceid']) ?>">Nhà đất <b><?php echo format_city_name($val['name']); ?></b></a>
                       </li>
                       <?php } ?>
                   </ul>
                  <?php } ?>
               </div>

            </div>
        </div>
    </div>
</div>
