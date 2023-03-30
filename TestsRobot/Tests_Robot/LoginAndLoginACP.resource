#=======================================================================================
#==                                                                                   ==
#==               Used as Template for Login and Login ACP functions                  ==
#==                                                                                   ==
#=======================================================================================

*** Settings ***
Library     BuiltIn
Resource    Introduciator_Const_Vars.resource
Library     ForumManager.ForumManager   WITH NAME       FM      # Python Lib to check the forum

*** Keywords ***
LoginAndLoginACP
    [Arguments]         ${LOGIN}  ${PASSWORD}
    [Documentation]     Login into the forum + ACP
    Log                 Login '${LOGIN}' into the forum + ACP
    Login Admin         LOGIN=${LOGIN}    PASSWORD=${PASSWORD}
    Login Admin ACP     LOGIN=${LOGIN}

# Login as Admin
Login Admin
    [Arguments]         ${LOGIN}  ${PASSWORD}
    [Documentation]     Login into the forum
    [Tags]              Login
    Log                 Login as '${LOGIN}' into the forum
    FM.Set login name   ${LOGIN}  ${PASSWORD}
    ${result} =         FM.Login
    Should Be True      ${result}

# Login as Admin for ACP
Login Admin ACP
    [Arguments]         ${LOGIN}
    [Documentation]     Login into the forum for ACP
    [Tags]              Login ACP
    Log                 Login as '${LOGIN}' into the forum for ACP
    ${result} =         FM.Login ACP
    Should Be True      ${result}
