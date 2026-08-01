#=======================================================================================
#==                                                                                   ==
#==                  Used as Template for checking ACP permissions                    ==
#==                                                                                   ==
#=======================================================================================

*** Settings ***
Library     BuiltIn
Resource    PhpBB_Const_Vars.resource
Resource    Introduciator_Const_Vars.resource
Library     ForumManager.ForumManager   WITH NAME       FM      # Python Lib to check the forum
Resource    LoginAndLoginACP.resource

*** Keywords ***
CheckACPPermissions
    [Arguments]                     ${LOGIN}  ${PASSWORD}  ${GROUP_PERMISSION_RIGHT}  ${USER_PERMISSION_RIGHT}  ${CAN_MANAGE}
    [Documentation]                 Verify ACP permission
    Log                             Verify ACP permission for user '${LOGIN}', Group permission = '${GROUP_PERMISSION_RIGHT}', User permission = '${USER_PERMISSION_RIGHT}', Can manage = '${CAN_MANAGE}'
    LoginAndLoginACP                LOGIN=${ADMIN_LOGIN}  PASSWORD=${ADMIN_PASSWORD}
    Set Group Right                 GROUP_PERMISSION_RIGHT=${GROUP_PERMISSION_RIGHT}
    Set User Right                  LOGIN=${LOGIN}  USER_PERMISSION_RIGHT=${USER_PERMISSION_RIGHT}
    LoginAndLoginACP                LOGIN=${LOGIN}  PASSWORD=${PASSWORD}
    Configure Extension Allowed     CAN_MANAGE=${CAN_MANAGE}

# Set group right - Administrative / Misc
Set Group Right
    [Arguments]         ${GROUP_PERMISSION_RIGHT}
    [Documentation]     Set ACP Permission for group
    [Tags]              Group Permission
    ${result}=          FM.Set Group Permissions  ${GROUP_ADMINISTRATORS}  ${PERMISSION_TYPE_ADMINISTRATIVE}  ${PERMISSION_ADMINISTRATIVE_TAB_MISC}  ${PERMISSION_NAME_INTRODUCIATOR_MANAGE}  ${GROUP_PERMISSION_RIGHT}
    Should Be True      ${result}

# Set user right
Set User Right
    [Arguments]         ${LOGIN}  ${USER_PERMISSION_RIGHT}
    [Documentation]     Set Permission for user
    [Tags]              User Permission
    ${result}=          FM.Set User Permissions  ${LOGIN}  ${PERMISSION_TYPE_ADMINISTRATIVE}  ${PERMISSION_ADMINISTRATIVE_TAB_MISC}  ${PERMISSION_NAME_INTRODUCIATOR_MANAGE}  ${USER_PERMISSION_RIGHT}
    Should Be True      ${result}

# Check if extension is configurable
Configure Extension Allowed
    [Arguments]         ${CAN_MANAGE}
    [Documentation]     Is configure ${EXTENSION_NAME} extension is avalaible (GROUP=NO / USER=NO) = NO
    [Tags]              Can Manage Extension
    ${result} =         FM.Extension Can Be Managed   ${INTRODUCIATOR_PAGE_HREF}  ${INTRODUCIATOR_PAGE_CONFIGURATION}
    Should Be Equal     ${result}  ${CAN_MANAGE}
