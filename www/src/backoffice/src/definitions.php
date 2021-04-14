<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "applications" => \DI\create(Applications::class),
    "categories" => \DI\create(Categories::class),
    "cis_refs" => \DI\create(CisRefs::class),
    "current_profiles" => \DI\create(CurrentProfiles::class),
    "datas" => \DI\create(Datas::class),
    "employees" => \DI\create(Employees::class),
    "failed_jobs" => \DI\create(FailedJobs::class),
    "functions" => \DI\create(Functions::class),
    "informations" => \DI\create(Informations::class),
    "inventories" => \DI\create(Inventories::class),
    "layers" => \DI\create(Layers::class),
    "migrations" => \DI\create(Migrations::class),
    "mission_processes" => \DI\create(MissionProcesses::class),
    "network_equipments" => \DI\create(NetworkEquipments::class),
    "networks" => \DI\create(Networks::class),
    "nist_refs" => \DI\create(NistRefs::class),
    "organisations" => \DI\create(Organisations::class),
    "orgusers" => \DI\create(Orgusers::class),
    "password_resets" => \DI\create(PasswordResets::class),
    "physique_equipments" => \DI\create(PhysiqueEquipments::class),
    "physique_sites" => \DI\create(PhysiqueSites::class),
    "question_target_profiles" => \DI\create(QuestionTargetProfiles::class),
    "responsabilities" => \DI\create(Responsabilities::class),
    "risk_librairies" => \DI\create(RiskLibrairies::class),
    "risk_registers" => \DI\create(RiskRegisters::class),
    "roles" => \DI\create(Roles::class),
    "sub_categories" => \DI\create(SubCategories::class),
    "systems" => \DI\create(Systems::class),
    "target_profile_tiers" => \DI\create(TargetProfileTiers::class),
    "target_profiles" => \DI\create(TargetProfiles::class),
    "users" => \DI\create(Users::class),
    "business_objectives" => \DI\create(BusinessObjectives::class),
    "people" => \DI\create(People::class),
    "business_processes_links" => \DI\create(BusinessProcessesLinks::class),
    "nist_refs_controlfamily" => \DI\create(NistRefsControlfamily::class),
    "subcat_cis_links" => \DI\create(SubcatCisLinks::class),
    "subcat_nist_links" => \DI\create(SubcatNistLinks::class),
    "iso27001_controlarea" => \DI\create(Iso27001Controlarea::class),
    "iso27001_family" => \DI\create(Iso27001Family::class),
    "iso27001_refs" => \DI\create(Iso27001Refs::class),
    "subcat_iso27001_links" => \DI\create(SubcatIso27001Links::class),
    "questions_library" => \DI\create(QuestionsLibrary::class),
    "cis_refs_controlfamily" => \DI\create(CisRefsControlfamily::class),
    "cobit5_refs" => \DI\create(Cobit5Refs::class),
    "subcat_cobit_links" => \DI\create(SubcatCobitLinks::class),
    "cobit5_family" => \DI\create(Cobit5Family::class),
    "audit_team_links" => \DI\create(AuditTeamLinks::class),
    "audits" => \DI\create(Audits::class),
    "reponses" => \DI\create(Reponses::class),
    "tasks_planification" => \DI\create(TasksPlanification::class),
    "team_projet_audit" => \DI\create(TeamProjetAudit::class),
    "transit" => \DI\create(Transit::class),
    "nist_refs_controlarea" => \DI\create(NistRefsControlarea::class),
    "transitall" => \DI\create(Transitall::class),
    "nistsubcat" => \DI\create(Nistsubcat::class),
    "cobit5_area" => \DI\create(Cobit5Area::class),
    "Dashboard1" => \DI\create(Dashboard1::class),
    "nist_to_iso27001" => \DI\create(NistToIso27001::class),
    "question_controlobjectives" => \DI\create(QuestionControlobjectives::class),
    "question_domains" => \DI\create(QuestionDomains::class),
    "impact_areas" => \DI\create(ImpactAreas::class),
    "threats" => \DI\create(Threats::class),
    "question_areas" => \DI\create(QuestionAreas::class),
];
