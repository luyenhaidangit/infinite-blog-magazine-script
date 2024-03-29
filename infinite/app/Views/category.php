<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <?php if (!empty($categoryArray['subcategory']) && !empty($categoryArray['parentCategory'])):?>
                        <li class="breadcrumb-item">
                            <a href="<?= generateCategoryUrl(null, $categoryArray['parentCategory']->slug); ?>"><?= esc($categoryArray['parentCategory']->name); ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <?= esc($categoryArray['subcategory']->name); ?>
                        </li>
                    <?php else:
                        if (!empty($categoryArray['parentCategory'])):?>
                            <li class="breadcrumb-item active">
                                <?= esc($categoryArray['parentCategory']->name); ?>
                            </li>
                        <?php endif;
                    endif; ?>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="content">
                    <h1 class="page-title"> <?= trans("category"); ?>: <?= esc($category->name); ?></h1>
                    <div class="col-xs-12 col-sm-12 posts <?= $generalSettings->layout == "layout_3" || $generalSettings->layout == "layout_6" ? 'p-0 posts-boxed' : ''; ?>">
                        <div class="row">
                            <?php $count = 0;
                            foreach ($posts as $item):
                                if ($count != 0 && $count % 2 == 0): ?>
                                    <div class="col-sm-12 col-xs-12"></div>
                                <?php endif;
                                echo view('post/_post_item', ['item' => $item]); ?>
                                <?php if ($count == 1):
                                echo view('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'm-b-30']);
                            endif;
                                $count++;
                            endforeach; ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="row">
                            <?= view('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => 'm-b-30']); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="row">
                            <?= $pager->links; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <?= view('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</section>


