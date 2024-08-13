
<?php $__env->startSection('title'); ?>
    <?php echo e($module_name); ?>

<?php $__env->stopSection(); ?>
<?php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }

?>
<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo e($module_name); ?>

            
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if(session('errorMessage')): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e(session('errorMessage')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('successMessage')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e(session('successMessage')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        <?php endif; ?>


        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->get('Update form'); ?></h3>
                <?php if(isset($languages)): ?>
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item->is_default == 1 && $item->lang_locale != Request::get('lang')): ?>
                            <?php if(Request::get('lang') != ''): ?>
                                <a class="text-primary pull-right"
                                    href="<?php echo e(route(Request::segment(2) . '.edit', $detail->id)); ?>" style="padding-left: 15px">
                                    <i class="fa fa-language"></i> <?php echo e(__($item->lang_name)); ?>

                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(Request::get('lang') != $item->lang_locale): ?>
                                <a class="text-primary pull-right"
                                    href="<?php echo e(route(Request::segment(2) . '.edit', $detail->id)); ?>?lang=<?php echo e($item->lang_locale); ?>"
                                    style="padding-left: 15px">
                                    <i class="fa fa-language"></i> <?php echo e(__($item->lang_name)); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-block" role="form" action="<?php echo e(route(Request::segment(2) . '.update', $detail->id)); ?>"
                method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <?php if(Request::get('lang') != '' && Request::get('lang') != $item->lang_locale): ?>
                    <input type="hidden" name="lang" value="<?php echo e(Request::get('lang')); ?>">
                <?php endif; ?>
                <input type="hidden" name="parent_id" value="<?php echo e($detail->parent_id??''); ?>">
                <input type="hidden" name="block_code" value="<?php echo e($detail->block_code??''); ?>">

                <div class="box-body">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    <h5>
                                        <?php echo app('translator')->get('General information'); ?>
                                        <span class="text-danger">*</span>
                                    </h5>
                                </a>
                            </li>
                            </li>

                            <button type="submit" class="btn btn-primary btn-sm pull-right">
                                <i class="fa fa-floppy-o"></i>
                                <?php echo app('translator')->get('Save'); ?>
                            </button>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1">
                                <div class="d-flex-wap">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>
                                                <?php echo app('translator')->get('Title'); ?>
                                                <small class="text-red">*</small>
                                            </label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="<?php echo app('translator')->get('Title'); ?>"
                                                value="<?php echo e(old('title') ?? ($detail->json_params->title->$lang ?? $detail->title)); ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Status'); ?></label>
                                            <div class="form-control">
                                                <?php $__currentLoopData = App\Consts::STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <input type="radio" name="status" value="<?php echo e($value); ?>"
                                                            <?php echo e($detail->status == $value ? 'checked' : ''); ?>>
                                                        <small class="mr-15"><?php echo e(__($value)); ?></small>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Layout'); ?></label>
                                            <select name="json_params[layout]" id="block_layout"
                                                class="form-control select2" style="width: 100%">
                                                <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                                <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($item->block_code == $detail->block_code): ?>
                                                        <?php
                                                            $json_params = json_decode($item->json_params);
                                                        ?>
                                                        <?php if(isset($json_params->layout)): ?>
                                                            <?php $__currentLoopData = $json_params->layout; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value); ?>"
                                                                    <?php echo e(isset($detail->json_params->layout) && $value == $detail->json_params->layout ? 'selected' : ''); ?>>
                                                                    <?php echo e(__($value)); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Style'); ?></label>
                                            <select name="json_params[style]" id="block_style" class="form-control select2"
                                                style="width: 100%">
                                                <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                                <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($item->block_code == $detail->block_code): ?>
                                                        <?php
                                                            $json_params = json_decode($item->json_params);
                                                        ?>
                                                        <?php if(isset($json_params->style)): ?>
                                                            <?php $__currentLoopData = $json_params->style; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value); ?>"
                                                                    <?php echo e(isset($detail->json_params->style) && $value == $detail->json_params->style ? 'selected' : ''); ?>>
                                                                    <?php echo e(__($value)); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Brief'); ?></label>
                                            <textarea name="json_params[brief][<?php echo e($lang); ?>]" id="brief" class="form-control" rows="5"><?php echo e(old('json_params[brief][' . $lang . ']') ?? ($detail->json_params->brief->{$lang} ?? $detail->brief)); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Content'); ?></label>
                                            <textarea name="json_params[content][<?php echo e($lang); ?>]" id="content" class="form-control" rows="5"><?php echo e(old('json_params[content][' . $lang . ']') ?? ($detail->json_params->content->{$lang} ?? $detail->content)); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Url redirect'); ?></label>
                                            <input type="text" class="form-control" name="url_link"
                                                placeholder="<?php echo app('translator')->get('Url redirect'); ?>"
                                                value="<?php echo e(old('url_link') ?? $detail->url_link); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Url redirect title'); ?></label>
                                            <input type="text" class="form-control" name="url_link_title"
                                                placeholder="<?php echo app('translator')->get('Url redirect title'); ?>"
                                                value="<?php echo e(old('url_link_title') ?? ( $detail->json_params->url_link_title->$lang??$detail->url_link_title)); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Order'); ?></label>
                                            <input type="number" class="form-control" name="iorder"
                                                placeholder="<?php echo app('translator')->get('Order'); ?>"
                                                value="<?php echo e(old('iorder') ?? $detail->iorder); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Icon'); ?></label>
                                            <input type="text" class="form-control" name="icon"
                                                placeholder="Ex: fa fa-folder"
                                                value="<?php echo e(old('icon') ?? $detail->icon); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Image'); ?></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="image-holder"
                                                        class="btn btn-primary lfm" data-type="cms-image">
                                                        <i class="fa fa-picture-o"></i> <?php echo app('translator')->get('Select'); ?>
                                                    </a>
                                                </span>
                                                <input id="image" class="form-control" type="text" name="image"
                                                    placeholder="<?php echo app('translator')->get('Image source'); ?>" value="<?php echo e($detail->image); ?>">
                                            </div>
                                            <div id="image-holder" style="margin-top:15px;max-height:100px;">
                                                <?php if($detail->image != ''): ?>
                                                    <img style="height: 5rem;" src="<?php echo e($detail->image); ?>">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Background image'); ?></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image_background"
                                                        data-preview="image_background-holder" data-type="cms-image"
                                                        class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i> <?php echo app('translator')->get('Select'); ?>
                                                    </a>
                                                </span>
                                                <input id="image_background" class="form-control" type="text"
                                                    name="image_background" placeholder="<?php echo app('translator')->get('Image source'); ?>"
                                                    value="<?php echo e($detail->image_background); ?>">
                                            </div>
                                            <div id="image_background-holder" style="margin-top:15px;max-height:100px;">
                                                <?php if($detail->image_background != ''): ?>
                                                    <img style="height: 5rem;" src="<?php echo e($detail->image_background); ?>">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    
                    <button type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-floppy-o"></i>
                        <?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div>



    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#block_code', function() {
                let block_code = $(this).val();
                var _targetLayout = $(this).parents('.form-block').find('#block_layout');
                var _targetStyle = $(this).parents('.form-block').find('#block_style');
                _targetLayout.html('');
                _targetStyle.html('');
                var url = "<?php echo e(route('blocks.params')); ?>/";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        "block_code": block_code,
                    },
                    success: function(response) {
                        var _optionListLayout = '<option value=""><?php echo app('translator')->get('Please select'); ?></option>';
                        var _optionListStyle = '<option value=""><?php echo app('translator')->get('Please select'); ?></option>';
                        if (response.data != null) {
                            let json_params = JSON.parse(response.data);
                            if (json_params.hasOwnProperty('layout')) {
                                Object.entries(json_params.layout).forEach(([key, value]) => {
                                    _optionListLayout += '<option value="' + value +
                                        '"> ' + value + ' </option>';
                                });
                            }
                            _targetLayout.html(_optionListLayout);
                            if (json_params.hasOwnProperty('style')) {
                                Object.entries(json_params.style).forEach(([key, value]) => {
                                    _optionListStyle += '<option value="' + value +
                                        '"> ' + value + ' </option>';
                                });
                            }
                            _targetStyle.html(_optionListStyle);
                        }
                        $(".select2").select2();
                    },
                    error: function(response) {
                        // Get errors
                        var errors = response.responseJSON.message;
                        console.log(errors);
                    }
                });
            });
        });
        $('#menu-sort').nestable({
            group: 0,
            maxDepth: 3,
        });
        $('.menu-sort-save').click(function() {
            $('#loading').show();
            let serialize = $('#menu-sort').nestable('serialize');
            let menu = JSON.stringify(serialize);
            $.ajax({
                    url: '<?php echo e(route('blocks.update_sort')); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        menu: menu,
                        root_id: '<?php echo e($detail->id ?? "0"); ?>',
                    },
                })
                .done(function(data) {
                    $('#loading').hide();
                    if (data.error == 0) {
                        // alert('Cập nhật thành công');
                        location.reload();
                    } else {
                        // alert("Cập nhật thất bại");
                        location.reload();
                    }
                });
        });
        $('.remove_menu').click(function() {
            if (confirm("<?php echo app('translator')->get('confirm_action'); ?>")) {
                let _root = $(this).closest('.dd-item');
                let id = $(this).data('id');
                $.ajax({
                    method: 'post',
                    url: '<?php echo e(route('block.delete')); ?>',
                    data: {
                        id: id,
                        _token: '<?php echo e(csrf_token()); ?>',
                    },
                    success: function(data) {
                        if (data.error == 1) {
                            alert(data.msg);
                        } else {
                            _root.remove();
                        }
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\flavor-fusion\resources\views/admin/pages/block_contents/edit/cms_product.blade.php ENDPATH**/ ?>