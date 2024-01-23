<?php
defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(__DIR__);
$pathsConfig = FCPATH . 'app/Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;
$paths = new Config\Paths();
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;

$dbArray = new \Config\Database();
@$conn = mysqli_connect($dbArray->default['hostname'], $dbArray->default['username'], $dbArray->default['password'], $dbArray->default['database']);
if (empty($conn)) {
    echo 'Database connection failed! Check your database credentials in the "app/Config/Database.php" file.';
    exit();
}
$conn->query("SET CHARACTER SET utf8");
$conn->query("SET NAMES utf8");

function runQuery($sql)
{
    global $conn;
    return mysqli_query($conn, $sql);
}

if (isset($_POST["btn_submit"])) {
    update($conn);
    $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
}

function update()
{
    updateFrom42To43();
    sleep(1);
    updateFrom43To44();
    sleep(1);
}

function updateFrom42To43()
{
    runQuery("DROP TABLE ad_spaces;");
    runQuery("DROP TABLE fonts;");
    $tblAdSpaces = "CREATE TABLE `ad_spaces` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `lang_id` int(11) DEFAULT 1,
      `ad_space` text DEFAULT NULL,
      `ad_code_desktop` text DEFAULT NULL,
      `desktop_width` int(11) DEFAULT NULL,
      `desktop_height` int(11) DEFAULT NULL,
      `ad_code_mobile` text DEFAULT NULL,
      `mobile_width` int(11) DEFAULT NULL,
      `mobile_height` int(11) DEFAULT NULL,
      `paragraph_number` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $tblFonts = "CREATE TABLE `fonts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `font_name` varchar(255) DEFAULT NULL,
    `font_key` varchar(255) DEFAULT NULL,
    `font_url` varchar(2000) DEFAULT NULL,
    `font_family` varchar(500) DEFAULT NULL,
    `font_source` varchar(50) DEFAULT 'google',
    `has_local_file` tinyint(1) DEFAULT 0,
    `is_default` tinyint(1) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    runQuery($tblAdSpaces);
    runQuery($tblFonts);
    runQuery("ALTER TABLE general_settings CHANGE mail_library mail_service varchar(100) DEFAULT 'swift';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_api_key` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_secret_key` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_email_address` varchar(255);");
    runQuery("ALTER TABLE general_settings DROP COLUMN `recaptcha_lang`;");

    $sqlFonts = "INSERT INTO `fonts` (`id`, `font_name`, `font_key`, `font_url`, `font_family`, `font_source`, `has_local_file`, `is_default`) VALUES
(1, 'Arial', 'arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 'local', 0, 1),
(2, 'Arvo', 'arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 'google', 0, 0),
(3, 'Averia Libre', 'averia-libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 'google', 0, 0),
(4, 'Bitter', 'bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 'google', 0, 0),
(5, 'Cabin', 'cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 'google', 0, 0),
(6, 'Cherry Swash', 'cherry-swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 'google', 0, 0),
(7, 'Encode Sans', 'encode-sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 'google', 0, 0),
(8, 'Helvetica', 'helvetica', NULL, 'font-family: Helvetica, sans-serif', 'local', 0, 1),
(9, 'Hind', 'hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 'google', 0, 0),
(10, 'Josefin Sans', 'josefin-sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 'google', 0, 0),
(11, 'Kalam', 'kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 'google', 0, 0),
(12, 'Khula', 'khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 'google', 0, 0),
(13, 'Lato', 'lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 'google', 0, 0),
(14, 'Lora', 'lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 'google', 0, 0),
(15, 'Merriweather', 'merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 'google', 0, 0),
(16, 'Montserrat', 'montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 'google', 0, 0),
(17, 'Mukta', 'mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 'google', 0, 0),
(18, 'Nunito', 'nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 'google', 0, 0),
(19, 'Open Sans', 'open-sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 'local', 1, 0),
(20, 'Oswald', 'oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 'google', 0, 0),
(21, 'Oxygen', 'oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 'google', 0, 0),
(22, 'Poppins', 'poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Poppins\", Helvetica, sans-serif', 'google', 0, 0),
(23, 'PT Sans', 'pt-sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 'google', 0, 0),
(24, 'Raleway', 'raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 'google', 0, 0),
(25, 'Roboto', 'roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 'local', 1, 0),
(26, 'Roboto Condensed', 'roboto-condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 'google', 0, 0),
(27, 'Roboto Slab', 'roboto-slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 'google', 0, 0),
(28, 'Rokkitt', 'rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 'google', 0, 0),
(29, 'Source Sans Pro', 'source-sans-pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 'google', 0, 0),
(30, 'Titillium Web', 'titillium-web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 'google', 0, 0),
(31, 'Ubuntu', 'ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 'google', 0, 0),
(32, 'Verdana', 'verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 'local', 0, 1);";
    runQuery($sqlFonts);
    runQuery("UPDATE general_settings SET `version` = '4.3' WHERE id = 1;");

    //add new translations
    $p = array();
    $p["ok"] = "OK";
    $p["cancel"] = "Cancel";
    $p["ad_space_index_top"] = "Index (Top)";
    $p["ad_space_index_bottom"] = "Index (Bottom)";
    $p["ad_space_post_top"] = "Post Details (Top)";
    $p["ad_space_post_bottom"] = "Post Details (Bottom)";
    $p["ad_space_posts_top"] = "Posts (Top)";
    $p["ad_space_posts_bottom"] = "Posts (Bottom)";
    $p["sidebar"] = "Sidebar";
    $p["ad_space_in_article"] = "In-Article";
    $p["banner_desktop"] = "Desktop Banner";
    $p["banner_desktop_exp"] = "This ad will be displayed on screens larger than 992px";
    $p["banner_mobile"] = "Mobile Banner";
    $p["banner_mobile_exp"] = "This ad will be displayed on screens smaller than 992px";
    $p["create_ad_exp"] = "If you don not have an ad code, you can create an ad code by selecting an image and adding an URL";
    $p["paragraph"] = "Paragraph";
    $p["ad_space_paragraph_exp"] = "The ad will be displayed after the paragraph number you selected";
    $p["mail_service"] = "Mail Service";
    $p["api_key"] = "API Key";
    $p["mailjet_email_address"] = "Mailjet Email Address";
    $p["mailjet_email_address_exp"] = "The address you created your Mailjet account with";
    $p["mail_title"] = "Mail Title";
    $p["font_source"] = "Font Source";
    $p["local"] = "Local";
    $p["ad_space_posts_exp"] = "This ad will be displayed on Posts, Category, Profile, Tag, Search and Profile pages";
    $p["last_seen"] = "Last seen:";
    addTranslations($p);
    //delete old translations
    runQuery("DELETE FROM language_translations WHERE `label`='category_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='category_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='index_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='index_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='post_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='post_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='profile_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='profile_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='reading_list_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='reading_list_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='search_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='search_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='sidebar_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='sidebar_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='tag_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='tag_top_ad_space';");
}

function updateFrom43To44()
{
    runQuery("ALTER TABLE general_settings DROP COLUMN IF EXISTS `recaptcha_lang`;");
    runQuery("ALTER TABLE files ADD COLUMN `file_path` varchar(500);");
    runQuery("ALTER TABLE files ADD COLUMN `storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `rss_content_type` varchar(50) DEFAULT 'summary';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `image_file_format` varchar(30) DEFAULT 'JPG';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `default_role_id` INT(11) DEFAULT 3;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `aws_key` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `aws_secret` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `aws_bucket` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `aws_region` varchar(255);");
    runQuery("ALTER TABLE general_settings CHANGE custom_css_codes custom_header_codes mediumtext;");
    runQuery("ALTER TABLE general_settings CHANGE custom_javascript_codes custom_footer_codes mediumtext;");
    runQuery("ALTER TABLE general_settings CHANGE mobile_logo_path logo_darkmode_path varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `logo_desktop_width` smallint(6) DEFAULT 180;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `logo_desktop_height` smallint(6) DEFAULT 50;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `logo_mobile_width` smallint(6) DEFAULT 180;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `logo_mobile_height` smallint(6) DEFAULT 50;");
    runQuery("ALTER TABLE general_settings ADD COLUMN `sidebar_categories` tinyint(1) DEFAULT 1;");
    runQuery("ALTER TABLE images ADD COLUMN `storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE photos ADD COLUMN `storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE posts ADD COLUMN `image_storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE post_images ADD COLUMN `storage` varchar(20) DEFAULT 'local';");
    runQuery("ALTER TABLE settings ADD COLUMN `tiktok_url` varchar(500);");
    runQuery("ALTER TABLE settings ADD COLUMN `whatsapp_url` varchar(500);");
    runQuery("ALTER TABLE settings ADD COLUMN `discord_url` varchar(500);");
    runQuery("ALTER TABLE settings ADD COLUMN `twitch_url` varchar(500);");
    runQuery("ALTER TABLE users ADD COLUMN `tiktok_url` varchar(500);");
    runQuery("ALTER TABLE users ADD COLUMN `whatsapp_url` varchar(500);");
    runQuery("ALTER TABLE users ADD COLUMN `discord_url` varchar(500);");
    runQuery("ALTER TABLE users ADD COLUMN `twitch_url` varchar(500);");
    runQuery("UPDATE general_settings SET `version` = '4.4' WHERE id = 1;");

    //update files
    $files = runQuery("SELECT * FROM files ORDER BY id;");
    if (!empty($files->num_rows)) {
        while ($item = mysqli_fetch_array($files)) {
            runQuery("UPDATE files SET `file_path`='uploads/files/". $item['file_name'] . "' WHERE `id`=" . $item['id'] . ";");
        }
    }

    //add new translations
    $p = array();
    $p["accept_cookies"] = "Accept Cookies";
    $p["aws_key"] = "AWS Access Key";
    $p["aws_secret"] = "AWS Secret Key";
    $p["aws_storage"] = "AWS S3 Storage";
    $p["bucket_name"] = "Bucket Name";
    $p["custom_footer_codes"] = "Custom Footer Codes";
    $p["custom_footer_codes_exp"] = "These codes will be added to the footer of the site.";
    $p["custom_header_codes"] = "Custom Header Codes";
    $p["custom_header_codes_exp"] = "These codes will be added to the header of the site.";
    $p["default_role_members"] = "Default Role for New Members";
    $p["distribute_only_post_summary"] = "Distribute only Post Summary";
    $p["distribute_post_content"] = "Distribute Post Content";
    $p["general"] = "General";
    $p["image_file_format"] = "Image File Format";
    $p["local_storage"] = "Local Storage";
    $p["preferences"] = "Preferences";
    $p["region_code"] = "Region Code";
    $p["rss_content"] = "RSS Content";
    $p["storage"] = "Storage";
    $p["logo_size"] = "Logo Size";
    $p["desktop"] = "Desktop";
    $p["mobile"] = "Mobile";
    $p["width"] = "Width";
    $p["height"] = "Height";
    $p["logo_size_exp"] = "For better logo quality, you can upload your logo in slightly larger sizes and set smaller sizes by keeping the image ratio the same";
    $p["show_categories_sidebar"] = "Show Categories on Sidebar";
    addTranslations($p);
    //delete old translations
    runQuery("DELETE FROM language_translations WHERE `label`='custom_css_codes';");
    runQuery("DELETE FROM language_translations WHERE `label`='custom_css_codes_exp';");
    runQuery("DELETE FROM language_translations WHERE `label`='custom_javascript_codes';");
    runQuery("DELETE FROM language_translations WHERE `label`='custom_javascript_codes_exp';");
    runQuery("DELETE FROM language_translations WHERE `label`='mobile_logo';");

    runQuery("INSERT INTO `fonts` (`font_name`, `font_key`, `font_url`, `font_family`, `font_source`, `has_local_file`, `is_default`) VALUES
('Inter', 'inter', '<link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Inter\", sans-serif;', 'local', 1, 0);");

}

function addTranslations($translations)
{
    $languages = runQuery("SELECT * FROM languages;");
    if (!empty($languages->num_rows)) {
        while ($language = mysqli_fetch_array($languages)) {
            foreach ($translations as $key => $value) {
                $trans = runQuery("SELECT * FROM language_translations WHERE label ='" . $key . "' AND lang_id = " . $language['id']);
                if (empty($trans->num_rows)) {
                    runQuery("INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) VALUES (" . $language['id'] . ", '" . $key . "', '" . $value . "');");
                }
            }
        }
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Infinite - Update Wizard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;
            background: #007991;
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2);
            background: linear-gradient(to left, #007991, #6fe7c2);
        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">
            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Infinite</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v4.2.x to v4.4</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?= $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?= $success; ?></strong>
                                    <style>.alert-info {
                                            display: none;
                                        }</style>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-footer text-center">
                                            <button type="submit" name="btn_submit" class="btn-custom">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
