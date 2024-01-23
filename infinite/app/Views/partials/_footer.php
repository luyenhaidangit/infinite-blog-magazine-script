<?= view('partials/_json_ld'); ?>
<footer id="footer">
    <div class="container">
        <div class="row footer-widgets">
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-about">
                    <div class="col-sm-12">
                        <div class="row">
                            <h4 class="title"><?= trans("about"); ?></h4>
                            <div class="title-line"></div>
                            <p><?= esc($settings->about_footer); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <?= view('partials/_footer_latest_posts'); ?>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="footer-widget f-widget-follow">
                            <div class="col-sm-12">
                                <div class="row">
                                    <h4 class="title"><?= trans("social_media"); ?></h4>
                                    <div class="title-line"></div>
                                    <ul>
                                        <?php $socialArray = getSocialLinksArray($settings);
                                        foreach ($socialArray as $item):
                                            if (!empty($item['value'])):?>
                                                <li><a class="<?= $item['name']; ?>" href="<?= esc($item['value']); ?>" target="_blank" aria-label="<?= $item['name']; ?>"><i class="icon-<?= $item['name']; ?>"></i></a></li>
                                            <?php endif; endforeach;
                                        if ($generalSettings->show_rss == 1) : ?>
                                            <li><a class="rss" href="<?= langBaseUrl('rss-feeds'); ?>" aria-label="rss"><i class="icon-rss"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($generalSettings->newsletter_status == 1): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="widget-newsletter">
                                <p><?= trans("newsletter_exp"); ?></p>
                                <form id="form_newsletter_footer" class="form-newsletter">
                                    <div class="newsletter">
                                        <input type="email" name="email" class="newsletter-input" maxlength="199" placeholder="<?= trans("email"); ?>">
                                        <button type="submit" name="submit" value="form" class="newsletter-button" aria-label="subscribe"><?= trans("subscribe"); ?></button>
                                    </div>
                                    <input type="text" name="url">
                                    <div id="form_newsletter_response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?= $settings->copyright; ?></p>
                    </div>
                    <div class="footer-bottom-right">
                        <ul class="nav-footer">
                            <?php if (!empty($menuLinks)):
                                foreach ($menuLinks as $item):
                                    if ($item->item_location == "footer"):?>
                                        <li><a href="<?= generateMenuItemUrl($item); ?>"><?= esc($item->item_name); ?> </a></li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php if (empty(helperGetCookie('cks_warning')) && $settings->cookies_warning): ?>
    <div class="cookies-warning">
        <button type="button" aria-label="close" class="close" onclick="closeCookiesWarning();">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </button>
        <div class="text">
            <?= $settings->cookies_warning_text; ?>
        </div>
        <button type="button" class="btn btn-md btn-custom" onclick="closeCookiesWarning();"><?= trans("accept_cookies"); ?></button>
    </div>
<?php endif; ?>
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>
<script src="<?= base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/slick/slick.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/plugins-4.4.js'); ?>"></script>
<script src="<?= base_url('assets/js/script-4.4.min.js'); ?>"></script>
<script>$('<input>').attr({type: 'hidden', name: 'lang', value: InfConfig.sysLangId}).appendTo('form');</script>
<?php if (checkNewsletterModal()): ?>
    <script>$(window).on('load', function () {
            $('#modal_newsletter').modal('show');
        });</script>
<?php endif; ?>
<?= view('partials/_js_footer'); ?>
<?= $generalSettings->google_analytics; ?>
<?= $generalSettings->custom_footer_codes; ?>
</body>
</html>
<?php if (!empty($isPage404)): exit(); endif; ?>