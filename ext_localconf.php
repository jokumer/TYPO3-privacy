<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    // Add default typoscript setup
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        trim('
                module.tx_privacy {
                    view {
                        templateRootPaths.10 = EXT:privacy/Resources/Private/Backend/Templates/
                        partialRootPaths.10 = EXT:privacy/Resources/Private/Backend/Partials/
                        layoutRootPaths.10 = EXT:privacy/Resources/Private/Backend/Layouts/
                    }
                    settings {
                        applications {
                            backenduser {
                                label = LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:be_users
                                table = be_users
                                fieldProcessing {
                                    anonymize {
                                        username = 1
                                        description = 1
                                        avatar = 1
                                        password = 1
                                        admin = 1
                                        usergroup = 1
                                        email = 1
                                        options = 1
                                        realName = 1
                                        uc = 1
                                        TSconfig = 1
                                        lastlogin = 1
                                    }
                                    export {
                                        uid = 1
                                        pid = 1
                                        tstamp = 1
                                        username = 1
                                        description = 1
                                        avatar = 1
                                        password = 1
                                        admin = 1
                                        usergroup = 1
                                        disable = 1
                                        starttime = 1
                                        endtime = 1
                                        lang = 1
                                        email = 1
                                        db_mountpoints = 1
                                        options = 1
                                        crdate = 1
                                        cruser_id = 1
                                        realName = 1
                                        userMods = 1
                                        allowed_languages = 1
                                        uc = 1
                                        file_mountpoints = 1
                                        file_permissions = 1
                                        workspace_perms = 1
                                        lockToDomain = 1
                                        disableIPlock = 1
                                        deleted = 1
                                        TSconfig = 1
                                        lastlogin = 1
                                        createdByAction = 1
                                        usergroup_cached_list = 1
                                        workspace_id = 1
                                        workspace_preview = 1
                                        category_perms = 1
                                    }
                                }
                            }
                            frontenduser {
                                label = LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users
                                table = fe_users
                                fieldProcessing {
                                    anonymize {
                                        username = 1
                                        password = 1
                                        usergroup = 1
                                        name = 1
                                        first_name = 1
                                        middle_name = 1
                                        last_name = 1
                                        address = 1
                                        telephone = 1
                                        fax = 1
                                        email = 1
                                        description = 1
                                        uc = 1
                                        title = 1
                                        zip = 1
                                        city = 1
                                        country = 1
                                        www = 1
                                        company = 1
                                        image = 1
                                        TSconfig = 1
                                        lastlogin = 1
                                        is_online = 1
                                    }
                                    export {
                                        uid = 1
                                        tx_extbase_type = 1
                                        pid = 1
                                        tstamp = 1
                                        username = 1
                                        password = 1
                                        usergroup = 1
                                        disable = 1
                                        starttime = 1
                                        endtime = 1
                                        name = 1
                                        first_name = 1
                                        middle_name = 1
                                        last_name = 1
                                        address = 1
                                        telephone = 1
                                        fax = 1
                                        email = 1
                                        crdate = 1
                                        cruser_id = 1
                                        lockToDomain = 1
                                        deleted = 1
                                        description = 1
                                        uc = 1
                                        title = 1
                                        zip = 1
                                        city = 1
                                        country = 1
                                        www = 1
                                        company = 1
                                        image = 1
                                        TSconfig = 1
                                        lastlogin = 1
                                        is_online = 1
                                        felogin_redirectPid = 1
                                        felogin_forgotHash = 1
                                    }
                                }
                            }
                        }
                    }
                }
            ')
    );
}
