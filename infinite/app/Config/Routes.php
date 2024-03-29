<?php

use CodeIgniter\Router\RouteCollection;
use Config\Globals;

$languages = Globals::$languages;
$generalSettings = Globals::$generalSettings;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->post('contact-post', 'HomeController::contactPost');
$routes->post('edit-profile-post', 'ProfileController::editProfilePost');
$routes->post('social-accounts-post', 'ProfileController::socialAccountsPost');
$routes->post('change-password-post', 'ProfileController::changePasswordPost');
$routes->post('follow-unfollow-user', 'ProfileController::followUnfollowUser');
$routes->post('add-remove-reading-list-post', 'HomeController::addRemoveFromReadingListPost');
$routes->post('download-file', 'HomeController::downloadFile');
$routes->post('add-reaction-post', 'HomeController::addReactionPost');
$routes->post('add-comment-post', 'HomeController::addCommentPost');
$routes->post('load-subcomment-post', 'HomeController::loadSubcommentBox');
$routes->post('delete-comment-post', 'HomeController::deleteCommentPost');
$routes->post('load-more-comment', 'HomeController::loadMoreCommentPost');
$routes->post('close-cookies-warning-post', 'HomeController::closeCookiesWarningPost');
$routes->post('add-poll-vote-post', 'HomeController::addPollVotePost');
$routes->post('add-to-newsletter-post', 'HomeController::addToNewsletterPost');

/*
 * --------------------------------------------------------------------
 * Auth Routes
 * --------------------------------------------------------------------
 */

$routes->post('login-post', 'AuthController::loginPost');
$routes->post('register-post', 'AuthController::registerPost');
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password-post', 'AuthController::forgotPasswordPost');
$routes->get('reset-password', 'AuthController::resetPassword');
$routes->post('reset-password-post', 'AuthController::resetPasswordPost');
$routes->get('connect-with-facebook', 'AuthController::connectWithFacebook');
$routes->get('facebook-callback', 'AuthController::facebookCallback');
$routes->get('connect-with-google', 'AuthController::connectWithGoogle');

/*
 * --------------------------------------------------------------------
 * Common Routes
 * --------------------------------------------------------------------
 */

$routes->post('inf-switch-mode', 'CommonController::switchMode');

/*
 * --------------------------------------------------------------------
 * Cron Routes
 * --------------------------------------------------------------------
 */

$routes->get('cron/update-sitemap', 'CronController::updateSitemap');
$routes->get('cron/update-feeds', 'CronController::checkFeedPosts');

/*
 * --------------------------------------------------------------------
 * Admin Routes
 * --------------------------------------------------------------------
 */

$rAdmin = $generalSettings->admin_route;
$routes->get($rAdmin, 'AdminController::index');
$routes->get($rAdmin . '/login', 'CommonController::adminLogin');
$routes->post($rAdmin . '/login-post', 'CommonController::adminLoginPost');
$routes->get($rAdmin . '/themes', 'AdminController::themes');
$routes->get($rAdmin . '/navigation', 'AdminController::navigation');
$routes->get($rAdmin . '/edit-menu-link/(:num)', 'AdminController::editMenuLink/$1');
$routes->get($rAdmin . '/add-page', 'AdminController::addPage');
$routes->get($rAdmin . '/pages', 'AdminController::pages');
$routes->get($rAdmin . '/edit-page/(:num)', 'AdminController::editPage/$1');
//post
$routes->get($rAdmin . '/add-post', 'PostController::addPost');
$routes->get($rAdmin . '/edit-post/(:num)', 'PostController::editPost/$1');
$routes->get($rAdmin . '/add-video', 'PostController::addVideo');
$routes->get($rAdmin . '/posts', 'PostController::posts');
$routes->get($rAdmin . '/slider-posts', 'PostController::sliderPosts');
$routes->get($rAdmin . '/our-picks', 'PostController::ourPicks');
$routes->get($rAdmin . '/pending-posts', 'PostController::pendingPosts');
$routes->get($rAdmin . '/drafts', 'PostController::drafts');
$routes->get($rAdmin . '/auto-post-deletion', 'PostController::autoPostDeletion');
//rss feeds
$routes->get($rAdmin . '/import-feed', 'RssController::importFeed');
$routes->get($rAdmin . '/feeds', 'RssController::rssFeeds');
$routes->get($rAdmin . '/edit-feed/(:num)', 'RssController::editFeed/$1');
//categorry
$routes->get($rAdmin . '/categories', 'CategoryController::categories');
$routes->get($rAdmin . '/edit-category/(:num)', 'CategoryController::editCategory/$1');
$routes->get($rAdmin . '/edit-subcategory/(:num)', 'CategoryController::editSubcategory/$1');
$routes->get($rAdmin . '/subcategories', 'CategoryController::subcategories');
//gallery
$routes->get($rAdmin . '/gallery', 'GalleryController::gallery');
$routes->get($rAdmin . '/edit-gallery-image/(:num)', 'GalleryController::editGalleryImage/$1');
$routes->get($rAdmin . '/gallery-albums', 'GalleryController::galleryAlbums');
$routes->get($rAdmin . '/edit-gallery-album/(:num)', 'GalleryController::editGalleryAlbum/$1');
$routes->get($rAdmin . '/gallery-categories', 'GalleryController::galleryCategories');
$routes->get($rAdmin . '/edit-gallery-category/(:num)', 'GalleryController::editGallerCategory/$1');
//comments
$routes->get($rAdmin . '/comments', 'AdminController::comments');
$routes->get($rAdmin . '/pending-comments', 'AdminController::pendingComments');
//poll
$routes->get($rAdmin . '/add-poll', 'AdminController::addPoll');
$routes->get($rAdmin . '/add-poll-post', 'AdminController::addPollPost');
$routes->get($rAdmin . '/polls', 'AdminController::polls');
$routes->get($rAdmin . '/edit-poll/(:num)', 'AdminController::editPoll/$1');
//seo tools
$routes->get($rAdmin . '/seo-tools', 'AdminController::seoTools');
//cache
$routes->get($rAdmin . '/cache-system', 'AdminController::cacheSystem');
$routes->get($rAdmin . '/contact-messages', 'AdminController::contactMessages');
//newsletter
$routes->get($rAdmin . '/newsletter', 'AdminController::newsletter');
$routes->get($rAdmin . '/newsletter-send-email', 'AdminController::newsletterSendEmail');
//users
$routes->get($rAdmin . '/users', 'AdminController::users');
$routes->get($rAdmin . '/add-user', 'AdminController::addUser');
$routes->get($rAdmin . '/edit-user/(:num)', 'AdminController::editUser/$1');
$routes->get($rAdmin . '/roles-permissions', 'AdminController::rolesPermissions');
$routes->get($rAdmin . '/add-role', 'AdminController::addRole');
$routes->get($rAdmin . '/edit-role/(:num)', 'AdminController::editRole/$1');
//settings
$routes->get($rAdmin . '/storage', 'AdminController::storage');
$routes->get($rAdmin . '/social-login-settings', 'AdminController::socialLoginSettings');
$routes->get($rAdmin . '/ad-spaces', 'AdminController::adSpaces');
$routes->get($rAdmin . '/preferences', 'AdminController::preferences');
$routes->get($rAdmin . '/settings', 'AdminController::settings');
$routes->get($rAdmin . '/font-settings', 'AdminController::fontSettings');
$routes->get($rAdmin . '/edit-font/(:num)', 'AdminController::editFont/$1');
$routes->get($rAdmin . '/language-settings', 'LanguageController::languageSettings');
$routes->get($rAdmin . '/edit-language/(:num)', 'LanguageController::editLanguage/$1');
$routes->get($rAdmin . '/translations/(:num)', 'LanguageController::translations/$1');
$routes->get($rAdmin . '/email-settings', 'AdminController::emailSettings');

/*
 * --------------------------------------------------------------------
 * Static POST Routes
 * --------------------------------------------------------------------
 */

$postRoutesArray = [
    //Admin
    'Admin/adSpacesPost',
    'Admin/googleAdsenseCodePost',
    'Admin/cacheSystemPost',
    'Admin/approveCommentPost',
    'Admin/deleteCommentPost',
    'Admin/deleteContactMessagePost',
    'Admin/emailSettingsPost',
    'Admin/emailOptionsPost',
    'Admin/sendTestEmailPost',
    'Admin/preferencesPost',
    'Admin/fileUploadSettingsPost',
    'Admin/seoToolsPost',
    'Admin/generateSitemapPost',
    'Admin/deleteSitemapPost',
    'Admin/settingsPost',
    'Admin/recaptchaSettingsPost',
    'Admin/maintenanceModePost',
    'Admin/socialLoginSettingsPost',
    'Admin/setModePost',
    'Admin/setThemePost',
    'Admin/setSiteFontPost',
    'Admin/addFontPost',
    'Admin/deleteFontPost',
    'Admin/editFontPost',
    'Admin/setActiveLanguagePost',
    'Admin/downloadDatabaseBackup',
    'Admin/deletePagePost',
    'Admin/addMenuLinkPost',
    'Admin/menuLimitPost',
    'Admin/deleteNavigationPost',
    'Admin/editMenuLinkPost',
    'Admin/newsletterPost',
    'Admin/deleteNewsletterPost',
    'Admin/newsletterSettingsPost',
    'Admin/newsletterSendEmailPost',
    'Admin/awsS3Post',
    'Admin/storagePost',
    'Admin/addPagePost',
    'Admin/editPagePost',
    'Admin/addPollPost',
    'Admin/deletePollPost',
    'Admin/editPollPost',
    'Admin/addRolePost',
    'Admin/addUserPost',
    'Admin/editRolePost',
    'Admin/editUserPost',
    'Admin/deleteRolePost',
    'Admin/userOptionsPost',
    'Admin/deleteUserPost',
    'Admin/changeUserRolePost',
    'Admin/getMenuLinksByLang',
    'Admin/approveSelectedComments',
    'Admin/deleteSelectedComments',
    //Category
    'Category/addCategoryPost',
    'Category/deleteCategoryPost',
    'Category/addSubcategoryPost',
    'Category/editCategoryPost',
    'Category/editSubcategoryPost',
    'Category/deleteCategoryPost',
    'Category/getSubCategories',
    'Category/getParentCategoriesByLang',
    //File
    'File/downloadFile',
    'File/uploadFile',
    'File/uploadImageFile',
    'File/getImages',
    'File/deleteImageFile',
    'File/loadMoreImages',
    'File/searchImageFile',
    'File/deleteFile',
    'File/getFiles',
    'File/loadMoreFiles',
    'File/searchFile',
    //Gallery
    'Gallery/addGalleryAlbumPost',
    'Gallery/deleteGalleryAlbumPost',
    'Gallery/addGalleryCategoryPost',
    'Gallery/deleteGalleryCategoryPost',
    'Gallery/editGalleryImagePost',
    'Gallery/editGalleryAlbumPost',
    'Gallery/editGalleryCategoryPost',
    'Gallery/addGalleryImagePost',
    'Gallery/deleteGalleryImagePost',
    'Gallery/galleryAlbumsByLang',
    'Gallery/galleryCategoriesByAlbum',
    'Gallery/setAsAlbumCover',
    //Language
    'Language/setDefaultLanguagePost',
    'Language/exportLanguagePost',
    'Language/deleteLanguagePost',
    'Language/addLanguagePost',
    'Language/importLanguagePost',
    'Language/editTranslationsPost',
    'Language/editLanguagePost',
    //Post
    'Post/addPostPost',
    'Post/autoPostDeletionPost',
    'Post/postOptionsPost',
    'Post/deletePost',
    'Post/editPostPost',
    'Post/homeSliderPostsOrderPost',
    'Post/deleteSelectedPosts',
    'Post/deletePostMainImage',
    'Post/deletePostAdditionalImage',
    'Post/deletePostFile',
    'Post/deletePostMainImage',
    'Post/getVideoFromURL',
    //RSS
    'Rss/checkFeedPosts',
    'Rss/deleteFeedPost',
    'Rss/importFeedPost',
    'Rss/editFeedPost',
];

foreach ($postRoutesArray as $item) {
    $array = explode('/', $item);
    $routes->post($item, $array[0] . 'Controller::' . $array[1]);
}

/*
 * --------------------------------------------------------------------
 * Dynamic Routes
 * --------------------------------------------------------------------
 */

if (!empty($languages)) {
    foreach ($languages as $language) {
        $key = "";
        if ($generalSettings->site_lang != $language->id) {
            $key = $language->short_form;
            $routes->get($key, 'HomeController::index');
        }

        $routes->get($key . '/error-404', 'HomeController::error404');
        $routes->get($key . '/gallery', 'HomeController::gallery');
        $routes->get($key . '/gallery/album/(:num)', 'HomeController::galleryAlbum/$1');
        $routes->get($key . '/contact', 'HomeController::contact');
        $routes->get($key . '/profile/(:any)', 'ProfileController::profile/$1');
        $routes->get($key . '/tag/(:any)', 'HomeController::tag/$1');
        $routes->get($key . '/reading-list', 'HomeController::readingList');
        $routes->get($key . '/search', 'HomeController::search');
        //rss routes
        $routes->get($key . '/rss-feeds', 'HomeController::rssFeeds');
        $routes->get($key . '/rss/latest-posts', 'HomeController::rssLatestPosts');
        $routes->get($key . '/rss/popular-posts', 'HomeController::rssPopularPosts');
        $routes->get($key . '/rss/category/(:any)', 'HomeController::rssByCategory/$1');
        //profile routes
        $routes->get($key . '/settings', 'ProfileController::editProfile');
        $routes->get($key . '/settings/social-accounts', 'ProfileController::socialAccounts');
        $routes->get($key . '/settings/change-password', 'ProfileController::changePassword');
        //auth routes
        $routes->get($key . '/login', 'AuthController::login');
        $routes->get($key . '/register', 'AuthController::register');
        $routes->get($key . '/change-password', 'AuthController::changePassword');
        $routes->get($key . '/forgot-password', 'AuthController::forgotPassword');
        $routes->get($key . '/reset-password', 'AuthController::resetPassword');
        $routes->get($key . '/profile-update', 'AuthController::updateProfile');
        $routes->get($key . '/logout', 'CommonController::logout');
        $routes->get($key . '/unsubscribe', 'AuthController::unsubscribe');

        if ($generalSettings->site_lang != $language->id) {
            $routes->get($key . '/(:any)/(:any)', 'HomeController::subcategory/$1/$2');
            $routes->get($key . '/(:any)', 'HomeController::any/$1');
        }
    }
}

$routes->get('(:any)/(:any)', 'HomeController::subcategory/$1/$2');
$routes->get('(:any)', 'HomeController::any/$1');