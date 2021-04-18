<?php
/**
 * PHPMaker 2021 user level settings
 */
namespace PHPMaker2021\ITaudit_backoffice_v2;

// User level info
$USER_LEVELS = [["-2","Anonymous"]];
// User level priv info
$USER_LEVEL_PRIVS = [["{1024BC10-9A54-4DA5-B125-D34011650EC0}applications","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}categories","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}cis_refs","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}employees","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}failed_jobs","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}functions","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}informations","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}inventories","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}layers","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}question_target_profiles","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}risk_librairies","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}risk_registers","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}sub_categories","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}users","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs_controlfamily","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_cis_links","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_nist_links","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_controlarea","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_family","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}iso27001_refs","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_iso27001_links","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}questions_library","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}cis_refs_controlfamily","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_refs","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}subcat_cobit_links","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_family","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_refs_controlarea","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}nist-subcat","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}cobit5_area","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}Dashboard1","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}nist_to_iso27001","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}question_controlobjectives","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}question_domains","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}impact_areas","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}threats","-2","0"],
    ["{1024BC10-9A54-4DA5-B125-D34011650EC0}question_areas","-2","0"]];
// User level table info
$USER_LEVEL_TABLES = [["applications","applications","applications",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["categories","categories","categories",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","CategoriesList"],
    ["cis_refs","cis_refs","cis refs",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","CisRefsList"],
    ["employees","employees","employees",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["failed_jobs","failed_jobs","failed jobs",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["functions","functions","functions",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","FunctionsList"],
    ["informations","informations","informations",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","InformationsList"],
    ["inventories","inventories","inventories",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","InventoriesList"],
    ["layers","layers","layers",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","LayersList"],
    ["nist_refs","nist_refs","nist refs",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","NistRefsList"],
    ["question_target_profiles","question_target_profiles","question target profiles",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","QuestionTargetProfilesList"],
    ["risk_librairies","risk_librairies","risk librairies",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","RiskLibrairiesList"],
    ["risk_registers","risk_registers","risk registers",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["sub_categories","sub_categories","sub categories",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","SubCategoriesList"],
    ["users","users","users",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["nist_refs_controlfamily","nist_refs_controlfamily","nist refs controlfamily",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","NistRefsControlfamilyList"],
    ["subcat_cis_links","subcat_cis_links","subcat cis links",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","SubcatCisLinksList"],
    ["subcat_nist_links","subcat_nist_links","subcat nist links",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","SubcatNistLinksList"],
    ["iso27001_controlarea","iso27001_controlarea","iso 27001 controlarea",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Iso27001ControlareaList"],
    ["iso27001_family","iso27001_family","iso 27001 family",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Iso27001FamilyList"],
    ["iso27001_refs","iso27001_refs","iso 27001 refs",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Iso27001RefsList"],
    ["subcat_iso27001_links","subcat_iso27001_links","subcat iso 27001 links",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","SubcatIso27001LinksList"],
    ["questions_library","questions_library","questions library",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","QuestionsLibraryList"],
    ["cis_refs_controlfamily","cis_refs_controlfamily","cis refs controlfamily",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","CisRefsControlfamilyList"],
    ["cobit5_refs","cobit5_refs","cobit 5 refs",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Cobit5RefsList"],
    ["subcat_cobit_links","subcat_cobit_links","subcat cobit links",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","SubcatCobitLinksList"],
    ["cobit5_family","cobit5_family","cobit 5 family",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Cobit5FamilyList"],
    ["nist_refs_controlarea","nist_refs_controlarea","nist refs controlarea",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","NistRefsControlareaList"],
    ["nist-subcat","nistsubcat","nist subcat",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["cobit5_area","cobit5_area","cobit 5 area",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","Cobit5AreaList"],
    ["Dashboard1","Dashboard1","Dashboard 1",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}",""],
    ["nist_to_iso27001","nist_to_iso27001","nist to iso 27001",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","NistToIso27001List"],
    ["question_controlobjectives","question_controlobjectives","question controlobjectives",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","QuestionControlobjectivesList"],
    ["question_domains","question_domains","question domains",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","QuestionDomainsList"],
    ["impact_areas","impact_areas","impact areas",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","ImpactAreasList"],
    ["threats","threats","threats",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","ThreatsList"],
    ["question_areas","question_areas","question areas",true,"{1024BC10-9A54-4DA5-B125-D34011650EC0}","QuestionAreasList"]];