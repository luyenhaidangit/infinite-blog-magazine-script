<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $title; ?></h3>
                </div>
                <?php if (hasPermission('add_post')): ?>
                    <div class="right">
                        <div class="dropdown">
                            <button class="btn btn-success btn-add-new dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-plus"></i><?= trans('add_post'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" style="left: -20px;">
                                <li><a href="<?= adminUrl('add-post'); ?>"><?= trans('add_post'); ?></a></li>
                                <li><a href="<?= adminUrl('add-video'); ?>"><?= trans('add_video'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/includes/_filter_posts'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('post'); ?></th>
                            <th><?= trans('post_type'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('author'); ?></th>
                            <th></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (!empty($posts)):
                            foreach ($posts as $item):
                                $lang = getLanguageById($item->lang_id); ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td>
                                        <div class="post-item-table">
                                            <div class="post-image">
                                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?= getPostImage($item, 'small'); ?>" alt="" class="lazyload img-responsive"/>
                                            </div>
                                            <?= esc($item->title); ?>
                                        </div>
                                    </td>
                                    <td><?= trans($item->post_type); ?></td>
                                    <td>
                                        <?php if (!empty($lang)):
                                            echo esc($lang->name);
                                        endif; ?>
                                    </td>
                                    <td>
                                        <?php $categoryArray = getCategoryArray($item->category_id);
                                        if (!empty($categoryArray['parentCategory'])):?>
                                            <label class="label label-table m-r-5 bg-primary">
                                                <?= esc($categoryArray['parentCategory']->name); ?>
                                            </label>
                                        <?php endif;
                                        if (!empty($categoryArray['subcategory'])):?>
                                            <label class="label label-table m-r-5 bg-gray">
                                                <?= esc($categoryArray['subcategory']->name); ?>
                                            </label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $author = getUser($item->user_id);
                                        if (!empty($author)): ?>
                                            <a href="<?= base_url(); ?>/profile/<?= esc($author->slug); ?>" target="_blank" class="table-link">
                                                <strong><?= esc($author->username); ?></strong>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="td-post-sp">
                                        <?php if ($item->visibility == 1): ?>
                                            <label class="label label-success label-table"><i class="fa fa-eye"></i></label>
                                        <?php else: ?>
                                            <label class="label label-danger label-table"><i class="fa fa-eye"></i></label>
                                        <?php endif;
                                        if ($item->is_slider): ?>
                                            <label class="label bg-olive label-table"><?= trans('slider'); ?></label>
                                        <?php endif;
                                        if ($item->is_picked): ?>
                                            <label class="label bg-aqua label-table"><?= trans('our_picks'); ?></label>
                                        <?php endif;
                                        if ($item->need_auth): ?>
                                            <label class="label label-warning label-table"><?= trans('only_registered'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <form action="<?= base_url('Post/postOptionsPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= esc($item->id); ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <?php if (isAdmin()): ?>
                                                        <li>
                                                            <button type="submit" name="option" value="approve" class="btn-list-button">
                                                                <i class="fa fa-check option-icon"></i><?= trans('approve'); ?>
                                                            </button>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?= adminUrl('edit-post/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('Post/deletePost','<?= $item->id; ?>','<?= trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>

                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                            <?php if (itemCount($posts) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedPosts('<?= trans("confirm_posts"); ?>');"><?= trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>