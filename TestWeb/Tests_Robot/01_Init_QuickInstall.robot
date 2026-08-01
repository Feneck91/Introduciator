*** Settings ***
Library     BuiltIn
Resource    Introduciator_Const_Vars.resource
Library     ForumManager.ForumManager   WITH NAME       FM      # Python Lib to check the forum

*** Test Cases ***
# Init the Web Browser
Init
    [Documentation]     Initialize the QuickInstall url and create the web browser
    [Tags]              Init
    ${result} =         FM.init                     ${QUICKINSTALL_URL}
    Should Be True      ${result}

# Generate Board
Generated Board
    [Documentation]     Create and populate board
    [Tags]              QuickInstall
    ${result} =         FM.Generate QuickInstall  ${QUICKINSTALL_PROFILE_NAME}  ${QUICKINSTALL_BOARD_NAME}  ${QUICKINSTALL_BOARD_DESCRIPTION}  ${QUICKINSTALL_DIRECTORY_NAME}  ${QUICKINSTALL_IS_REDIRECT_TO_BOARD}  ${QUICKINSTALL_IS_POPULATE}  ${QUICKINSTALL_IS_ENABLE_DEBUG}
    Should Be True      ${result}
