<?

if (
	CModule::IncludeModule("iblock") &&
	CModule::IncludeModule('highloadblock')&&
    CModule::IncludeModule("search")
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

$APPLICATION->AddHeadString('<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">');
$APPLICATION->AddHeadString('<meta name="apple-mobile-web-app-capable" content="yes">');
$APPLICATION->AddHeadString('<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=0">');
$APPLICATION->AddHeadString('<meta name = "format-detection" content = "telephone=no">');

include('functions.php');

if($_REQUEST['AJAX_REQUEST'] == 'Y'){

	CCallback::router();
	exit();
}

if($USER->isAuthorized()){ 

    $arr = CHighL::HL_Sel(1, Array("UF_USER_ID"=> $USER->getID()))[0];

    $arr = unserialize($arr['UF_FAVOUR']);
    $res = Array();
    if(count($arr) > 0){
        $res = CHelper::elements(Array(Array(), Array("IBLOCK_ID"=>2, "ID" => $arr, "ACTIVE"=>"Y")),'',true);
    }
    $arTheme['FAVS_CNT'] = count($res);
}
if(!empty($_POST['CITIES_HEADER'])){

    $_SESSION['CITY'] = $_POST['CITIES_HEADER'];
    header("Location: ". $_SERVER['REQUEST_URI']);
    die();
}
$_SESSION['CITY'] = !empty($_SESSION['CITY']) ? $_SESSION['CITY'] : 'Москва';
?>