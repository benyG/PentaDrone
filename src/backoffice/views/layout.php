<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Base path
$basePath = BasePath(true);
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $Language->projectPhrase("BodyTitle") ?></title>
<meta charset="utf-8">
<?php if ($ReportExportType != "" && $ReportExportType != "print") { // Stylesheet for exporting reports ?>
<link rel="stylesheet" type="text/css" href="<?= $basePath ?><?= CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
    <?php if ($ReportExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" type="text/css" href="<?= "/" . $basePath ?><?= CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>">
    <?php } ?>
<?php } ?>
<?php if (!IsExport() || IsExport("print")) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?>adminlte3/css/<?= CssFile("adminlte.css") ?>">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?>plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?>css/OverlayScrollbars.min.css">
<link rel="stylesheet" type="text/css" href="<?= $basePath ?><?= CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
<?php if ($CustomExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" type="text/css" href="<?= $basePath ?><?= CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>">
<?php } ?>
<script src="<?= $basePath ?>js/ewcore.min.js"></script>
<script>
var $rowindex$ = null;
Object.assign(ew, {
    LANGUAGE_ID: "<?= $CurrentLanguage ?>",
    DATE_SEPARATOR: "<?= $DATE_SEPARATOR ?>", // Date separator
    TIME_SEPARATOR: "<?= $TIME_SEPARATOR ?>", // Time separator
    DATE_FORMAT: "<?= $DATE_FORMAT ?>", // Default date format
    DATE_FORMAT_ID: <?= $DATE_FORMAT_ID ?>, // Default date format ID
    DATETIME_WITHOUT_SECONDS: <?= Config("DATETIME_WITHOUT_SECONDS") ? "true" : "false" ?>, // Date/Time without seconds
    DECIMAL_POINT: "<?= $DECIMAL_POINT ?>",
    THOUSANDS_SEP: "<?= $THOUSANDS_SEP ?>",
    SESSION_TIMEOUT: <?= Config("SESSION_TIMEOUT") > 0 ? SessionTimeoutTime() : 0 ?>, // Session timeout time (seconds)
    SESSION_TIMEOUT_COUNTDOWN: <?= Config("SESSION_TIMEOUT_COUNTDOWN") ?>, // Count down time to session timeout (seconds)
    SESSION_KEEP_ALIVE_INTERVAL: <?= Config("SESSION_KEEP_ALIVE_INTERVAL") ?>, // Keep alive interval (seconds)
    IS_LOGGEDIN: <?= IsLoggedIn() ? "true" : "false" ?>, // Is logged in
    IS_SYS_ADMIN: <?= IsSysAdmin() ? "true" : "false" ?>, // Is sys admin
    CURRENT_USER_NAME: "<?= JsEncode(CurrentUserName()) ?>", // Current user name
    IS_AUTOLOGIN: <?= IsAutoLogin() ? "true" : "false" ?>, // Is logged in with option "Auto login until I logout explicitly"
    TIMEOUT_URL: "<?= $basePath ?>logout", // Timeout URL // PHP
    TOKEN_NAME_KEY: "<?= $TokenNameKey ?>", // Token name key
    TOKEN_NAME: "<?= $TokenName ?>", // Token name
    API_FILE_TOKEN_NAME: "<?= Config("API_FILE_TOKEN_NAME") ?>", // API file token name
    API_URL: "<?= Config("API_URL") ?>", // API file name // PHP
    API_ACTION_NAME: "<?= Config("API_ACTION_NAME") ?>", // API action name
    API_OBJECT_NAME: "<?= Config("API_OBJECT_NAME") ?>", // API object name
    API_LIST_ACTION: "<?= Config("API_LIST_ACTION") ?>", // API list action
    API_VIEW_ACTION: "<?= Config("API_VIEW_ACTION") ?>", // API view action
    API_ADD_ACTION: "<?= Config("API_ADD_ACTION") ?>", // API add action
    API_EDIT_ACTION: "<?= Config("API_EDIT_ACTION") ?>", // API edit action
    API_DELETE_ACTION: "<?= Config("API_DELETE_ACTION") ?>", // API delete action
    API_LOGIN_ACTION: "<?= Config("API_LOGIN_ACTION") ?>", // API login action
    API_FILE_ACTION: "<?= Config("API_FILE_ACTION") ?>", // API file action
    API_UPLOAD_ACTION: "<?= Config("API_UPLOAD_ACTION") ?>", // API upload action
    API_JQUERY_UPLOAD_ACTION: "<?= Config("API_JQUERY_UPLOAD_ACTION") ?>", // API jQuery upload action
    API_SESSION_ACTION: "<?= Config("API_SESSION_ACTION") ?>", // API get session action
    API_LOOKUP_ACTION: "<?= Config("API_LOOKUP_ACTION") ?>", // API lookup action
    API_LOOKUP_PAGE: "<?= Config("API_LOOKUP_PAGE") ?>", // API lookup page name
    API_PROGRESS_ACTION: "<?= Config("API_PROGRESS_ACTION") ?>", // API progress action
    API_EXPORT_CHART_ACTION: "<?= Config("API_EXPORT_CHART_ACTION") ?>", // API export chart action
    API_JWT_AUTHORIZATION_HEADER: "X-Authorization", // API JWT authorization header
    API_JWT_TOKEN: "<?= GetJwtToken() ?>", // API JWT token
    MULTIPLE_OPTION_SEPARATOR: "<?= Config("MULTIPLE_OPTION_SEPARATOR") ?>", // Multiple option separator
    AUTO_SUGGEST_MAX_ENTRIES: <?= Config("AUTO_SUGGEST_MAX_ENTRIES") ?>, // Auto-Suggest max entries
    IMAGE_FOLDER: "images/", // Image folder
    PATH_BASE: "<?= $basePath ?>", // Path base // PHP
    SESSION_ID: "<?= Encrypt(session_id()) ?>", // Session ID
    UPLOAD_THUMBNAIL_WIDTH: <?= Config("UPLOAD_THUMBNAIL_WIDTH") ?>, // Upload thumbnail width
    UPLOAD_THUMBNAIL_HEIGHT: <?= Config("UPLOAD_THUMBNAIL_HEIGHT") ?>, // Upload thumbnail height
    MULTIPLE_UPLOAD_SEPARATOR: "<?= Config("MULTIPLE_UPLOAD_SEPARATOR") ?>", // Upload multiple separator
    IMPORT_FILE_ALLOWED_EXT: "<?= Config("IMPORT_FILE_ALLOWED_EXT") ?>", // Import file allowed extensions
    USE_COLORBOX: <?= Config("USE_COLORBOX") ? "true" : "false" ?>,
    USE_JAVASCRIPT_MESSAGE: true,
    PROJECT_STYLESHEET_FILENAME: "<?= GetUrl(Config("PROJECT_STYLESHEET_FILENAME")) ?>", // Project style sheet
    PDF_STYLESHEET_FILENAME: "<?= Config("PDF_STYLESHEET_FILENAME") ?: "" ?>", // PDF style sheet // PHP
    EMBED_PDF: <?= Config("EMBED_PDF") ? "true" : "false" ?>,
    ANTIFORGERY_TOKEN_KEY: "<?= $TokenValueKey ?>", // PHP
    ANTIFORGERY_TOKEN: "<?= $TokenValue ?>", // PHP
    CSS_FLIP: <?= Config("CSS_FLIP") ? "true" : "false" ?>,
    LAZY_LOAD: <?= Config("LAZY_LOAD") ? "true" : "false" ?>,
    USE_RESPONSIVE_TABLE: <?= Config("USE_RESPONSIVE_TABLE") ? "true" : "false" ?>,
    RESPONSIVE_TABLE_CLASS: "<?= Config("RESPONSIVE_TABLE_CLASS") ?>",
    DEBUG: <?= Config("DEBUG") ? "true" : "false" ?>,
    SEARCH_FILTER_OPTION: "<?= Config("SEARCH_FILTER_OPTION") ?>",
    OPTION_HTML_TEMPLATE: <?= JsonEncode(Config("OPTION_HTML_TEMPLATE")) ?>,
    USE_OVERLAY_SCROLLBARS: false,
    REMOVE_XSS: <?= Config("REMOVE_XSS") ? "true" : "false" ?>,
    ENCRYPTED_PASSWORD: <?= Config("ENCRYPTED_PASSWORD") ? "true" : "false" ?>,
    INVALID_USERNAME_CHARACTERS: "<?= JsEncode(Config("INVALID_USERNAME_CHARACTERS")) ?>",
    INVALID_PASSWORD_CHARACTERS: "<?= JsEncode(Config("INVALID_PASSWORD_CHARACTERS")) ?>",
    IS_RTL: <?= IsRTL() ? "true" : "false" ?>
});
loadjs(ew.PATH_BASE + "jquery/jquery-3.5.1.min.js", "jquery");
loadjs([
    ew.PATH_BASE + "js/mobile-detect.min.js",
    ew.PATH_BASE + "js/purify.min.js",
    ew.PATH_BASE + "jquery/load-image.all.min.js",
    ew.PATH_BASE + "js/loading-attribute-polyfill.min.js"
], "others");
loadjs([
    ew.PATH_BASE + "plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css",
    ew.PATH_BASE + "plugins/sweetalert2/sweetalert2.all.min.js"
], "swal");
<?= $Language->toJson() ?>
ew.vars = <?= JsonEncode($ClientVariables) ?>;
ew.ready(["wrapper", "jquery"], ew.PATH_BASE + "jquery/jsrender.min.js", "jsrender", ew.renderJsTemplates);
ew.ready("jsrender", ew.PATH_BASE + "jquery/jquery.overlayScrollbars.min.js", "scrollbars"); // Init sidebar scrollbars after rendering menu
ew.ready("jquery", ew.PATH_BASE + "jquery/jquery.ui.widget.min.js", "widget");
ew.loadjs([
    ew.PATH_BASE + "moment/moment.min.js",
    ew.PATH_BASE + "js/Chart.min.js",
    ew.PATH_BASE + "js/chartjs-plugin-annotation.min.js",
    ew.PATH_BASE + "js/chartjs-plugin-datalabels.min.js"
], "moment");
</script>
<?php include_once $RELATIVE_PATH . "views/menu.php"; ?>
<script>
var cssfiles = [
    ew.PATH_BASE + "css/Chart.min.css",
    ew.PATH_BASE + "css/jquery.fileupload.css",
    ew.PATH_BASE + "css/jquery.fileupload-ui.css"
];
cssfiles.push(ew.PATH_BASE + "colorbox/colorbox.css");
loadjs(cssfiles, "css");
var cssjs = [];
<?php foreach (array_merge(Config("STYLESHEET_FILES"), Config("JAVASCRIPT_FILES")) as $file) { // External Stylesheets and JavaScripts ?>
cssjs.push("<?= (IsRemote($file) ? "" : BasePath(true)) . $file ?>");
<?php } ?>
var jqueryjs = [
    ew.PATH_BASE + "adminlte3/js/adminlte.js",
    ew.PATH_BASE + "bootstrap4/js/bootstrap.bundle.min.js",
    ew.PATH_BASE + "plugins/select2/js/select2.full.min.js",
    ew.PATH_BASE + "jquery/jqueryfileupload.min.js",
    ew.PATH_BASE + "jquery/typeahead.jquery.min.js"
];
jqueryjs.push(ew.PATH_BASE + "colorbox/jquery.colorbox-min.js");
jqueryjs.push(ew.PATH_BASE + "js/pdfobject.min.js");
ew.ready(["jquery", "widget", "scrollbars", "moment", "others"], [jqueryjs, ew.PATH_BASE + "js/ew.min.js"], "makerjs");
ew.ready("makerjs", [
    cssjs,
    ew.PATH_BASE + "js/userfn.js",
    ew.PATH_BASE + "js/userevent.js"
], "head");
</script>
<script>
loadjs(ew.PATH_BASE + "css/tempusdominus-bootstrap-4.css");
ew.ready("head", [ew.PATH_BASE + "js/tempusdominus-bootstrap-4.js", ew.PATH_BASE + "js/ewdatetimepicker.js"], "datetimepicker");
loadjs.ready("datetimepicker", function() {
    var $= jQuery;
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'fas fa-trash',
            close: 'fas fa-times'
        }
    });
});
</script>
<script>
ew.ready("head", [ew.PATH_BASE + "ckeditor/ckeditor.js", ew.PATH_BASE + "js/eweditor.js"], "editor");
</script>
<!-- Navbar -->
<script type="text/html" id="navbar-menu-items" class="ew-js-template" data-name="navbar" data-seq="10" data-data="navbar" data-method="appendTo" data-target="#ew-navbar">
{{if items}}
    {{for items}}
        <li id="{{:id}}" name="{{:name}}" class="{{if parentId == -1}}nav-item ew-navbar-item{{/if}}{{if isHeader && parentId > -1}}dropdown-header{{/if}}{{if items}} dropdown{{/if}}{{if items && parentId != -1}} dropdown-submenu{{/if}}{{if items && level == 1}} dropdown-hover{{/if}} d-none d-md-block">
            {{if isHeader && parentId > -1}}
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
            {{else}}
            <a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}} class="{{if parentId == -1}}nav-link{{else}}dropdown-item{{/if}}{{if active}} active{{/if}}{{if items}} dropdown-toggle ew-dropdown{{/if}}"{{if items}} role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"{{/if}}>
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
            </a>
            {{/if}}
            {{if items}}
            <ul class="dropdown-menu">
                {{include tmpl="#navbar-menu-items"/}}
            </ul>
            {{/if}}
        </li>
    {{/for}}
{{/if}}
</script>
<!-- Sidebar -->
<script type="text/html" class="ew-js-template" data-name="menu" data-seq="10" data-data="menu" data-target="#ew-menu">
{{if items}}
    <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="{{:accordion}}">
    {{include tmpl="#menu-items"/}}
    </ul>
{{/if}}
</script>
<script type="text/html" id="menu-items">
{{if items}}
    {{for items}}
        <li id="{{:id}}" name="{{:name}}" class="{{if isHeader}}nav-header{{else}}nav-item{{if items}} has-treeview{{/if}}{{if active}} active current{{/if}}{{if open}} menu-open{{/if}}{{/if}}{{if isNavbarItem}} d-block d-md-none{{/if}}">
            {{if isHeader}}
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
                {{if label}}
                <span class="right">
                    {{:label}}
                </span>
                {{/if}}
            {{else}}
            <a href="{{:href}}" class="nav-link{{if active}} active{{/if}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}}>
                {{if icon}}<i class="nav-icon {{:icon}}"></i>{{/if}}
                <p><span class="menu-item-text">{{:text}}</span>
                    {{if items}}
                        <i class="right fas fa-angle-left"></i>
                        {{if label}}
                            <span class="right">
                                {{:label}}
                            </span>
                        {{/if}}
                    {{else}}
                        {{if label}}
                            <span class="right">
                                {{:label}}
                            </span>
                        {{/if}}
                    {{/if}}
                </p>
            </a>
            {{/if}}
            {{if items}}
            <ul class="nav nav-treeview"{{if open}} style="display: block;"{{/if}}>
                {{include tmpl="#menu-items"/}}
            </ul>
            {{/if}}
        </li>
    {{/for}}
{{/if}}
</script>
<script type="text/html" class="ew-js-template" data-name="languages" data-seq="10" data-data="languages" data-method="<?= $Language->Method ?>" data-target="<?= HtmlEncode($Language->Target) ?>">
<?= $Language->getTemplate() ?>
</script>
<script type="text/html" class="ew-js-template" data-name="login" data-seq="10" data-data="login" data-method="appendTo" data-target=".navbar-nav.ml-auto">
{{if isLoggedIn}}
<li class="nav-item dropdown text-body">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-item p-3"><i class="fas fa-user mr-2"></i>{{:currentUserName}}</div>
        {{if (hasPersonalData || canChangePassword)}}
        <div class="dropdown-divider"></div>
        <div class="text-nowrap p-3">
            {{if hasPersonalData}}
            <a class="btn btn-default" href="#" onclick="{{:personalDataUrl}}">{{:personalDataText}}</a>
            {{/if}}
            {{if canChangePassword}}
            <a class="btn btn-default" href="#" onclick="{{:changePasswordUrl}}">{{:changePasswordText}}</a>
            {{/if}}
        </div>
        {{/if}}
        {{if canLogout}}
        <div class="dropdown-divider"></div>
        <div class="dropdown-footer p-2 text-right">
            <a class="btn btn-default" href="#" onclick="{{:logoutUrl}}">{{:logoutText}}</a>
        </div>
        {{/if}}
    </div>
<li>
{{else}}
    {{if canLogin}}
<li class="nav-item"><a class="nav-link" href="#" onclick="{{:loginUrl}}">{{:loginText}}</a></li>
    {{/if}}
{{/if}}
</script>
<?php } ?>
<meta name="generator" content="PHPMaker 2021.0.8">
</head>
<body class="<?= Config("BODY_CLASS") ?>" dir="<?= IsRTL() ? "rtl" : "ltr" ?>">
<?php if (@!$SkipHeaderFooter) { ?>
<?php if (!IsExport()) { ?>
<div class="wrapper ew-layout">
    <!-- Main Header -->
    <!-- Navbar -->
    <nav class="<?= Config("NAVBAR_CLASS") ?>">
        <!-- Left navbar links -->
        <ul id="ew-navbar" class="navbar-nav">
            <li class="nav-item d-block">
                <a class="nav-link" data-widget="pushmenu" data-enable-remember="true" href="#" onclick="return false;"><i class="fas fa-bars"></i></a>
            </li>
            <a class="navbar-brand d-none" href="#"  onclick="return false;">
                <span class="brand-text">MyITaudit</span>
            </a>
        </ul>
        <!-- Right navbar links -->
        <ul id="ew-navbar-right" class="navbar-nav ml-auto"></ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="<?= Config("SIDEBAR_CLASS") ?>">
        <!-- Brand Logo //** Note: Only licensed users are allowed to change the logo ** -->
        <a href="#" class="brand-link">
            <span class="brand-text">MyITaudit</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav id="ew-menu" class="mt-2"></nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
    <?php if (Config("PAGE_TITLE_STYLE") != "None") { ?>
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= CurrentPageHeading() ?> <small class="text-muted"><?= CurrentPageSubheading() ?></small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php Breadcrumb()->render() ?>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
    <?php } ?>
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
<?php } ?>
<?php } ?>
<?= $content ?>
<?php if (!IsExport()) { ?>
<?php if (@!$SkipHeaderFooter) { ?>
<?php
if (isset($DebugTimer)) {
    $DebugTimer->stop();
}
?>
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- ** Note: Only licensed users are allowed to change the copyright statement. ** -->
        <div class="ew-footer-text"><?= $Language->projectPhrase("FooterText") ?></div>
        <div class="float-right d-none d-sm-inline-block"></div>
    </footer>
</div>
<!-- ./wrapper -->
<?php } ?>
<script>
loadjs.done("wrapper");
</script>
<!-- template upload (for file upload) -->
<script id="template-upload" type="text/html">
{{for files}}
    <tr class="template-upload">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{{:name}}</p>
            <p class="error"></p>
        </td>
        <td>
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar bg-success" style="width: 0%;"></div></div>
        </td>
        <td>
            {{if !#index && !~root.options.autoUpload}}
            <button class="btn btn-default btn-sm start" disabled><?= $Language->phrase("UploadStart") ?></button>
            {{/if}}
            {{if !#index}}
            <button class="btn btn-default btn-sm cancel"><?= $Language->phrase("UploadCancel") ?></button>
            {{/if}}
        </td>
    </tr>
{{/for}}
</script>
<!-- template download (for file upload) -->
<script id="template-download" type="text/html">
{{for files}}
    <tr class="template-download">
        <td>
            <span class="preview">
                {{if !exists}}
                <span class="error"><?= $Language->phrase("FileNotFound") ?></span>
                {{else url && extension == "pdf"}}
                <div class="ew-pdfobject" data-url="{{>url}}" style="width: <?= Config("UPLOAD_THUMBNAIL_WIDTH") ?>px;"></div>
                {{else url && extension == "mp3"}}
                <audio controls><source type="audio/mpeg" src="{{>url}}"></audio>
                {{else url && extension == "mp4"}}
                <video controls><source type="video/mp4" src="{{>url}}"></video>
                {{else thumbnailUrl}}
                <a href="{{>url}}" title="{{>name}}" download="{{>name}}" class="ew-lightbox"><img class="ew-lazy" loading="lazy" src="{{>thumbnailUrl}}"></a>
                {{/if}}
            </span>
        </td>
        <td>
            <p class="name">
                {{if !exists}}
                <span class="text-muted">{{:name}}</span>
                {{else url && (extension == "pdf" || thumbnailUrl) && extension != "mp3" && extension != "mp4"}}
                <a href="{{>url}}" title="{{>name}}" target="_blank">{{:name}}</a>
                {{else url}}
                <a href="{{>url}}" title="{{>name}}" download="{{>name}}">{{:name}}</a>
                {{else}}
                <span>{{:name}}</span>
                {{/if}}
            </p>
            {{if error}}
            <div><span class="error">{{:error}}</span></div>
            {{/if}}
        </td>
        <td>
            <span class="size">{{:~root.formatFileSize(size)}}</span>
        </td>
        <td>
            {{if !~root.options.readOnly && deleteUrl}}
            <button class="btn btn-default btn-sm delete" data-type="{{>deleteType}}" data-url="{{>deleteUrl}}"><?= $Language->phrase("UploadDelete") ?></button>
            {{else !~root.options.readOnly}}
            <button class="btn btn-default btn-sm cancel"><?= $Language->phrase("UploadCancel") ?></button>
            {{/if}}
        </td>
    </tr>
{{/for}}
</script>
<!-- modal dialog -->
<div id="ew-modal-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- import dialog -->
<div id="ew-import-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div>
<div class="modal-body">
<div class="custom-file">
    <input type="file" class="custom-file-input" id="importfiles" title=" " name="importfiles[]" multiple lang="<?= CurrentLanguageID() ?>">
    <label class="custom-file-label ew-file-label" for="importfiles"><?= $Language->phrase("ChooseFiles") ?></label>
</div>
<div class="message d-none mt-3"></div>
<div class="progress d-none mt-3"><div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default ew-close-btn" data-dismiss="modal"><?= $Language->phrase("CloseBtn") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ew-tooltip"></div>
<!-- drill down -->
<div id="ew-drilldown-panel"></div>
<?php } ?>
<script>
loadjs.ready(ew.bundleIds, function() {
    if (!loadjs.isDefined("foot"))
        loadjs.done("foot");
});
</script>
</body>
</html>
