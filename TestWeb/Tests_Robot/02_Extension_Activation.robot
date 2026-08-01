*** Settings ***
Library     BuiltIn
Resource    LoginAndLoginACP.resource
Suite Teardown    FM.Close Browser

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

Validate phpBB 3.3.x
    [Documentation]     Ensure that the functional suite is running against the supported phpBB 3.3.x branch
    [Tags]              phpBB 3.3.x
    ${result} =         FM.Validate phpBB Version  ${PHPBB_MIN_VERSION}  ${PHPBB_MAX_VERSION}
    Should Be True      ${result}

# Enable extension
Enable Extension
    [Documentation]     Enable ${EXTENSION_NAME} extension
    [Tags]              Enable Extension
    ${result} =         FM.Enable Extension  ${EXTENSION_NAME}
    Should Be True      ${result}

Validate Extension Version
    [Documentation]     Ensure that phpBB loaded the new extension release metadata
    [Tags]              Extension 3.0.0
    ${result} =         FM.Validate Extension Version  ${EXTENSION_NAME}  ${EXTENSION_VERSION}
    Should Be True      ${result}

Validate First Enable Notice
    [Documentation]     Version 3.0.0 must guide the administrator to the disabled-by-default configuration
    [Tags]              Extension 3.0.0
    ${result} =         FM.Extension Enable Notice Is Present
    Should Be True      ${result}
