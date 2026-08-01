*** Settings ***
Library     BuiltIn
Resource    PhpBB_Const_Vars.resource
Resource    LoginAndLoginACP.resource

*** Variables ***
@{GROUP_PERMISSIONS}=   ${GROUP_REGISTERED_USERS}   ${GROUP_GLOBAL_MODERATORS}

*** Test Cases ***
# Init the Web Browser
Init
    [Documentation]     Initialize the forum's url and create the web browser
    [Tags]              Init
    ${result} =         FM.init  ${FORUM_URL}
    Should Be True      ${result}

# Login as admin + ACP
Login Admin + ACP
    [Documentation]     Login as '${ADMIN_LOGIN}' into the forum + ACP
    [Tags]              Login ACP
    LoginAndLoginACP    LOGIN=${ADMIN_LOGIN}  PASSWORD=${ADMIN_PASSWORD}

#=======================================================================================================================
#
#                                          FR - Français
#
#=======================================================================================================================
# Set UCP lang to french
Set UCP Lang FR
    [Documentation]     Set the user language to French
    [Tags]              Set Lang EN
    ${result} =         FM.Set Ucp Lang  fr

# Clear Admin Logs
Clear Admin Logs FR Start
    [Documentation]     Delete all the Admin logs
    [Tags]              Admin Logs
    ${result} =         FM.Clear Admin Logs
    Should Be True      ${result}

# Modify extension Configuration : subtab = Configure
# The user introduction is not mandatory
Configure Extension Configure FR
    [Documentation]     Change ${EXTENSION_NAME} extension's Configuration
    [Tags]              Change Extension Configuration
    ${result} =         FM.Introduciator Extension Configure  ${TRUE}  ${FALSE}  ${FALSE}  ${INTRODUCIATOR_FORUM_NAME}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${FALSE}  ${TRUE}  ${GROUP_PERMISSIONS}  ${EMPTY}
    Should Be True      ${result}

# Verify the configuration is correctly log
Verify Admin Logs Configuration FR
    [Documentation]     Verify Admin logs that contains last info about extension configuration
    [Tags]              Verify Admin Logs
    ${result} =         FM.Get Nb Filter Admin Log   Présentation forcée : paramètres de configuration mis à jour.
    Should Be Equal     ${result}  ${1}

# Clear Admin Logs
Clear Admin Logs Again FR
    [Documentation]     Delete all the Admin logs
    [Tags]              Admin Logs
    ${result} =         FM.Clear Admin Logs
    Should Be True      ${result}

# Configure extension : subtab = Explanation
# The user introduction will not display explanation page
Configure Extension Explanation FR
    [Documentation]     Change ${EXTENSION_NAME} extension's Explanation
    [Tags]              Change Extension Explanation
    ${result} =         FM.Introduciator Extension Explanation  ${TRUE}  ${FALSE}  ${EMPTY}  ${EMPTY}  ${EMPTY}  ${EMPTY}
    Should Be True      ${result}

# Verify the modification of explanation is correctly log
Verify Admin Logs Explanation FR
    [Documentation]     Verify Admin logs that contains last info about extension configuration
    [Tags]              Verify Admin Logs
    ${result} =         FM.Get Nb Filter Admin Log   Présentation forcée : configuration des explications mise à jour.
    Should Be Equal     ${result}  ${1}

#=======================================================================================================================
#
#                                          EN - English
#
#=======================================================================================================================

# Set UCP lang to english
Set UCP Lang EN
    [Documentation]     Set the user language to English
    [Tags]              Set Lang EN
    ${result} =         FM.Set Ucp Lang  en

# Clear Admin Logs
Clear Admin Logs EN Start
    [Documentation]     Delete all the Admin logs
    [Tags]              Admin Logs
    ${result} =         FM.Clear Admin Logs
    Should Be True      ${result}

# Modify extension Configuration : subtab = Configure
# The user introduction is not mandatory
Configure Extension Configure EN
    [Documentation]     Change ${EXTENSION_NAME} extension's Configuration
    [Tags]              Change Extension Configuration
    ${result} =         FM.Introduciator Extension Configure  ${TRUE}  ${FALSE}  ${FALSE}  ${INTRODUCIATOR_FORUM_NAME}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${FALSE}  ${TRUE}  ${GROUP_PERMISSIONS}  ${EMPTY}
    Should Be True      ${result}

# Verify the configuration is correctly log
Verify Admin Logs Configuration EN
    [Documentation]     Verify Admin logs that contains last info about extension configuration
    [Tags]              Verify Admin Logs
    ${result} =         FM.Get Nb Filter Admin Log   Introduciator: configuration settings updated.
    Should Be Equal     ${result}  ${1}

# Clear Admin Logs
Clear Admin Logs Again EN
    [Documentation]     Delete all the Admin logs
    [Tags]              Admin Logs
    ${result} =         FM.Clear Admin Logs
    Should Be True      ${result}

# Configure extension : subtab = Explanation
# The user introduction will not display explanation page
Configure Extension Explanation EN
    [Documentation]     Change ${EXTENSION_NAME} extension's Explanation
    [Tags]              Change Extension Explanation
    ${result} =         FM.Introduciator Extension Explanation  ${TRUE}  ${FALSE}  ${EMPTY}  ${EMPTY}  ${EMPTY}  ${EMPTY}
    Should Be True      ${result}

# Verify the modification of explanation is correctly log
Verify Admin Logs Explanation EN
    [Documentation]     Verify Admin logs that contains last info about extension configuration
    [Tags]              Verify Admin Logs
    ${result} =         FM.Get Nb Filter Admin Log   Introduciator: explanation’s settings updated.
    Should Be Equal     ${result}  ${1}
