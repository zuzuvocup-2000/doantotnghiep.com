<?php
    helper('form');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
    $languageList = get_list_language(['currentLanguage' => $language]);

?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2><?php echo translate('cms_lang.slide.Manage', $language) ?></h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><?php echo translate('cms_lang.slide.slide_home', $language) ?></a>
         </li>
         <li class="active"><strong><?php echo translate('cms_lang.slide.Manage2', $language) ?></strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo translate('cms_lang.slide.Manage2', $language) ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="delete-all"><?php echo translate('cms_lang.slide.delete_all', $language) ?></a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="30">30 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="40">40 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="50">50 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="60">60 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="70">70 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="80">80 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="90">90 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                        <option value="100">100 <?php echo translate('cms_lang.slide.Record2', $language) ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10 ml10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="<?php echo translate('cms_lang.slide.tourjet_placeholder', $language) ?>" class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm"><?php echo translate('cms_lang.slide.Search1', $language) ?>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/slide/slide/create') ?>" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> <?php echo translate('cms_lang.slide.NewSlide', $language) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th ><?php echo translate('cms_lang.slide.SlideGruopName', $language) ?></th>
                            <th ><?php echo translate('cms_lang.slide.Code', $language) ?></th>
                            <th class="text-center" style="width:103px;"><?php echo translate('cms_lang.slide.Manipulation1', $language) ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($slideList) && is_array($slideList) && count($slideList)){ ?>
                            <?php foreach($slideList as $key => $val){ ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td class=" td-status" data-module="<?php echo $module; ?>" data-where="id"><?php echo isset($val['title'])? $val['title'] : ''; ?></td>
                                <td class=" td-status"  data-module="<?php echo $module; ?>" data-where="id">
                                    <a href="<?php echo base_url('backend/slide/slide/update/'.$val['id'].'') ?>"><?php echo isset($val['keyword'])? $val['keyword'] : ''; ?></a></td>
                                <td class="text-center">
                                    <a type="button" href="<?php echo base_url('backend/slide/slide/update/'.$val['id']) ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo base_url('backend/slide/slide/delete/'.$val['id']) ?>" class="btn js-btn-delete btn-danger" data-id="<?php echo $val['id'] ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger"><?php echo translate('cms_lang.slide.empty', $language) ?></span></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
