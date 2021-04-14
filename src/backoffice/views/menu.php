<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(33, "mci_REFERENCES", $MenuLanguage->MenuPhrase("33", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(34, "mci_ISO27001", $MenuLanguage->MenuPhrase("34", "MenuText"), "", 33, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(15, "mi_iso27001_controlarea", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "Iso27001ControlareaList", 34, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_controlarea'), false, false, "", "", false);
$sideMenu->addMenuItem(16, "mi_iso27001_family", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "Iso27001FamilyList?cmd=resetall", 34, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_family'), false, false, "", "", false);
$sideMenu->addMenuItem(17, "mi_iso27001_refs", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "Iso27001RefsList?cmd=resetall", 34, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_refs'), false, false, "", "", false);
$sideMenu->addMenuItem(18, "mi_subcat_iso27001_links", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "SubcatIso27001LinksList?cmd=resetall", 34, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_iso27001_links'), false, false, "", "", false);
$sideMenu->addMenuItem(35, "mci_NIST_SP800-53rev5", $MenuLanguage->MenuPhrase("35", "MenuText"), "", 33, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(66, "mi_nist_refs_controlarea", $MenuLanguage->MenuPhrase("66", "MenuText"), $MenuRelativePath . "NistRefsControlareaList", 35, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs_controlarea'), false, false, "", "", false);
$sideMenu->addMenuItem(12, "mi_nist_refs_controlfamily", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "NistRefsControlfamilyList?cmd=resetall", 35, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs_controlfamily'), false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_nist_refs", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "NistRefsList?cmd=resetall", 35, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs'), false, false, "", "", false);
$sideMenu->addMenuItem(13, "mi_subcat_nist_links", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "SubcatNistLinksList?cmd=resetall", 35, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_nist_links'), false, false, "", "", false);
$sideMenu->addMenuItem(70, "mi_nist_to_iso27001", $MenuLanguage->MenuPhrase("70", "MenuText"), $MenuRelativePath . "NistToIso27001List?cmd=resetall", 35, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_to_iso27001'), false, false, "", "", false);
$sideMenu->addMenuItem(36, "mci_CIS_CSC_7.1", $MenuLanguage->MenuPhrase("36", "MenuText"), "", 33, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(40, "mi_cis_refs_controlfamily", $MenuLanguage->MenuPhrase("40", "MenuText"), $MenuRelativePath . "CisRefsControlfamilyList", 36, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}cis_refs_controlfamily'), false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_cis_refs", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "CisRefsList?cmd=resetall", 36, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}cis_refs'), false, false, "", "", false);
$sideMenu->addMenuItem(14, "mi_subcat_cis_links", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "SubcatCisLinksList?cmd=resetall", 36, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_cis_links'), false, false, "", "", false);
$sideMenu->addMenuItem(64, "mci_COBIT5", $MenuLanguage->MenuPhrase("64", "MenuText"), "", 33, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(68, "mi_cobit5_area", $MenuLanguage->MenuPhrase("68", "MenuText"), $MenuRelativePath . "Cobit5AreaList", 64, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_area'), false, false, "", "", false);
$sideMenu->addMenuItem(46, "mi_cobit5_family", $MenuLanguage->MenuPhrase("46", "MenuText"), $MenuRelativePath . "Cobit5FamilyList?cmd=resetall", 64, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_family'), false, false, "", "", false);
$sideMenu->addMenuItem(43, "mi_cobit5_refs", $MenuLanguage->MenuPhrase("43", "MenuText"), $MenuRelativePath . "Cobit5RefsList?cmd=resetall", 64, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_refs'), false, false, "", "", false);
$sideMenu->addMenuItem(44, "mi_subcat_cobit_links", $MenuLanguage->MenuPhrase("44", "MenuText"), $MenuRelativePath . "SubcatCobitLinksList?cmd=resetall", 64, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_cobit_links'), false, false, "", "", false);
$sideMenu->addMenuItem(37, "mci_NIST_CSF_FRAMEWORK", $MenuLanguage->MenuPhrase("37", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(2, "mi_functions", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "FunctionsList", 37, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}functions'), false, false, "", "", false);
$sideMenu->addMenuItem(1, "mi_categories", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "CategoriesList?cmd=resetall", 37, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}categories'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_sub_categories", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "SubCategoriesList?cmd=resetall", 37, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}sub_categories'), false, false, "", "", false);
$sideMenu->addMenuItem(38, "mci_ASSESSMENT_and_RISK", $MenuLanguage->MenuPhrase("38", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(106, "mci_QUESTIONS", $MenuLanguage->MenuPhrase("106", "MenuText"), "", 38, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(152, "mi_question_areas", $MenuLanguage->MenuPhrase("152", "MenuText"), $MenuRelativePath . "QuestionAreasList", 106, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}question_areas'), false, false, "", "", false);
$sideMenu->addMenuItem(74, "mi_question_domains", $MenuLanguage->MenuPhrase("74", "MenuText"), $MenuRelativePath . "QuestionDomainsList?cmd=resetall", 106, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}question_domains'), false, false, "", "", false);
$sideMenu->addMenuItem(73, "mi_question_controlobjectives", $MenuLanguage->MenuPhrase("73", "MenuText"), $MenuRelativePath . "QuestionControlobjectivesList?cmd=resetall", 106, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}question_controlobjectives'), false, false, "", "", false);
$sideMenu->addMenuItem(39, "mi_questions_library", $MenuLanguage->MenuPhrase("39", "MenuText"), $MenuRelativePath . "QuestionsLibraryList?cmd=resetall", 106, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}questions_library'), false, false, "", "", false);
$sideMenu->addMenuItem(151, "mci_RISK", $MenuLanguage->MenuPhrase("151", "MenuText"), "", 38, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(8, "mi_risk_librairies", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "RiskLibrairiesList?cmd=resetall", 151, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}risk_librairies'), false, false, "", "", false);
$sideMenu->addMenuItem(111, "mi_threats", $MenuLanguage->MenuPhrase("111", "MenuText"), $MenuRelativePath . "ThreatsList", 151, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}threats'), false, false, "", "", false);
$sideMenu->addMenuItem(112, "mi_impact_areas", $MenuLanguage->MenuPhrase("112", "MenuText"), $MenuRelativePath . "ImpactAreasList", 151, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}impact_areas'), false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_layers", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "LayersList", 38, "", IsLoggedIn() || AllowListMenu('{1024BC10-9A54-4DA5-B125-D34011650EC0}layers'), false, false, "", "", false);
echo $sideMenu->toScript();
