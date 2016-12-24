<?

if (
    CModule::IncludeModule("iblock") &&
    CModule::IncludeModule('highloadblock')&&
    CModule::IncludeModule("search") &&
    CModule::IncludeModule('catalog') &&
    CModule::IncludeModule('sale')
    ):

CModule::AddAutoloadClasses(
        '', // не указываем имя модуля
        array(
           // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
                'CHelper' => "/bitrix/templates/adverts/includes/classes/helper-class.php",
                'CHighL' => "/bitrix/templates/adverts/includes/classes/highloadblock-class.php",
                'CCallback' => "/bitrix/templates/adverts/includes/classes/callback-class.php",
                'CPersonal' => "/bitrix/templates/adverts/includes/classes/personal-class.php",
        )
);

global $USER;

define('TPL', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/adverts/');
endif;

include('functions.php');

if ( $_REQUEST['AJAX_REQUEST'] == 'Y' ) { // If AJAX permorfmed

    CCallback::router();
    exit();
}


$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . "/css/mobile.css", true );
$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . "/css/desktop.css", true );
$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . "/css/tablets.css", true );
$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . "/css/jquery.kladr.min.css");

$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/jquery.min.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/jquery-ui.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/plugins.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/common.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/hammer.min.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/handyAjax.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/handyMethods.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/mask.js");
$APPLICATION->addHeadScript(SITE_TEMPLATE_PATH . '/js/main.js');
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/jquery.kladr.min.js");
$APPLICATION->AddHeadScript( SITE_TEMPLATE_PATH . "/js/script-kladr-cities-header.js");

$APPLICATION->AddHeadString( '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' );
$APPLICATION->AddHeadString( '<meta name="apple-mobile-web-app-capable" content="yes">' );
$APPLICATION->AddHeadString( '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=0">' );
$APPLICATION->AddHeadString( '<meta name = "format-detection" content = "telephone=no">' );
$APPLICATION->AddHeadString( '<link rel="shortcut icon" href="favicon.ico">' );


/** CATALOG_SORT */
CHelper::catalog_order_sort_init();

// Проверяем на оптового или розничного покупателя
$userType = 'NONSALE';

if ( $USER->isAuthorized() ) { // If user authorised do smth

    $group = $USER->GetUserGroupArray();

    if ( ! in_array( 8, $group) ) {

        $userType = 'SALE';
    }
}

define( ZG_USER_TYPE, $userType );
?>