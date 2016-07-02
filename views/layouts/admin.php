<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\helpers\Url;

$url = Url::home(true);

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="description" content="Admin">
    <meta name="keywords" content="Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,500,700,300,300italic,500italic|Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        var Host = '<?php echo $url; ?>';
    </script>
    <script src="http://maps.google.com/maps/api/js"></script>

    <style type="text/css">
      md-bottom-sheet.md-default-theme.md-list md-list-item , md-bottom-sheet.md-list md-list-item {    color: rgba(0,0,0,0.87);}md-bottom-sheet.md-default-theme .md-subheader , md-bottom-sheet .md-subheader {    color: rgba(0,0,0,0.87);}a.md-button.md-default-theme.md-primary, a.md-button.md-primary,.md-button.md-default-theme.md-primary , .md-button.md-primary {  color: rgb(0,150,136);}a.md-button.md-default-theme.md-primary.md-raised, a.md-button.md-primary.md-raised, a.md-button.md-default-theme.md-primary.md-fab, a.md-button.md-primary.md-fab,  .md-button.md-default-theme.md-primary.md-raised,   .md-button.md-primary.md-raised,  .md-button.md-default-theme.md-primary.md-fab ,   .md-button.md-primary.md-fab {    color: rgb(255,255,255);    background-color: rgb(0,150,136);}a.md-button.md-default-theme.md-primary.md-raised:not([disabled]) md-icon, a.md-button.md-primary.md-raised:not([disabled]) md-icon, a.md-button.md-default-theme.md-primary.md-fab:not([disabled]) md-icon, a.md-button.md-primary.md-fab:not([disabled]) md-icon,    .md-button.md-default-theme.md-primary.md-raised:not([disabled]) md-icon,     .md-button.md-primary.md-raised:not([disabled]) md-icon,    .md-button.md-default-theme.md-primary.md-fab:not([disabled]) md-icon ,     .md-button.md-primary.md-fab:not([disabled]) md-icon {      color: rgb(255,255,255);}a.md-button.md-default-theme.md-primary.md-raised:not([disabled]):hover, a.md-button.md-primary.md-raised:not([disabled]):hover, a.md-button.md-default-theme.md-primary.md-fab:not([disabled]):hover, a.md-button.md-primary.md-fab:not([disabled]):hover,    .md-button.md-default-theme.md-primary.md-raised:not([disabled]):hover,     .md-button.md-primary.md-raised:not([disabled]):hover,    .md-button.md-default-theme.md-primary.md-fab:not([disabled]):hover ,     .md-button.md-primary.md-fab:not([disabled]):hover {      background-color: rgb(0,150,136);}a.md-button.md-default-theme.md-primary.md-raised:not([disabled]).md-focused, a.md-button.md-primary.md-raised:not([disabled]).md-focused, a.md-button.md-default-theme.md-primary.md-fab:not([disabled]).md-focused, a.md-button.md-primary.md-fab:not([disabled]).md-focused,    .md-button.md-default-theme.md-primary.md-raised:not([disabled]).md-focused,     .md-button.md-primary.md-raised:not([disabled]).md-focused,    .md-button.md-default-theme.md-primary.md-fab:not([disabled]).md-focused ,     .md-button.md-primary.md-fab:not([disabled]).md-focused {      background-color: rgb(0,137,123);}a.md-button.md-default-theme.md-primary:not([disabled]) md-icon, a.md-button.md-primary:not([disabled]) md-icon,  .md-button.md-default-theme.md-primary:not([disabled]) md-icon ,   .md-button.md-primary:not([disabled]) md-icon {    color: rgb(0,150,136);}md-card.md-default-theme .md-card-image , md-card .md-card-image {    border-radius: 2px 2px 0 0;}md-card.md-default-theme md-card-header md-card-header-text .md-subhead , md-card md-card-header md-card-header-text .md-subhead {    color: rgba(0,0,0,0.54);}md-card.md-default-theme md-card-title md-card-title-text:not(:only-child) .md-subhead , md-card md-card-title md-card-title-text:not(:only-child) .md-subhead {    color: rgba(0,0,0,0.54);}md-checkbox.md-default-theme .md-ink-ripple , md-checkbox .md-ink-ripple {  color: rgba(0,0,0,0.54);}md-checkbox.md-default-theme .md-icon , md-checkbox .md-icon {  border-color: rgba(0,0,0,0.54);}md-checkbox.md-default-theme:not([disabled]).md-primary .md-ripple , md-checkbox:not([disabled]).md-primary .md-ripple {  color: rgb(0,137,123);}md-checkbox.md-default-theme:not([disabled]).md-primary.md-checked .md-ripple , md-checkbox:not([disabled]).md-primary.md-checked .md-ripple {  color: rgb(117,117,117);}md-checkbox.md-default-theme:not([disabled]).md-primary .md-ink-ripple , md-checkbox:not([disabled]).md-primary .md-ink-ripple {  color: rgba(0,0,0,0.54);}md-checkbox.md-default-theme:not([disabled]).md-primary.md-checked .md-ink-ripple , md-checkbox:not([disabled]).md-primary.md-checked .md-ink-ripple {  color: rgba(0,150,136,0.87);}md-checkbox.md-default-theme:not([disabled]).md-primary .md-icon , md-checkbox:not([disabled]).md-primary .md-icon {  border-color: rgba(0,0,0,0.54);}md-checkbox.md-default-theme:not([disabled]).md-primary.md-checked .md-icon , md-checkbox:not([disabled]).md-primary.md-checked .md-icon {  background-color: rgba(0,150,136,0.87);}md-checkbox.md-default-theme:not([disabled]).md-primary.md-checked.md-focused .md-container:before , md-checkbox:not([disabled]).md-primary.md-checked.md-focused .md-container:before {  background-color: rgba(0,150,136,0.26);}md-checkbox.md-default-theme:not([disabled]).md-primary.md-checked .md-icon:after , md-checkbox:not([disabled]).md-primary.md-checked .md-icon:after {  border-color: rgba(255,255,255,0.87);}md-checkbox.md-default-theme[disabled] .md-icon , md-checkbox[disabled] .md-icon {  border-color: rgba(0,0,0,0.26);}md-checkbox.md-default-theme[disabled] .md-label , md-checkbox[disabled] .md-label {  color: rgba(0,0,0,0.26);}md-chips.md-default-theme .md-chips.md-focused , md-chips .md-chips.md-focused {    box-shadow: 0 2px rgb(0,150,136);}md-chips.md-default-theme .md-chip.md-focused , md-chips .md-chip.md-focused {    background: rgb(0,150,136);    color: rgb(255,255,255);}md-chips.md-default-theme .md-chip.md-focused md-icon , md-chips .md-chip.md-focused md-icon {      color: rgb(255,255,255);}/** Theme styles for mdCalendar. */.md-calendar.md-default-theme , .md-calendar {  color: rgba(0,0,0,0.87);}.md-default-theme .md-calendar-date.md-calendar-date-today .md-calendar-date-selection-indicator ,  .md-calendar-date.md-calendar-date-today .md-calendar-date-selection-indicator {  border: 1px solid rgb(0,150,136);}.md-default-theme .md-calendar-date.md-calendar-date-today.md-calendar-date-disabled ,  .md-calendar-date.md-calendar-date-today.md-calendar-date-disabled {  color: rgba(0,150,136,0.6);}.md-default-theme .md-calendar-date.md-calendar-selected-date .md-calendar-date-selection-indicator,  .md-calendar-date.md-calendar-selected-date .md-calendar-date-selection-indicator,.md-default-theme .md-calendar-date.md-focus.md-calendar-selected-date .md-calendar-date-selection-indicator ,  .md-calendar-date.md-focus.md-calendar-selected-date .md-calendar-date-selection-indicator {  background: rgb(0,150,136);  color: rgb(255,255,255);  border-color: transparent;}.md-default-theme .md-calendar-date-disabled,  .md-calendar-date-disabled,.md-default-theme .md-calendar-month-label-disabled ,  .md-calendar-month-label-disabled {  color: rgba(0,0,0,0.26);}.md-default-theme .md-datepicker-input::-webkit-input-placeholder,  .md-datepicker-input::-webkit-input-placeholder, .md-default-theme .md-datepicker-input::-moz-placeholder,  .md-datepicker-input::-moz-placeholder, .md-default-theme .md-datepicker-input:-moz-placeholder,  .md-datepicker-input:-moz-placeholder, .md-default-theme .md-datepicker-input:-ms-input-placeholder ,  .md-datepicker-input:-ms-input-placeholder {    color: rgba(0,0,0,0.26);}.md-default-theme .md-datepicker-input-container.md-datepicker-focused ,  .md-datepicker-input-container.md-datepicker-focused {    border-bottom-color: rgb(0,150,136);}.md-default-theme .md-datepicker-triangle-button .md-datepicker-expand-triangle ,  .md-datepicker-triangle-button .md-datepicker-expand-triangle {  border-top-color: rgba(0,0,0,0.26);}.md-default-theme .md-datepicker-triangle-button:hover .md-datepicker-expand-triangle ,  .md-datepicker-triangle-button:hover .md-datepicker-expand-triangle {  border-top-color: rgba(0,0,0,0.54);}.md-default-theme .md-datepicker-open .md-datepicker-calendar-icon ,  .md-datepicker-open .md-datepicker-calendar-icon {  fill: rgb(0,150,136);}md-dialog.md-default-theme.md-content-overflow .md-actions, md-dialog.md-content-overflow .md-actions, md-dialog.md-default-theme.md-content-overflow md-dialog-actions , md-dialog.md-content-overflow md-dialog-actions {    border-top-color: rgba(0,0,0,0.12);}md-divider.md-default-theme , md-divider {  border-top-color: rgba(0,0,0,0.12);}.layout-row > md-divider.md-default-theme , .layout-row > md-divider {  border-right-color: rgba(0,0,0,0.12);}md-icon.md-default-theme , md-icon {  color: rgba(0,0,0,0.54);}md-icon.md-default-theme.md-primary , md-icon.md-primary {    color: rgb(0,150,136);}md-input-container.md-default-theme .md-input , md-input-container .md-input {  color: rgba(0,0,0,0.87);  border-color: rgba(0,0,0,0.12);  text-shadow: ;}md-input-container.md-default-theme .md-input::-webkit-input-placeholder, md-input-container .md-input::-webkit-input-placeholder, md-input-container.md-default-theme .md-input::-moz-placeholder, md-input-container .md-input::-moz-placeholder, md-input-container.md-default-theme .md-input:-moz-placeholder, md-input-container .md-input:-moz-placeholder, md-input-container.md-default-theme .md-input:-ms-input-placeholder , md-input-container .md-input:-ms-input-placeholder {    color: rgba(0,0,0,0.26);}md-input-container.md-default-theme > md-icon , md-input-container > md-icon {  color: rgba(0,0,0,0.87);}md-input-container.md-default-theme label, md-input-container label,md-input-container.md-default-theme .md-placeholder , md-input-container .md-placeholder {  text-shadow: ;  color: rgba(0,0,0,0.26);}md-input-container.md-default-theme:not(.md-input-invalid).md-input-has-value label , md-input-container:not(.md-input-invalid).md-input-has-value label {  color: rgba(0,0,0,0.54);}md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused .md-input , md-input-container:not(.md-input-invalid).md-input-focused .md-input {  border-color: rgb(0,150,136);}md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused label , md-input-container:not(.md-input-invalid).md-input-focused label {  color: rgb(0,150,136);}md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused md-icon , md-input-container:not(.md-input-invalid).md-input-focused md-icon {  color: rgb(0,150,136);}…
    </style>

    <style type="text/css" class="">
        @charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}
    </style>
</head>
<?php $this->beginBody() ?>

<body data-ng-app="app"  id="app" class="app">

  <header data-ng-include=" 'app/layout/header.html' " id="header" class="header-container  ng-scope header-fixed bg-white">

    <header class="top-header clearfix ng-scope">
    <div ui-preloader="" class="preloaderbar hide"><span class="bar"></span></div>

    <!-- Logo -->
    <div class="logo bg-primary">
        <a href="#">
            <span class="logo-icon zmdi zmdi-view-dashboard"></span>
            <span class="logo-text ng-binding">Admin</span>
        </a>
    </div>

    <!-- needs to be put after logo to make it work -->
    <div class="menu-button" toggle-off-canvas="">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </div>

    <div class="top-nav">

    </div>
</header>
</header>

<div class="main-container">

<aside id="nav-container" class="nav-container ng-scope nav-fixed nav-vertical bg-dark">

  <div class="nav-wrapper ng-scope menu-admin">
      <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><ul id="nav" class="nav" data-slim-scroll="" data-collapse-nav="" data-highlight-active="" style="overflow: hidden; width: auto; height: 100%;">

				<?php if (!Yii::$app->user->isGuest) : ?>

					<!--<li class="active"><a class="md-button md-ink-ripple" ng-transclude="" md-button="" aria-label="meanu" href="/admin"><span class="ng-scope">Home</span> </a></li>-->
          <li class="active"><a class="md-button md-ink-ripple" href="/admin/articles"><span class="ng-scope">Articles</span> </a></li>
	        <li class="active"><a class="md-button md-ink-ripple" href="/admin/static-pages/index"><span class="ng-scope">Static Pages</span> </a></li>
	        <li class="active"><a class="md-button md-ink-ripple" href="/admin/bnrs"><span class="ng-scope">Banners</span> </a></li>
	        <li class="active"><a class="md-button md-ink-ripple" href="/admin/categories"><span class="ng-scope">Categories</span> </a></li>
	        <!--<li class="active"><a class="md-button md-ink-ripple"  href="/admin/contact-us"><span class="ng-scope">Contact Us</span> </a></li>-->
	        <li class="active"><a class="md-button md-ink-ripple" href="/admin/sources"><span class="ng-scope">Sources</span> </a></li>
	        <li class="active"><a class="md-button md-ink-ripple" href="/admin/settings"><span class="ng-scope">Settings</span> </a></li>
					<li class="active"><a class="md-button md-ink-ripple" data-method="post" data-confirm="Are you sure you want to logout?" href="/admin/default/logout"><span class="ng-scope">Logout</span> </a></li>

				<?php endif; ?>
				<!-- <li class="active"><a class="md-button md-ink-ripple" ng-transclude="" md-button="" aria-label="meanu" href="/admin/links"><span class="ng-scope">Links</span> </a></li> -->
      </ul>
      <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 666px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
  </div>

</aside>

<div id="content" class="content-container">
<section data-ui-view="" class="view-container animate-fade-up">
<div class="page page-dashboard ng-scope">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-minimal">
                <div class="panel-body">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

</div>
</section>
</div>
</div>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
