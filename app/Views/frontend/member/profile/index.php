<div id="rulespage" class="userpage">
    <div class="uk-container uk-container-center">
        <div class="rules-container">
            <h1 class="heading-1"><span>Quy định đăng tin trên website <?php echo $general['contact_website'] ?></span></h1>
            <article>
                <p>
                    <style type="text/css">
                        .quydinh {
                            padding: 5px;
                        }
                        .quydinh .title {
                            font-size: 16px;
                            font-weight: bold;
                            margin-bottom: 20px;
                        }
                        .quydinh ul li {
                            line-height: 22px;
                            list-style: decimal;
                        }
                        .quydinh .child li {
                            list-style: lower-alpha;
                            color: Red;
                        }
                    </style>
                </p>
               <div class="uk-grid uk-grid-medium">
                  <div class="uk-width-large-3-4">
                     <div class="quydinh">
                        <?php echo $general['homepage_general']; ?>
                     </div>
                  </div>
                  <div class="uk-width-large-1-4">
                     <?php echo view('frontend/member/profile/include/aside') ?>
                  </div>
               </div>
            </article>

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
