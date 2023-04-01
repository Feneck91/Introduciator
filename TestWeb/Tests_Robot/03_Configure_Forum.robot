*** Settings ***
Library     BuiltIn
Resource    LoginAndLoginACP.resource

*** Variables ***
# Variables XPATH : keys
${xpath_enable_quick_reply}=        //input[@type='radio' and @name='enable_quick_reply' and @value='1']
${xpath_forum_rules}=               //textarea[@id='forum_rules']
# Dictionnary with keys = XPATH (item to set) / Value = value
&{dict_introduce_forum_config}=     ${xpath_enable_quick_reply}=click()   ${xpath_forum_rules}=This is the rules of 'Your first forum'
# Dictionnary with keys = forum = <name of the forum> / config = <configs for this forum>
&{dict_introduce_forum}=            forum=Your first forum      config=${dict_introduce_forum_config}
# Make a list with dict_introduce_forum, it can have severals subforums
@{list_config_subforums}            ${dict_introduce_forum}
# Make a list with root category
&{dict_introduce_first_category}=   forum=Your first category   subforums=${list_config_subforums}
# List of all root categories
@{list_config_forums}=              ${dict_introduce_first_category}

*** Test Cases ***
# Init the Web Browser
Init
    [Documentation]     Initialize the forum's url and create the web browser
    [Tags]              Init
    ${result} =         FM.init                 ${FORUM_URL}
    Should Be True      ${result}

# Login as admin + ACP
Login Admin + ACP
    [Documentation]     Login as '${ADMIN_LOGIN}' into the forum + ACP
    [Tags]              Login ACP
    LoginAndLoginACP    LOGIN=${ADMIN_LOGIN}  PASSWORD=${ADMIN_PASSWORD}

Configure Forums
    [Documentation]     Set
    [Tags]              Configure forums
    ${result} =         FM.configure_forum      ${list_config_forums}
    Should Be True      ${result}

# Clear the introduce forum
Clear Introduce Topic
    [Documentation]     Clear the Topics into thie introduce forum: '${INTRODUCIATOR_FORUM_NAME}'
    [Tags]              Clear Topic
    ${result} =         FM.Clear All Topics  ${INTRODUCIATOR_FORUM_NAME}
    Should Be True      ${result}
