*** Settings ***
Library     BuiltIn
Resource    PhpBB_Const_Vars.resource
Resource    LoginAndLoginACP.resource

*** Variables ***
@{GROUP_PERMISSIONS}=   ${GROUP_REGISTERED_USERS}   ${GROUP_GLOBAL_MODERATORS}
@{IGNORED_USERS}=       ${SIMPLE_USER_2_LOGIN}

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

# Configure extension : subtab = Configure
# The user introduction is mandatory
Configure Extension Configure
    [Documentation]     Configure ${EXTENSION_NAME} extension: mandatory introduction
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Introduciator Extension Configure  ${TRUE}  ${TRUE}  ${FALSE}  ${INTRODUCIATOR_FORUM_NAME}  ${INTRODUCIATOR_APPROVAL_LEVEL_NO}  ${FALSE}  ${TRUE}  ${GROUP_PERMISSIONS}  ${IGNORED_USERS}
    Should Be True      ${result}

# Configure extension : subtab = Explanation
# The user introduction will not display explanation page, only retidrect to introduction's forum
Configure Extension Explanation
    [Documentation]     Configure ${EXTENSION_NAME} extension. The user introduction will not display explanation page, only retidrect to introduction's forum
    [Tags]              Configuration Extension succeeded
    ${result} =         FM.Introduciator Extension Explanation  ${FALSE}  ${FALSE}  ${EMPTY}  ${EMPTY}  ${EMPTY}  ${EMPTY}
    Should Be True      ${result}

# Clear the introduce Topic
Clear Introduce Topic
    [Documentation]     Clear the Topics into the introduce forum: '${INTRODUCIATOR_FORUM_NAME}'
    [Tags]              Clear Topic
    ${result} =         FM.Clear All Topics  ${INTRODUCIATOR_FORUM_NAME}
    Should Be True      ${result}

# Clear the '${INTRODUCIATOR_NORMAL_FORUM_NAME1}' Topic
Clear Introduce Forum 5 Topic
    [Documentation]     Clear the Topics into the introduce forum: '${INTRODUCIATOR_FORUM_NAME}'
    [Tags]              Clear Topic
    ${result} =         FM.Clear All Topics  ${INTRODUCIATOR_NORMAL_FORUM_NAME1}
    Should Be True      ${result}

# Post in Topic Admin
Post New Topic '${ADMIN_LOGIN}': Redirect to '${INTRODUCIATOR_FORUM_NAME}' forum
    [Documentation]     Post New Topic for ${ADMIN_LOGIN}
    [Tags]              Post Topic
    ${result} =         FM.Post New Topic Into Forum  ${INTRODUCIATOR_NORMAL_FORUM_NAME1}   Title message from ${ADMIN_LOGIN}      This is the message content of ${ADMIN_LOGIN}
    Should Be Equal     ${result}  ${FALSE}
    ${result} =         FM.is_into_forum  ${INTRODUCIATOR_FORUM_NAME}
    Should Be True      ${result}

# Post in Topic User 1
Post New Topic '${SIMPLE_USER_1_LOGIN}': Redirect to '${INTRODUCIATOR_FORUM_NAME}' forum
    [Documentation]     Post New Topic for ${SIMPLE_USER_1_LOGIN}
    [Tags]              Post Topic
    Log                 Login as '${SIMPLE_USER_1_LOGIN}' into the forum
    FM.Set login name   ${SIMPLE_USER_1_LOGIN}  ${SIMPLE_USER_1_PASSWORD}
    ${result} =         FM.Login
    Should Be True      ${result}
    ${result} =         FM.Post New Topic Into Forum  ${INTRODUCIATOR_NORMAL_FORUM_NAME1}   Title message from ${SIMPLE_USER_1_LOGIN}      This is the message content of ${SIMPLE_USER_1_LOGIN}
    Should Be Equal     ${result}  ${FALSE}
    Log                 Post new Topic into forum '${INTRODUCIATOR_NORMAL_FORUM_NAME1}' for '${SIMPLE_USER_1_LOGIN}' user.
    ${result} =         FM.is_into_forum  ${INTRODUCIATOR_FORUM_NAME}
    Should Be True      ${result}

# Post in Topic User 1
Post New Topic '${SIMPLE_USER_2_LOGIN}': Allowed because ${SIMPLE_USER_2_LOGIN} is into list of ignored users
    [Documentation]     Post New Topic for ${SIMPLE_USER_2_LOGIN} allowed because ${SIMPLE_USER_2_LOGIN} is into list of ignored users
    [Tags]              Post Topic
    Log                 Login as '${SIMPLE_USER_2_LOGIN}' into the forum
    FM.Set login name   ${SIMPLE_USER_2_LOGIN}  ${SIMPLE_USER_2_PASSWORD}
    ${result} =         FM.Login
    Should Be True      ${result}
    Log                 Post new Topic into forum '${INTRODUCIATOR_NORMAL_FORUM_NAME1}' for '${SIMPLE_USER_2_LOGIN}' user.
    ${result} =         FM.Post New Topic Into Forum  ${INTRODUCIATOR_NORMAL_FORUM_NAME1}   Title message from ${SIMPLE_USER_2_LOGIN}      This is the message content of ${SIMPLE_USER_2_LOGIN}
    Should Be True      ${result}
