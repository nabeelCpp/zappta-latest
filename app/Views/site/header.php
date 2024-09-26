<?php
$trait = (new App\Helpers\ZapptaHelper);
$assets_url = $trait::loadAssetsUrl();
$css = $trait::loadModifiedThemeCss();
$dashboardCss = $trait::loadDashboardCss();
$globalSettings = $trait::getGlobalSettings(['company_name', 'frontend_logo']);
?>
<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css.$dashboardCss, 'assets_url' => $assets_url]); ?>