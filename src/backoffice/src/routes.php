<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // categories
    $app->any('/CategoriesList[/{code_nist}]', CategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('CategoriesList-categories-list'); // list
    $app->any('/CategoriesAdd[/{code_nist}]', CategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('CategoriesAdd-categories-add'); // add
    $app->any('/CategoriesView[/{code_nist}]', CategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('CategoriesView-categories-view'); // view
    $app->any('/CategoriesEdit[/{code_nist}]', CategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('CategoriesEdit-categories-edit'); // edit
    $app->any('/CategoriesDelete[/{code_nist}]', CategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('CategoriesDelete-categories-delete'); // delete
    $app->group(
        '/categories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code_nist}]', CategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('categories/list-categories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code_nist}]', CategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('categories/add-categories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code_nist}]', CategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('categories/view-categories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code_nist}]', CategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('categories/edit-categories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code_nist}]', CategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('categories/delete-categories-delete-2'); // delete
        }
    );

    // cis_refs
    $app->any('/CisRefsList[/{Nidentifier}]', CisRefsController::class . ':list')->add(PermissionMiddleware::class)->setName('CisRefsList-cis_refs-list'); // list
    $app->any('/CisRefsAdd[/{Nidentifier}]', CisRefsController::class . ':add')->add(PermissionMiddleware::class)->setName('CisRefsAdd-cis_refs-add'); // add
    $app->any('/CisRefsView[/{Nidentifier}]', CisRefsController::class . ':view')->add(PermissionMiddleware::class)->setName('CisRefsView-cis_refs-view'); // view
    $app->any('/CisRefsEdit[/{Nidentifier}]', CisRefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('CisRefsEdit-cis_refs-edit'); // edit
    $app->any('/CisRefsDelete[/{Nidentifier}]', CisRefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('CisRefsDelete-cis_refs-delete'); // delete
    $app->group(
        '/cis_refs',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Nidentifier}]', CisRefsController::class . ':list')->add(PermissionMiddleware::class)->setName('cis_refs/list-cis_refs-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Nidentifier}]', CisRefsController::class . ':add')->add(PermissionMiddleware::class)->setName('cis_refs/add-cis_refs-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Nidentifier}]', CisRefsController::class . ':view')->add(PermissionMiddleware::class)->setName('cis_refs/view-cis_refs-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Nidentifier}]', CisRefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('cis_refs/edit-cis_refs-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Nidentifier}]', CisRefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('cis_refs/delete-cis_refs-delete-2'); // delete
        }
    );

    // functions
    $app->any('/FunctionsList[/{id}]', FunctionsController::class . ':list')->add(PermissionMiddleware::class)->setName('FunctionsList-functions-list'); // list
    $app->any('/FunctionsAdd[/{id}]', FunctionsController::class . ':add')->add(PermissionMiddleware::class)->setName('FunctionsAdd-functions-add'); // add
    $app->any('/FunctionsView[/{id}]', FunctionsController::class . ':view')->add(PermissionMiddleware::class)->setName('FunctionsView-functions-view'); // view
    $app->any('/FunctionsEdit[/{id}]', FunctionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('FunctionsEdit-functions-edit'); // edit
    $app->any('/FunctionsDelete[/{id}]', FunctionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('FunctionsDelete-functions-delete'); // delete
    $app->group(
        '/functions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', FunctionsController::class . ':list')->add(PermissionMiddleware::class)->setName('functions/list-functions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', FunctionsController::class . ':add')->add(PermissionMiddleware::class)->setName('functions/add-functions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', FunctionsController::class . ':view')->add(PermissionMiddleware::class)->setName('functions/view-functions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', FunctionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('functions/edit-functions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', FunctionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('functions/delete-functions-delete-2'); // delete
        }
    );

    // informations
    $app->any('/InformationsList[/{id}]', InformationsController::class . ':list')->add(PermissionMiddleware::class)->setName('InformationsList-informations-list'); // list
    $app->any('/InformationsAdd[/{id}]', InformationsController::class . ':add')->add(PermissionMiddleware::class)->setName('InformationsAdd-informations-add'); // add
    $app->any('/InformationsView[/{id}]', InformationsController::class . ':view')->add(PermissionMiddleware::class)->setName('InformationsView-informations-view'); // view
    $app->any('/InformationsEdit[/{id}]', InformationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('InformationsEdit-informations-edit'); // edit
    $app->any('/InformationsDelete[/{id}]', InformationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('InformationsDelete-informations-delete'); // delete
    $app->group(
        '/informations',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', InformationsController::class . ':list')->add(PermissionMiddleware::class)->setName('informations/list-informations-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', InformationsController::class . ':add')->add(PermissionMiddleware::class)->setName('informations/add-informations-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', InformationsController::class . ':view')->add(PermissionMiddleware::class)->setName('informations/view-informations-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', InformationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('informations/edit-informations-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', InformationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('informations/delete-informations-delete-2'); // delete
        }
    );

    // inventories
    $app->any('/InventoriesList[/{id}]', InventoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('InventoriesList-inventories-list'); // list
    $app->any('/InventoriesAdd[/{id}]', InventoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('InventoriesAdd-inventories-add'); // add
    $app->any('/InventoriesView[/{id}]', InventoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('InventoriesView-inventories-view'); // view
    $app->any('/InventoriesEdit[/{id}]', InventoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('InventoriesEdit-inventories-edit'); // edit
    $app->any('/InventoriesDelete[/{id}]', InventoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('InventoriesDelete-inventories-delete'); // delete
    $app->group(
        '/inventories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', InventoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('inventories/list-inventories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', InventoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('inventories/add-inventories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', InventoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('inventories/view-inventories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', InventoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('inventories/edit-inventories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', InventoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('inventories/delete-inventories-delete-2'); // delete
        }
    );

    // layers
    $app->any('/LayersList[/{name}]', LayersController::class . ':list')->add(PermissionMiddleware::class)->setName('LayersList-layers-list'); // list
    $app->any('/LayersAdd[/{name}]', LayersController::class . ':add')->add(PermissionMiddleware::class)->setName('LayersAdd-layers-add'); // add
    $app->any('/LayersView[/{name}]', LayersController::class . ':view')->add(PermissionMiddleware::class)->setName('LayersView-layers-view'); // view
    $app->any('/LayersEdit[/{name}]', LayersController::class . ':edit')->add(PermissionMiddleware::class)->setName('LayersEdit-layers-edit'); // edit
    $app->any('/LayersDelete[/{name}]', LayersController::class . ':delete')->add(PermissionMiddleware::class)->setName('LayersDelete-layers-delete'); // delete
    $app->group(
        '/layers',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{name}]', LayersController::class . ':list')->add(PermissionMiddleware::class)->setName('layers/list-layers-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{name}]', LayersController::class . ':add')->add(PermissionMiddleware::class)->setName('layers/add-layers-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{name}]', LayersController::class . ':view')->add(PermissionMiddleware::class)->setName('layers/view-layers-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{name}]', LayersController::class . ':edit')->add(PermissionMiddleware::class)->setName('layers/edit-layers-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{name}]', LayersController::class . ':delete')->add(PermissionMiddleware::class)->setName('layers/delete-layers-delete-2'); // delete
        }
    );

    // nist_refs
    $app->any('/NistRefsList[/{Nidentifier}]', NistRefsController::class . ':list')->add(PermissionMiddleware::class)->setName('NistRefsList-nist_refs-list'); // list
    $app->any('/NistRefsAdd[/{Nidentifier}]', NistRefsController::class . ':add')->add(PermissionMiddleware::class)->setName('NistRefsAdd-nist_refs-add'); // add
    $app->any('/NistRefsView[/{Nidentifier}]', NistRefsController::class . ':view')->add(PermissionMiddleware::class)->setName('NistRefsView-nist_refs-view'); // view
    $app->any('/NistRefsEdit[/{Nidentifier}]', NistRefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('NistRefsEdit-nist_refs-edit'); // edit
    $app->any('/NistRefsDelete[/{Nidentifier}]', NistRefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('NistRefsDelete-nist_refs-delete'); // delete
    $app->group(
        '/nist_refs',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{Nidentifier}]', NistRefsController::class . ':list')->add(PermissionMiddleware::class)->setName('nist_refs/list-nist_refs-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{Nidentifier}]', NistRefsController::class . ':add')->add(PermissionMiddleware::class)->setName('nist_refs/add-nist_refs-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{Nidentifier}]', NistRefsController::class . ':view')->add(PermissionMiddleware::class)->setName('nist_refs/view-nist_refs-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{Nidentifier}]', NistRefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('nist_refs/edit-nist_refs-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{Nidentifier}]', NistRefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('nist_refs/delete-nist_refs-delete-2'); // delete
        }
    );

    // question_target_profiles
    $app->any('/QuestionTargetProfilesList[/{id}]', QuestionTargetProfilesController::class . ':list')->add(PermissionMiddleware::class)->setName('QuestionTargetProfilesList-question_target_profiles-list'); // list
    $app->any('/QuestionTargetProfilesAdd[/{id}]', QuestionTargetProfilesController::class . ':add')->add(PermissionMiddleware::class)->setName('QuestionTargetProfilesAdd-question_target_profiles-add'); // add
    $app->any('/QuestionTargetProfilesView[/{id}]', QuestionTargetProfilesController::class . ':view')->add(PermissionMiddleware::class)->setName('QuestionTargetProfilesView-question_target_profiles-view'); // view
    $app->any('/QuestionTargetProfilesEdit[/{id}]', QuestionTargetProfilesController::class . ':edit')->add(PermissionMiddleware::class)->setName('QuestionTargetProfilesEdit-question_target_profiles-edit'); // edit
    $app->any('/QuestionTargetProfilesDelete[/{id}]', QuestionTargetProfilesController::class . ':delete')->add(PermissionMiddleware::class)->setName('QuestionTargetProfilesDelete-question_target_profiles-delete'); // delete
    $app->group(
        '/question_target_profiles',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', QuestionTargetProfilesController::class . ':list')->add(PermissionMiddleware::class)->setName('question_target_profiles/list-question_target_profiles-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', QuestionTargetProfilesController::class . ':add')->add(PermissionMiddleware::class)->setName('question_target_profiles/add-question_target_profiles-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', QuestionTargetProfilesController::class . ':view')->add(PermissionMiddleware::class)->setName('question_target_profiles/view-question_target_profiles-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', QuestionTargetProfilesController::class . ':edit')->add(PermissionMiddleware::class)->setName('question_target_profiles/edit-question_target_profiles-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', QuestionTargetProfilesController::class . ':delete')->add(PermissionMiddleware::class)->setName('question_target_profiles/delete-question_target_profiles-delete-2'); // delete
        }
    );

    // risk_librairies
    $app->any('/RiskLibrairiesList[/{id}]', RiskLibrairiesController::class . ':list')->add(PermissionMiddleware::class)->setName('RiskLibrairiesList-risk_librairies-list'); // list
    $app->any('/RiskLibrairiesAdd[/{id}]', RiskLibrairiesController::class . ':add')->add(PermissionMiddleware::class)->setName('RiskLibrairiesAdd-risk_librairies-add'); // add
    $app->any('/RiskLibrairiesView[/{id}]', RiskLibrairiesController::class . ':view')->add(PermissionMiddleware::class)->setName('RiskLibrairiesView-risk_librairies-view'); // view
    $app->any('/RiskLibrairiesEdit[/{id}]', RiskLibrairiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('RiskLibrairiesEdit-risk_librairies-edit'); // edit
    $app->any('/RiskLibrairiesDelete[/{id}]', RiskLibrairiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('RiskLibrairiesDelete-risk_librairies-delete'); // delete
    $app->group(
        '/risk_librairies',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', RiskLibrairiesController::class . ':list')->add(PermissionMiddleware::class)->setName('risk_librairies/list-risk_librairies-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', RiskLibrairiesController::class . ':add')->add(PermissionMiddleware::class)->setName('risk_librairies/add-risk_librairies-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', RiskLibrairiesController::class . ':view')->add(PermissionMiddleware::class)->setName('risk_librairies/view-risk_librairies-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', RiskLibrairiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('risk_librairies/edit-risk_librairies-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', RiskLibrairiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('risk_librairies/delete-risk_librairies-delete-2'); // delete
        }
    );

    // sub_categories
    $app->any('/SubCategoriesList[/{code_nist}]', SubCategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('SubCategoriesList-sub_categories-list'); // list
    $app->any('/SubCategoriesAdd[/{code_nist}]', SubCategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('SubCategoriesAdd-sub_categories-add'); // add
    $app->any('/SubCategoriesView[/{code_nist}]', SubCategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('SubCategoriesView-sub_categories-view'); // view
    $app->any('/SubCategoriesEdit[/{code_nist}]', SubCategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubCategoriesEdit-sub_categories-edit'); // edit
    $app->any('/SubCategoriesDelete[/{code_nist}]', SubCategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubCategoriesDelete-sub_categories-delete'); // delete
    $app->group(
        '/sub_categories',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code_nist}]', SubCategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('sub_categories/list-sub_categories-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code_nist}]', SubCategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('sub_categories/add-sub_categories-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code_nist}]', SubCategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('sub_categories/view-sub_categories-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code_nist}]', SubCategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('sub_categories/edit-sub_categories-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code_nist}]', SubCategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('sub_categories/delete-sub_categories-delete-2'); // delete
        }
    );

    // nist_refs_controlfamily
    $app->any('/NistRefsControlfamilyList[/{code}]', NistRefsControlfamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('NistRefsControlfamilyList-nist_refs_controlfamily-list'); // list
    $app->any('/NistRefsControlfamilyAdd[/{code}]', NistRefsControlfamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('NistRefsControlfamilyAdd-nist_refs_controlfamily-add'); // add
    $app->any('/NistRefsControlfamilyView[/{code}]', NistRefsControlfamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('NistRefsControlfamilyView-nist_refs_controlfamily-view'); // view
    $app->any('/NistRefsControlfamilyEdit[/{code}]', NistRefsControlfamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('NistRefsControlfamilyEdit-nist_refs_controlfamily-edit'); // edit
    $app->any('/NistRefsControlfamilyDelete[/{code}]', NistRefsControlfamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('NistRefsControlfamilyDelete-nist_refs_controlfamily-delete'); // delete
    $app->group(
        '/nist_refs_controlfamily',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', NistRefsControlfamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('nist_refs_controlfamily/list-nist_refs_controlfamily-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', NistRefsControlfamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('nist_refs_controlfamily/add-nist_refs_controlfamily-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', NistRefsControlfamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('nist_refs_controlfamily/view-nist_refs_controlfamily-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', NistRefsControlfamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('nist_refs_controlfamily/edit-nist_refs_controlfamily-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', NistRefsControlfamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('nist_refs_controlfamily/delete-nist_refs_controlfamily-delete-2'); // delete
        }
    );

    // subcat_cis_links
    $app->any('/SubcatCisLinksList[/{id}]', SubcatCisLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('SubcatCisLinksList-subcat_cis_links-list'); // list
    $app->any('/SubcatCisLinksAdd[/{id}]', SubcatCisLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('SubcatCisLinksAdd-subcat_cis_links-add'); // add
    $app->any('/SubcatCisLinksView[/{id}]', SubcatCisLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('SubcatCisLinksView-subcat_cis_links-view'); // view
    $app->any('/SubcatCisLinksEdit[/{id}]', SubcatCisLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubcatCisLinksEdit-subcat_cis_links-edit'); // edit
    $app->any('/SubcatCisLinksDelete[/{id}]', SubcatCisLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubcatCisLinksDelete-subcat_cis_links-delete'); // delete
    $app->group(
        '/subcat_cis_links',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubcatCisLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('subcat_cis_links/list-subcat_cis_links-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubcatCisLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('subcat_cis_links/add-subcat_cis_links-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubcatCisLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('subcat_cis_links/view-subcat_cis_links-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubcatCisLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('subcat_cis_links/edit-subcat_cis_links-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubcatCisLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('subcat_cis_links/delete-subcat_cis_links-delete-2'); // delete
        }
    );

    // subcat_nist_links
    $app->any('/SubcatNistLinksList[/{id}]', SubcatNistLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('SubcatNistLinksList-subcat_nist_links-list'); // list
    $app->any('/SubcatNistLinksAdd[/{id}]', SubcatNistLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('SubcatNistLinksAdd-subcat_nist_links-add'); // add
    $app->any('/SubcatNistLinksView[/{id}]', SubcatNistLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('SubcatNistLinksView-subcat_nist_links-view'); // view
    $app->any('/SubcatNistLinksEdit[/{id}]', SubcatNistLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubcatNistLinksEdit-subcat_nist_links-edit'); // edit
    $app->any('/SubcatNistLinksDelete[/{id}]', SubcatNistLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubcatNistLinksDelete-subcat_nist_links-delete'); // delete
    $app->group(
        '/subcat_nist_links',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubcatNistLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('subcat_nist_links/list-subcat_nist_links-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubcatNistLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('subcat_nist_links/add-subcat_nist_links-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubcatNistLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('subcat_nist_links/view-subcat_nist_links-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubcatNistLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('subcat_nist_links/edit-subcat_nist_links-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubcatNistLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('subcat_nist_links/delete-subcat_nist_links-delete-2'); // delete
        }
    );

    // iso27001_controlarea
    $app->any('/Iso27001ControlareaList[/{control_area}]', Iso27001ControlareaController::class . ':list')->add(PermissionMiddleware::class)->setName('Iso27001ControlareaList-iso27001_controlarea-list'); // list
    $app->any('/Iso27001ControlareaAdd[/{control_area}]', Iso27001ControlareaController::class . ':add')->add(PermissionMiddleware::class)->setName('Iso27001ControlareaAdd-iso27001_controlarea-add'); // add
    $app->any('/Iso27001ControlareaView[/{control_area}]', Iso27001ControlareaController::class . ':view')->add(PermissionMiddleware::class)->setName('Iso27001ControlareaView-iso27001_controlarea-view'); // view
    $app->any('/Iso27001ControlareaEdit[/{control_area}]', Iso27001ControlareaController::class . ':edit')->add(PermissionMiddleware::class)->setName('Iso27001ControlareaEdit-iso27001_controlarea-edit'); // edit
    $app->any('/Iso27001ControlareaDelete[/{control_area}]', Iso27001ControlareaController::class . ':delete')->add(PermissionMiddleware::class)->setName('Iso27001ControlareaDelete-iso27001_controlarea-delete'); // delete
    $app->group(
        '/iso27001_controlarea',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{control_area}]', Iso27001ControlareaController::class . ':list')->add(PermissionMiddleware::class)->setName('iso27001_controlarea/list-iso27001_controlarea-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{control_area}]', Iso27001ControlareaController::class . ':add')->add(PermissionMiddleware::class)->setName('iso27001_controlarea/add-iso27001_controlarea-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{control_area}]', Iso27001ControlareaController::class . ':view')->add(PermissionMiddleware::class)->setName('iso27001_controlarea/view-iso27001_controlarea-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{control_area}]', Iso27001ControlareaController::class . ':edit')->add(PermissionMiddleware::class)->setName('iso27001_controlarea/edit-iso27001_controlarea-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{control_area}]', Iso27001ControlareaController::class . ':delete')->add(PermissionMiddleware::class)->setName('iso27001_controlarea/delete-iso27001_controlarea-delete-2'); // delete
        }
    );

    // iso27001_family
    $app->any('/Iso27001FamilyList[/{control_familyName}]', Iso27001FamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('Iso27001FamilyList-iso27001_family-list'); // list
    $app->any('/Iso27001FamilyAdd[/{control_familyName}]', Iso27001FamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('Iso27001FamilyAdd-iso27001_family-add'); // add
    $app->any('/Iso27001FamilyView[/{control_familyName}]', Iso27001FamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('Iso27001FamilyView-iso27001_family-view'); // view
    $app->any('/Iso27001FamilyEdit[/{control_familyName}]', Iso27001FamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('Iso27001FamilyEdit-iso27001_family-edit'); // edit
    $app->any('/Iso27001FamilyDelete[/{control_familyName}]', Iso27001FamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('Iso27001FamilyDelete-iso27001_family-delete'); // delete
    $app->group(
        '/iso27001_family',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{control_familyName}]', Iso27001FamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('iso27001_family/list-iso27001_family-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{control_familyName}]', Iso27001FamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('iso27001_family/add-iso27001_family-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{control_familyName}]', Iso27001FamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('iso27001_family/view-iso27001_family-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{control_familyName}]', Iso27001FamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('iso27001_family/edit-iso27001_family-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{control_familyName}]', Iso27001FamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('iso27001_family/delete-iso27001_family-delete-2'); // delete
        }
    );

    // iso27001_refs
    $app->any('/Iso27001RefsList[/{code}]', Iso27001RefsController::class . ':list')->add(PermissionMiddleware::class)->setName('Iso27001RefsList-iso27001_refs-list'); // list
    $app->any('/Iso27001RefsAdd[/{code}]', Iso27001RefsController::class . ':add')->add(PermissionMiddleware::class)->setName('Iso27001RefsAdd-iso27001_refs-add'); // add
    $app->any('/Iso27001RefsView[/{code}]', Iso27001RefsController::class . ':view')->add(PermissionMiddleware::class)->setName('Iso27001RefsView-iso27001_refs-view'); // view
    $app->any('/Iso27001RefsEdit[/{code}]', Iso27001RefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('Iso27001RefsEdit-iso27001_refs-edit'); // edit
    $app->any('/Iso27001RefsDelete[/{code}]', Iso27001RefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('Iso27001RefsDelete-iso27001_refs-delete'); // delete
    $app->group(
        '/iso27001_refs',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', Iso27001RefsController::class . ':list')->add(PermissionMiddleware::class)->setName('iso27001_refs/list-iso27001_refs-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', Iso27001RefsController::class . ':add')->add(PermissionMiddleware::class)->setName('iso27001_refs/add-iso27001_refs-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', Iso27001RefsController::class . ':view')->add(PermissionMiddleware::class)->setName('iso27001_refs/view-iso27001_refs-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', Iso27001RefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('iso27001_refs/edit-iso27001_refs-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', Iso27001RefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('iso27001_refs/delete-iso27001_refs-delete-2'); // delete
        }
    );

    // subcat_iso27001_links
    $app->any('/SubcatIso27001LinksList[/{id}]', SubcatIso27001LinksController::class . ':list')->add(PermissionMiddleware::class)->setName('SubcatIso27001LinksList-subcat_iso27001_links-list'); // list
    $app->any('/SubcatIso27001LinksAdd[/{id}]', SubcatIso27001LinksController::class . ':add')->add(PermissionMiddleware::class)->setName('SubcatIso27001LinksAdd-subcat_iso27001_links-add'); // add
    $app->any('/SubcatIso27001LinksView[/{id}]', SubcatIso27001LinksController::class . ':view')->add(PermissionMiddleware::class)->setName('SubcatIso27001LinksView-subcat_iso27001_links-view'); // view
    $app->any('/SubcatIso27001LinksEdit[/{id}]', SubcatIso27001LinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubcatIso27001LinksEdit-subcat_iso27001_links-edit'); // edit
    $app->any('/SubcatIso27001LinksDelete[/{id}]', SubcatIso27001LinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubcatIso27001LinksDelete-subcat_iso27001_links-delete'); // delete
    $app->group(
        '/subcat_iso27001_links',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubcatIso27001LinksController::class . ':list')->add(PermissionMiddleware::class)->setName('subcat_iso27001_links/list-subcat_iso27001_links-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubcatIso27001LinksController::class . ':add')->add(PermissionMiddleware::class)->setName('subcat_iso27001_links/add-subcat_iso27001_links-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubcatIso27001LinksController::class . ':view')->add(PermissionMiddleware::class)->setName('subcat_iso27001_links/view-subcat_iso27001_links-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubcatIso27001LinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('subcat_iso27001_links/edit-subcat_iso27001_links-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubcatIso27001LinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('subcat_iso27001_links/delete-subcat_iso27001_links-delete-2'); // delete
        }
    );

    // questions_library
    $app->any('/QuestionsLibraryList[/{id}]', QuestionsLibraryController::class . ':list')->add(PermissionMiddleware::class)->setName('QuestionsLibraryList-questions_library-list'); // list
    $app->any('/QuestionsLibraryAdd[/{id}]', QuestionsLibraryController::class . ':add')->add(PermissionMiddleware::class)->setName('QuestionsLibraryAdd-questions_library-add'); // add
    $app->any('/QuestionsLibraryView[/{id}]', QuestionsLibraryController::class . ':view')->add(PermissionMiddleware::class)->setName('QuestionsLibraryView-questions_library-view'); // view
    $app->any('/QuestionsLibraryEdit[/{id}]', QuestionsLibraryController::class . ':edit')->add(PermissionMiddleware::class)->setName('QuestionsLibraryEdit-questions_library-edit'); // edit
    $app->any('/QuestionsLibraryDelete[/{id}]', QuestionsLibraryController::class . ':delete')->add(PermissionMiddleware::class)->setName('QuestionsLibraryDelete-questions_library-delete'); // delete
    $app->group(
        '/questions_library',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', QuestionsLibraryController::class . ':list')->add(PermissionMiddleware::class)->setName('questions_library/list-questions_library-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', QuestionsLibraryController::class . ':add')->add(PermissionMiddleware::class)->setName('questions_library/add-questions_library-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', QuestionsLibraryController::class . ':view')->add(PermissionMiddleware::class)->setName('questions_library/view-questions_library-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', QuestionsLibraryController::class . ':edit')->add(PermissionMiddleware::class)->setName('questions_library/edit-questions_library-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', QuestionsLibraryController::class . ':delete')->add(PermissionMiddleware::class)->setName('questions_library/delete-questions_library-delete-2'); // delete
        }
    );

    // cis_refs_controlfamily
    $app->any('/CisRefsControlfamilyList[/{code}]', CisRefsControlfamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('CisRefsControlfamilyList-cis_refs_controlfamily-list'); // list
    $app->any('/CisRefsControlfamilyAdd[/{code}]', CisRefsControlfamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('CisRefsControlfamilyAdd-cis_refs_controlfamily-add'); // add
    $app->any('/CisRefsControlfamilyView[/{code}]', CisRefsControlfamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('CisRefsControlfamilyView-cis_refs_controlfamily-view'); // view
    $app->any('/CisRefsControlfamilyEdit[/{code}]', CisRefsControlfamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('CisRefsControlfamilyEdit-cis_refs_controlfamily-edit'); // edit
    $app->any('/CisRefsControlfamilyDelete[/{code}]', CisRefsControlfamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('CisRefsControlfamilyDelete-cis_refs_controlfamily-delete'); // delete
    $app->group(
        '/cis_refs_controlfamily',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', CisRefsControlfamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('cis_refs_controlfamily/list-cis_refs_controlfamily-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', CisRefsControlfamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('cis_refs_controlfamily/add-cis_refs_controlfamily-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', CisRefsControlfamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('cis_refs_controlfamily/view-cis_refs_controlfamily-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', CisRefsControlfamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('cis_refs_controlfamily/edit-cis_refs_controlfamily-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', CisRefsControlfamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('cis_refs_controlfamily/delete-cis_refs_controlfamily-delete-2'); // delete
        }
    );

    // cobit5_refs
    $app->any('/Cobit5RefsList[/{NIdentifier}]', Cobit5RefsController::class . ':list')->add(PermissionMiddleware::class)->setName('Cobit5RefsList-cobit5_refs-list'); // list
    $app->any('/Cobit5RefsAdd[/{NIdentifier}]', Cobit5RefsController::class . ':add')->add(PermissionMiddleware::class)->setName('Cobit5RefsAdd-cobit5_refs-add'); // add
    $app->any('/Cobit5RefsView[/{NIdentifier}]', Cobit5RefsController::class . ':view')->add(PermissionMiddleware::class)->setName('Cobit5RefsView-cobit5_refs-view'); // view
    $app->any('/Cobit5RefsEdit[/{NIdentifier}]', Cobit5RefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('Cobit5RefsEdit-cobit5_refs-edit'); // edit
    $app->any('/Cobit5RefsDelete[/{NIdentifier}]', Cobit5RefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('Cobit5RefsDelete-cobit5_refs-delete'); // delete
    $app->group(
        '/cobit5_refs',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{NIdentifier}]', Cobit5RefsController::class . ':list')->add(PermissionMiddleware::class)->setName('cobit5_refs/list-cobit5_refs-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{NIdentifier}]', Cobit5RefsController::class . ':add')->add(PermissionMiddleware::class)->setName('cobit5_refs/add-cobit5_refs-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{NIdentifier}]', Cobit5RefsController::class . ':view')->add(PermissionMiddleware::class)->setName('cobit5_refs/view-cobit5_refs-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{NIdentifier}]', Cobit5RefsController::class . ':edit')->add(PermissionMiddleware::class)->setName('cobit5_refs/edit-cobit5_refs-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{NIdentifier}]', Cobit5RefsController::class . ':delete')->add(PermissionMiddleware::class)->setName('cobit5_refs/delete-cobit5_refs-delete-2'); // delete
        }
    );

    // subcat_cobit_links
    $app->any('/SubcatCobitLinksList[/{id}]', SubcatCobitLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('SubcatCobitLinksList-subcat_cobit_links-list'); // list
    $app->any('/SubcatCobitLinksAdd[/{id}]', SubcatCobitLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('SubcatCobitLinksAdd-subcat_cobit_links-add'); // add
    $app->any('/SubcatCobitLinksView[/{id}]', SubcatCobitLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('SubcatCobitLinksView-subcat_cobit_links-view'); // view
    $app->any('/SubcatCobitLinksEdit[/{id}]', SubcatCobitLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubcatCobitLinksEdit-subcat_cobit_links-edit'); // edit
    $app->any('/SubcatCobitLinksDelete[/{id}]', SubcatCobitLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubcatCobitLinksDelete-subcat_cobit_links-delete'); // delete
    $app->group(
        '/subcat_cobit_links',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', SubcatCobitLinksController::class . ':list')->add(PermissionMiddleware::class)->setName('subcat_cobit_links/list-subcat_cobit_links-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', SubcatCobitLinksController::class . ':add')->add(PermissionMiddleware::class)->setName('subcat_cobit_links/add-subcat_cobit_links-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', SubcatCobitLinksController::class . ':view')->add(PermissionMiddleware::class)->setName('subcat_cobit_links/view-subcat_cobit_links-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', SubcatCobitLinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('subcat_cobit_links/edit-subcat_cobit_links-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', SubcatCobitLinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('subcat_cobit_links/delete-subcat_cobit_links-delete-2'); // delete
        }
    );

    // cobit5_family
    $app->any('/Cobit5FamilyList[/{code}]', Cobit5FamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('Cobit5FamilyList-cobit5_family-list'); // list
    $app->any('/Cobit5FamilyAdd[/{code}]', Cobit5FamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('Cobit5FamilyAdd-cobit5_family-add'); // add
    $app->any('/Cobit5FamilyView[/{code}]', Cobit5FamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('Cobit5FamilyView-cobit5_family-view'); // view
    $app->any('/Cobit5FamilyEdit[/{code}]', Cobit5FamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('Cobit5FamilyEdit-cobit5_family-edit'); // edit
    $app->any('/Cobit5FamilyDelete[/{code}]', Cobit5FamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('Cobit5FamilyDelete-cobit5_family-delete'); // delete
    $app->group(
        '/cobit5_family',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', Cobit5FamilyController::class . ':list')->add(PermissionMiddleware::class)->setName('cobit5_family/list-cobit5_family-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', Cobit5FamilyController::class . ':add')->add(PermissionMiddleware::class)->setName('cobit5_family/add-cobit5_family-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', Cobit5FamilyController::class . ':view')->add(PermissionMiddleware::class)->setName('cobit5_family/view-cobit5_family-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', Cobit5FamilyController::class . ':edit')->add(PermissionMiddleware::class)->setName('cobit5_family/edit-cobit5_family-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', Cobit5FamilyController::class . ':delete')->add(PermissionMiddleware::class)->setName('cobit5_family/delete-cobit5_family-delete-2'); // delete
        }
    );

    // nist_refs_controlarea
    $app->any('/NistRefsControlareaList[/{code}]', NistRefsControlareaController::class . ':list')->add(PermissionMiddleware::class)->setName('NistRefsControlareaList-nist_refs_controlarea-list'); // list
    $app->any('/NistRefsControlareaAdd[/{code}]', NistRefsControlareaController::class . ':add')->add(PermissionMiddleware::class)->setName('NistRefsControlareaAdd-nist_refs_controlarea-add'); // add
    $app->any('/NistRefsControlareaView[/{code}]', NistRefsControlareaController::class . ':view')->add(PermissionMiddleware::class)->setName('NistRefsControlareaView-nist_refs_controlarea-view'); // view
    $app->any('/NistRefsControlareaEdit[/{code}]', NistRefsControlareaController::class . ':edit')->add(PermissionMiddleware::class)->setName('NistRefsControlareaEdit-nist_refs_controlarea-edit'); // edit
    $app->any('/NistRefsControlareaDelete[/{code}]', NistRefsControlareaController::class . ':delete')->add(PermissionMiddleware::class)->setName('NistRefsControlareaDelete-nist_refs_controlarea-delete'); // delete
    $app->group(
        '/nist_refs_controlarea',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', NistRefsControlareaController::class . ':list')->add(PermissionMiddleware::class)->setName('nist_refs_controlarea/list-nist_refs_controlarea-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', NistRefsControlareaController::class . ':add')->add(PermissionMiddleware::class)->setName('nist_refs_controlarea/add-nist_refs_controlarea-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', NistRefsControlareaController::class . ':view')->add(PermissionMiddleware::class)->setName('nist_refs_controlarea/view-nist_refs_controlarea-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', NistRefsControlareaController::class . ':edit')->add(PermissionMiddleware::class)->setName('nist_refs_controlarea/edit-nist_refs_controlarea-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', NistRefsControlareaController::class . ':delete')->add(PermissionMiddleware::class)->setName('nist_refs_controlarea/delete-nist_refs_controlarea-delete-2'); // delete
        }
    );

    // cobit5_area
    $app->any('/Cobit5AreaList[/{code}]', Cobit5AreaController::class . ':list')->add(PermissionMiddleware::class)->setName('Cobit5AreaList-cobit5_area-list'); // list
    $app->any('/Cobit5AreaAdd[/{code}]', Cobit5AreaController::class . ':add')->add(PermissionMiddleware::class)->setName('Cobit5AreaAdd-cobit5_area-add'); // add
    $app->any('/Cobit5AreaView[/{code}]', Cobit5AreaController::class . ':view')->add(PermissionMiddleware::class)->setName('Cobit5AreaView-cobit5_area-view'); // view
    $app->any('/Cobit5AreaEdit[/{code}]', Cobit5AreaController::class . ':edit')->add(PermissionMiddleware::class)->setName('Cobit5AreaEdit-cobit5_area-edit'); // edit
    $app->any('/Cobit5AreaDelete[/{code}]', Cobit5AreaController::class . ':delete')->add(PermissionMiddleware::class)->setName('Cobit5AreaDelete-cobit5_area-delete'); // delete
    $app->group(
        '/cobit5_area',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{code}]', Cobit5AreaController::class . ':list')->add(PermissionMiddleware::class)->setName('cobit5_area/list-cobit5_area-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{code}]', Cobit5AreaController::class . ':add')->add(PermissionMiddleware::class)->setName('cobit5_area/add-cobit5_area-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{code}]', Cobit5AreaController::class . ':view')->add(PermissionMiddleware::class)->setName('cobit5_area/view-cobit5_area-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{code}]', Cobit5AreaController::class . ':edit')->add(PermissionMiddleware::class)->setName('cobit5_area/edit-cobit5_area-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{code}]', Cobit5AreaController::class . ':delete')->add(PermissionMiddleware::class)->setName('cobit5_area/delete-cobit5_area-delete-2'); // delete
        }
    );

    // nist_to_iso27001
    $app->any('/NistToIso27001List[/{id}]', NistToIso27001Controller::class . ':list')->add(PermissionMiddleware::class)->setName('NistToIso27001List-nist_to_iso27001-list'); // list
    $app->any('/NistToIso27001Add[/{id}]', NistToIso27001Controller::class . ':add')->add(PermissionMiddleware::class)->setName('NistToIso27001Add-nist_to_iso27001-add'); // add
    $app->any('/NistToIso27001View[/{id}]', NistToIso27001Controller::class . ':view')->add(PermissionMiddleware::class)->setName('NistToIso27001View-nist_to_iso27001-view'); // view
    $app->any('/NistToIso27001Edit[/{id}]', NistToIso27001Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('NistToIso27001Edit-nist_to_iso27001-edit'); // edit
    $app->any('/NistToIso27001Delete[/{id}]', NistToIso27001Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('NistToIso27001Delete-nist_to_iso27001-delete'); // delete
    $app->group(
        '/nist_to_iso27001',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', NistToIso27001Controller::class . ':list')->add(PermissionMiddleware::class)->setName('nist_to_iso27001/list-nist_to_iso27001-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', NistToIso27001Controller::class . ':add')->add(PermissionMiddleware::class)->setName('nist_to_iso27001/add-nist_to_iso27001-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', NistToIso27001Controller::class . ':view')->add(PermissionMiddleware::class)->setName('nist_to_iso27001/view-nist_to_iso27001-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', NistToIso27001Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('nist_to_iso27001/edit-nist_to_iso27001-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', NistToIso27001Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('nist_to_iso27001/delete-nist_to_iso27001-delete-2'); // delete
        }
    );

    // question_controlobjectives
    $app->any('/QuestionControlobjectivesList[/{controlObj_name}]', QuestionControlobjectivesController::class . ':list')->add(PermissionMiddleware::class)->setName('QuestionControlobjectivesList-question_controlobjectives-list'); // list
    $app->any('/QuestionControlobjectivesAdd[/{controlObj_name}]', QuestionControlobjectivesController::class . ':add')->add(PermissionMiddleware::class)->setName('QuestionControlobjectivesAdd-question_controlobjectives-add'); // add
    $app->any('/QuestionControlobjectivesView[/{controlObj_name}]', QuestionControlobjectivesController::class . ':view')->add(PermissionMiddleware::class)->setName('QuestionControlobjectivesView-question_controlobjectives-view'); // view
    $app->any('/QuestionControlobjectivesEdit[/{controlObj_name}]', QuestionControlobjectivesController::class . ':edit')->add(PermissionMiddleware::class)->setName('QuestionControlobjectivesEdit-question_controlobjectives-edit'); // edit
    $app->any('/QuestionControlobjectivesDelete[/{controlObj_name}]', QuestionControlobjectivesController::class . ':delete')->add(PermissionMiddleware::class)->setName('QuestionControlobjectivesDelete-question_controlobjectives-delete'); // delete
    $app->group(
        '/question_controlobjectives',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{controlObj_name}]', QuestionControlobjectivesController::class . ':list')->add(PermissionMiddleware::class)->setName('question_controlobjectives/list-question_controlobjectives-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{controlObj_name}]', QuestionControlobjectivesController::class . ':add')->add(PermissionMiddleware::class)->setName('question_controlobjectives/add-question_controlobjectives-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{controlObj_name}]', QuestionControlobjectivesController::class . ':view')->add(PermissionMiddleware::class)->setName('question_controlobjectives/view-question_controlobjectives-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{controlObj_name}]', QuestionControlobjectivesController::class . ':edit')->add(PermissionMiddleware::class)->setName('question_controlobjectives/edit-question_controlobjectives-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{controlObj_name}]', QuestionControlobjectivesController::class . ':delete')->add(PermissionMiddleware::class)->setName('question_controlobjectives/delete-question_controlobjectives-delete-2'); // delete
        }
    );

    // question_domains
    $app->any('/QuestionDomainsList[/{domain_name}]', QuestionDomainsController::class . ':list')->add(PermissionMiddleware::class)->setName('QuestionDomainsList-question_domains-list'); // list
    $app->any('/QuestionDomainsAdd[/{domain_name}]', QuestionDomainsController::class . ':add')->add(PermissionMiddleware::class)->setName('QuestionDomainsAdd-question_domains-add'); // add
    $app->any('/QuestionDomainsView[/{domain_name}]', QuestionDomainsController::class . ':view')->add(PermissionMiddleware::class)->setName('QuestionDomainsView-question_domains-view'); // view
    $app->any('/QuestionDomainsEdit[/{domain_name}]', QuestionDomainsController::class . ':edit')->add(PermissionMiddleware::class)->setName('QuestionDomainsEdit-question_domains-edit'); // edit
    $app->any('/QuestionDomainsDelete[/{domain_name}]', QuestionDomainsController::class . ':delete')->add(PermissionMiddleware::class)->setName('QuestionDomainsDelete-question_domains-delete'); // delete
    $app->group(
        '/question_domains',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{domain_name}]', QuestionDomainsController::class . ':list')->add(PermissionMiddleware::class)->setName('question_domains/list-question_domains-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{domain_name}]', QuestionDomainsController::class . ':add')->add(PermissionMiddleware::class)->setName('question_domains/add-question_domains-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{domain_name}]', QuestionDomainsController::class . ':view')->add(PermissionMiddleware::class)->setName('question_domains/view-question_domains-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{domain_name}]', QuestionDomainsController::class . ':edit')->add(PermissionMiddleware::class)->setName('question_domains/edit-question_domains-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{domain_name}]', QuestionDomainsController::class . ':delete')->add(PermissionMiddleware::class)->setName('question_domains/delete-question_domains-delete-2'); // delete
        }
    );

    // impact_areas
    $app->any('/ImpactAreasList[/{name}]', ImpactAreasController::class . ':list')->add(PermissionMiddleware::class)->setName('ImpactAreasList-impact_areas-list'); // list
    $app->any('/ImpactAreasAdd[/{name}]', ImpactAreasController::class . ':add')->add(PermissionMiddleware::class)->setName('ImpactAreasAdd-impact_areas-add'); // add
    $app->any('/ImpactAreasView[/{name}]', ImpactAreasController::class . ':view')->add(PermissionMiddleware::class)->setName('ImpactAreasView-impact_areas-view'); // view
    $app->any('/ImpactAreasEdit[/{name}]', ImpactAreasController::class . ':edit')->add(PermissionMiddleware::class)->setName('ImpactAreasEdit-impact_areas-edit'); // edit
    $app->any('/ImpactAreasDelete[/{name}]', ImpactAreasController::class . ':delete')->add(PermissionMiddleware::class)->setName('ImpactAreasDelete-impact_areas-delete'); // delete
    $app->group(
        '/impact_areas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{name}]', ImpactAreasController::class . ':list')->add(PermissionMiddleware::class)->setName('impact_areas/list-impact_areas-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{name}]', ImpactAreasController::class . ':add')->add(PermissionMiddleware::class)->setName('impact_areas/add-impact_areas-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{name}]', ImpactAreasController::class . ':view')->add(PermissionMiddleware::class)->setName('impact_areas/view-impact_areas-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{name}]', ImpactAreasController::class . ':edit')->add(PermissionMiddleware::class)->setName('impact_areas/edit-impact_areas-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{name}]', ImpactAreasController::class . ':delete')->add(PermissionMiddleware::class)->setName('impact_areas/delete-impact_areas-delete-2'); // delete
        }
    );

    // threats
    $app->any('/ThreatsList[/{name}]', ThreatsController::class . ':list')->add(PermissionMiddleware::class)->setName('ThreatsList-threats-list'); // list
    $app->any('/ThreatsAdd[/{name}]', ThreatsController::class . ':add')->add(PermissionMiddleware::class)->setName('ThreatsAdd-threats-add'); // add
    $app->any('/ThreatsView[/{name}]', ThreatsController::class . ':view')->add(PermissionMiddleware::class)->setName('ThreatsView-threats-view'); // view
    $app->any('/ThreatsEdit[/{name}]', ThreatsController::class . ':edit')->add(PermissionMiddleware::class)->setName('ThreatsEdit-threats-edit'); // edit
    $app->any('/ThreatsDelete[/{name}]', ThreatsController::class . ':delete')->add(PermissionMiddleware::class)->setName('ThreatsDelete-threats-delete'); // delete
    $app->group(
        '/threats',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{name}]', ThreatsController::class . ':list')->add(PermissionMiddleware::class)->setName('threats/list-threats-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{name}]', ThreatsController::class . ':add')->add(PermissionMiddleware::class)->setName('threats/add-threats-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{name}]', ThreatsController::class . ':view')->add(PermissionMiddleware::class)->setName('threats/view-threats-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{name}]', ThreatsController::class . ':edit')->add(PermissionMiddleware::class)->setName('threats/edit-threats-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{name}]', ThreatsController::class . ':delete')->add(PermissionMiddleware::class)->setName('threats/delete-threats-delete-2'); // delete
        }
    );

    // question_areas
    $app->any('/QuestionAreasList[/{area_name}]', QuestionAreasController::class . ':list')->add(PermissionMiddleware::class)->setName('QuestionAreasList-question_areas-list'); // list
    $app->any('/QuestionAreasAdd[/{area_name}]', QuestionAreasController::class . ':add')->add(PermissionMiddleware::class)->setName('QuestionAreasAdd-question_areas-add'); // add
    $app->any('/QuestionAreasView[/{area_name}]', QuestionAreasController::class . ':view')->add(PermissionMiddleware::class)->setName('QuestionAreasView-question_areas-view'); // view
    $app->any('/QuestionAreasEdit[/{area_name}]', QuestionAreasController::class . ':edit')->add(PermissionMiddleware::class)->setName('QuestionAreasEdit-question_areas-edit'); // edit
    $app->any('/QuestionAreasDelete[/{area_name}]', QuestionAreasController::class . ':delete')->add(PermissionMiddleware::class)->setName('QuestionAreasDelete-question_areas-delete'); // delete
    $app->group(
        '/question_areas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{area_name}]', QuestionAreasController::class . ':list')->add(PermissionMiddleware::class)->setName('question_areas/list-question_areas-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{area_name}]', QuestionAreasController::class . ':add')->add(PermissionMiddleware::class)->setName('question_areas/add-question_areas-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{area_name}]', QuestionAreasController::class . ':view')->add(PermissionMiddleware::class)->setName('question_areas/view-question_areas-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{area_name}]', QuestionAreasController::class . ':edit')->add(PermissionMiddleware::class)->setName('question_areas/edit-question_areas-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{area_name}]', QuestionAreasController::class . ':delete')->add(PermissionMiddleware::class)->setName('question_areas/delete-question_areas-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
