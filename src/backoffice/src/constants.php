<?php

/**
 * PHPMaker 2021 constants
 */

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Constants
 */
define(__NAMESPACE__ . "\PROJECT_NAMESPACE", __NAMESPACE__ . "\\");

// System
define(PROJECT_NAMESPACE . "IS_WINDOWS", strtolower(substr(PHP_OS, 0, 3)) === "win"); // Is Windows OS
define(PROJECT_NAMESPACE . "PATH_DELIMITER", IS_WINDOWS ? "\\" : "/"); // Physical path delimiter

// Data types
define(PROJECT_NAMESPACE . "DATATYPE_NUMBER", 1);
define(PROJECT_NAMESPACE . "DATATYPE_DATE", 2);
define(PROJECT_NAMESPACE . "DATATYPE_STRING", 3);
define(PROJECT_NAMESPACE . "DATATYPE_BOOLEAN", 4);
define(PROJECT_NAMESPACE . "DATATYPE_MEMO", 5);
define(PROJECT_NAMESPACE . "DATATYPE_BLOB", 6);
define(PROJECT_NAMESPACE . "DATATYPE_TIME", 7);
define(PROJECT_NAMESPACE . "DATATYPE_GUID", 8);
define(PROJECT_NAMESPACE . "DATATYPE_XML", 9);
define(PROJECT_NAMESPACE . "DATATYPE_BIT", 10);
define(PROJECT_NAMESPACE . "DATATYPE_OTHER", 11);

// Row types
define(PROJECT_NAMESPACE . "ROWTYPE_HEADER", 0); // Row type header
define(PROJECT_NAMESPACE . "ROWTYPE_VIEW", 1); // Row type view
define(PROJECT_NAMESPACE . "ROWTYPE_ADD", 2); // Row type add
define(PROJECT_NAMESPACE . "ROWTYPE_EDIT", 3); // Row type edit
define(PROJECT_NAMESPACE . "ROWTYPE_SEARCH", 4); // Row type search
define(PROJECT_NAMESPACE . "ROWTYPE_MASTER", 5); // Row type master record
define(PROJECT_NAMESPACE . "ROWTYPE_AGGREGATEINIT", 6); // Row type aggregate init
define(PROJECT_NAMESPACE . "ROWTYPE_AGGREGATE", 7); // Row type aggregate
define(PROJECT_NAMESPACE . "ROWTYPE_DETAIL", 8); // Row type detail
define(PROJECT_NAMESPACE . "ROWTYPE_TOTAL", 9); // Row type group summary
define(PROJECT_NAMESPACE . "ROWTYPE_PREVIEW", 10); // Preview record

// Row total types
define(PROJECT_NAMESPACE . "ROWTOTAL_GROUP", 1); // Page summary
define(PROJECT_NAMESPACE . "ROWTOTAL_PAGE", 2); // Page summary
define(PROJECT_NAMESPACE . "ROWTOTAL_GRAND", 3); // Grand summary

// Row total sub types
define(PROJECT_NAMESPACE . "ROWTOTAL_HEADER", 0); // Header
define(PROJECT_NAMESPACE . "ROWTOTAL_FOOTER", 1); // Footer
define(PROJECT_NAMESPACE . "ROWTOTAL_SUM", 2); // SUM
define(PROJECT_NAMESPACE . "ROWTOTAL_AVG", 3); // AVG
define(PROJECT_NAMESPACE . "ROWTOTAL_MIN", 4); // MIN
define(PROJECT_NAMESPACE . "ROWTOTAL_MAX", 5); // MAX
define(PROJECT_NAMESPACE . "ROWTOTAL_CNT", 6); // CNT

// Empty/Null/Not Null/Init/all values
define(PROJECT_NAMESPACE . "EMPTY_VALUE", "##empty##");
define(PROJECT_NAMESPACE . "INIT_VALUE", "##init##");
define(PROJECT_NAMESPACE . "ALL_VALUE", "##all##");

// List actions
define(PROJECT_NAMESPACE . "ACTION_POSTBACK", "P"); // Post back
define(PROJECT_NAMESPACE . "ACTION_AJAX", "A"); // Ajax
define(PROJECT_NAMESPACE . "ACTION_MULTIPLE", "M"); // Multiple records
define(PROJECT_NAMESPACE . "ACTION_SINGLE", "S"); // Single record

// User level constants
define(PROJECT_NAMESPACE . "ALLOW_ADD", 1); // Add
define(PROJECT_NAMESPACE . "ALLOW_DELETE", 2); // Delete
define(PROJECT_NAMESPACE . "ALLOW_EDIT", 4); // Edit
define(PROJECT_NAMESPACE . "ALLOW_LIST", 8); // List
define(PROJECT_NAMESPACE . "ALLOW_REPORT", 8); // Report
define(PROJECT_NAMESPACE . "ALLOW_ADMIN", 16); // Admin
define(PROJECT_NAMESPACE . "ALLOW_VIEW", 32); // View
define(PROJECT_NAMESPACE . "ALLOW_SEARCH", 64); // Search
define(PROJECT_NAMESPACE . "ALLOW_IMPORT", 128); // Import
define(PROJECT_NAMESPACE . "ALLOW_LOOKUP", 256); // Lookup
define(PROJECT_NAMESPACE . "ALLOW_ALL", 511); // All (1 + 2 + 4 + 8 + 16 + 32 + 64 + 128 + 256)

// Product version
define(PROJECT_NAMESPACE . "PRODUCT_VERSION", "17.0.8");

// Project
define(PROJECT_NAMESPACE . "PROJECT_NAME", "ITaudit_backoffice_v2"); // Project name
define(PROJECT_NAMESPACE . "PROJECT_ID", "{1024BC10-9A54-4DA5-B125-D34011650EC0}"); // Project ID

/**
 * Character encoding
 * Note: If you use non English languages, you need to set character encoding
 * for some features. Make sure either iconv functions or multibyte string
 * functions are enabled and your encoding is supported. See PHP manual for
 * details.
 */
define(PROJECT_NAMESPACE . "PROJECT_ENCODING", "UTF-8"); // Character encoding
define(PROJECT_NAMESPACE . "IS_DOUBLE_BYTE", in_array(PROJECT_ENCODING, ["GBK", "BIG5", "SHIFT_JIS"])); // Double-byte character encoding
define(PROJECT_NAMESPACE . "FILE_SYSTEM_ENCODING", ""); // File system encoding

// Database
define(PROJECT_NAMESPACE . "IS_MSACCESS", false); // Access
define(PROJECT_NAMESPACE . "IS_MSSQL", false); // SQL Server
define(PROJECT_NAMESPACE . "IS_MYSQL", true); // MySQL
define(PROJECT_NAMESPACE . "IS_POSTGRESQL", false); // PostgreSQL
define(PROJECT_NAMESPACE . "IS_ORACLE", false); // Oracle
define(PROJECT_NAMESPACE . "IS_SQLITE", false); // SQLite
define(PROJECT_NAMESPACE . "DB_QUOTE_START", "`");
define(PROJECT_NAMESPACE . "DB_QUOTE_END", "`");

// Session
define(PROJECT_NAMESPACE . "SESSION_STATUS", PROJECT_NAME . "_status"); // Login status
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE", SESSION_STATUS . "_UserProfile"); // User profile
define(PROJECT_NAMESPACE . "SESSION_USER_NAME", SESSION_STATUS . "_UserName"); // User name
define(PROJECT_NAMESPACE . "SESSION_USER_LOGIN_TYPE", SESSION_STATUS . "_UserLoginType"); // User login type
define(PROJECT_NAMESPACE . "SESSION_USER_ID", SESSION_STATUS . "_UserID"); // User ID
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_USER_NAME", SESSION_USER_PROFILE . "_UserName");
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_PASSWORD", SESSION_USER_PROFILE . "_Password");
define(PROJECT_NAMESPACE . "SESSION_USER_PROFILE_LOGIN_TYPE", SESSION_USER_PROFILE . "_LoginType");
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_ID", SESSION_STATUS . "_UserLevel"); // User Level ID
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_LIST", SESSION_STATUS . "_UserLevelList"); // User Level List
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_LIST_LOADED", SESSION_STATUS . "_UserLevelListLoaded"); // User Level List Loaded
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL", SESSION_STATUS . "_UserLevelValue"); // User Level
define(PROJECT_NAMESPACE . "SESSION_PARENT_USER_ID", SESSION_STATUS . "_ParentUserId"); // Parent User ID
define(PROJECT_NAMESPACE . "SESSION_SYS_ADMIN", PROJECT_NAME . "_SysAdmin"); // System admin
define(PROJECT_NAMESPACE . "SESSION_PROJECT_ID", PROJECT_NAME . "_ProjectId"); // User Level project ID
define(PROJECT_NAMESPACE . "SESSION_AR_USER_LEVEL", PROJECT_NAME . "_arUserLevel"); // User Level array
define(PROJECT_NAMESPACE . "SESSION_AR_USER_LEVEL_PRIV", PROJECT_NAME . "_arUserLevelPriv"); // User Level privilege array
define(PROJECT_NAMESPACE . "SESSION_USER_LEVEL_MSG", PROJECT_NAME . "_UserLevelMessage"); // User Level Message
define(PROJECT_NAMESPACE . "SESSION_MESSAGE", PROJECT_NAME . "_Message"); // System message
define(PROJECT_NAMESPACE . "SESSION_FAILURE_MESSAGE", PROJECT_NAME . "_FailureMessage"); // System error message
define(PROJECT_NAMESPACE . "SESSION_SUCCESS_MESSAGE", PROJECT_NAME . "_SuccessMessage"); // System message
define(PROJECT_NAMESPACE . "SESSION_WARNING_MESSAGE", PROJECT_NAME . "_WarningMessage"); // Warning message
define(PROJECT_NAMESPACE . "SESSION_INLINE_MODE", PROJECT_NAME . "_InlineMode"); // Inline mode
define(PROJECT_NAMESPACE . "SESSION_BREADCRUMB", PROJECT_NAME . "_Breadcrumb"); // Breadcrumb
define(PROJECT_NAMESPACE . "SESSION_TEMP_IMAGES", PROJECT_NAME . "_TempImages"); // Temp images
define(PROJECT_NAMESPACE . "SESSION_CAPTCHA_CODE", PROJECT_NAME . "_Captcha"); // Captcha code
define(PROJECT_NAMESPACE . "SESSION_LANGUAGE_ID", PROJECT_NAME . "_LanguageId"); // Language ID
