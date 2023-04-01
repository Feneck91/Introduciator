*** Settings ***
Library     BuiltIn
Resource    LoginAndLoginACP.resource

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

# Configure extension
Configure Extension Failed
    [Documentation]     Configure ${EXTENSION_NAME} extension - Must failed because Forum is not selected
    [Tags]              Configuration Extension failed
    ${result} =         FM.Introduciator Extension Configure ${INTRODUCIATOR_PAGE_HREF}  ${INTRODUCIATOR_PAGE_CONFIGURATION}  ${TRUE}  ${FALSE}  ${FALSE}  ${EMPTY}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${TRUE}  ${None}  ${None}  ${EMPTY}
    Should Be Equal     ${result}  ${FALSE}

# Configure extension
Configure Extension Succeeded
    [Documentation]     Configure ${EXTENSION_NAME} extension - Must succeeded
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Introduciator Extension Configure  ${INTRODUCIATOR_PAGE_HREF}  ${INTRODUCIATOR_PAGE_CONFIGURATION}  ${TRUE}  ${FALSE}  ${FALSE}  ${INTRODUCIATOR_FORUM_NAME}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${TRUE}  ${None}  ${None}  ${EMPTY}
    Should Be True      ${result}
