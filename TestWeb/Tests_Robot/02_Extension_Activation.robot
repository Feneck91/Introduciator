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

# Enable extension
Enable Extension
    [Documentation]     Enable ${EXTENSION_NAME} extension
    [Tags]              Enable Extension
    ${result} =         FM.Enable Extension  ${EXTENSION_NAME}
    Should Be True      ${result}
