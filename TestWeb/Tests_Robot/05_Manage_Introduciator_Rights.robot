*** Settings ***
Library     BuiltIn
Resource    PhpBB_Const_Vars.resource
Resource    CheckPermissionsACP.resource

*** Test Cases ***
# Init the Web Browser
Init
    [Documentation]     Initialize the forum's url and create the web browser
    [Tags]              Init
    ${result} =         FM.init  ${FORUM_URL}
    Should Be True      ${result}

Check permissions (GROUP=YES / USER=YES) = YES
    [Documentation]         Can manage Introduciator allowed
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  CAN_MANAGE=${TRUE}

Check permissions (GROUP=NO / USER=YES) = YES
    [Documentation]         Can manage Introduciator allowed
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  CAN_MANAGE=${TRUE}

Check permissions (GROUP=NEVER / USER=YES) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  CAN_MANAGE=${FALSE}

Check permissions (GROUP=YES / USER=NO) = YES
    [Documentation]         Can manage Introduciator allowed
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  CAN_MANAGE=${TRUE}

Check permissions (GROUP=NO / USER=NO) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  CAN_MANAGE=${FALSE}

Check permissions (GROUP=NEVER / USER=NO) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  CAN_MANAGE=${FALSE}

Check permissions (GROUP=YES / USER=NEVER) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_YES}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  CAN_MANAGE=${FALSE}

Check permissions (GROUP=NO / USER=NEVER) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NO}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  CAN_MANAGE=${FALSE}

Check permissions (GROUP=NEVER / USER=NEVER) = NO
    [Documentation]         Can manage Introduciator forbidden
    [Tags]                  Can manage Introduciator
    CheckACPPermissions     LOGIN=${ADMIN_2_LOGIN}  PASSWORD=${ADMIN_2_PASSWORD}  GROUP_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  USER_PERMISSION_RIGHT=${PERMISSON_RIGHT_NEVER}  CAN_MANAGE=${FALSE}
