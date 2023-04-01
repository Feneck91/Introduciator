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

# Clear Admin Logs
Clear Admin Logs
    [Documentation]     Delete all the Admin logs
    [Tags]              Admin Logs
    ${result} =         FM.Clear Admin Logs
    Should Be True      ${result}

# Configure extension
# The user introduction is not mandatory
Configure Extension Succeeded
    [Documentation]     Configure ${EXTENSION_NAME} extension
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Introduciator Extension Configure  ${TRUE}  ${FALSE}  ${FALSE}  ${INTRODUCIATOR_FORUM_NAME}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${FALSE}  ${TRUE}  ${GROUP_PERMISSIONS}  ${EMPTY}
    Should Be True      ${result}

# Configure extension
# The user introduction is not mandatory
Configure Extension Succeeded
    [Documentation]     Configure ${EXTENSION_NAME} extension
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Introduciator Extension Explanation  ${TRUE}  ${FALSE}  ${EMPTY}  ${EMPTY}  ${EMPTY}  ${EMPTY}
    Should Be True      ${result}

# Verify the configuration is correctly log
Verify Admin Logs
    [Documentation]     Verify Admin logs that contains last info about extension configuration
    [Tags]              Verify Admin Logs
    ${result} =         FM.Get Nb Filter Admin Log   Introduciator: configuration settings updated.
    Should Be Equal     ${result}  ${1}


# Clear the introduce forum
Clear Introduce Topic
    [Documentation]     Clear the Topics into thie introduce forum: '${INTRODUCIATOR_FORUM_NAME}'
    [Tags]              Clear Topic
    ${result} =         FM.Clear All Topics  ${INTRODUCIATOR_FORUM_NAME}
    Should Be True      ${result}

# Configure extension
# The user introduction is not mandatory
Post New Topic
    [Documentation]     Configure ${EXTENSION_NAME} extension
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Post New Topic Into Forum  Test forum 5   Title message from ${ADMIN_LOGIN}      This is the message content of ${ADMIN_LOGIN}
    Should Be True      ${result}

## Login as simple user
#Login Admin + ACP
#    [Documentation]     Login as '${ADMIN_LOGIN}' into the forum + ACP
#    [Tags]              Login ACP
#    LoginAndLoginACP    LOGIN=${ADMIN_LOGIN}  PASSWORD=${ADMIN_PASSWORD}
