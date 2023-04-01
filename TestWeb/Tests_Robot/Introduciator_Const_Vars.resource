#=======================================================================================
#==                                                                                   ==
#==               Constants used specificly for Introduciator extension               ==
#==                                                                                   ==
#=======================================================================================

*** Variables ***
# QuickInstall
${QUICKINSTALL_URL}=                                    http://localhost:180/my-app/quickinstall/
${QUICKINSTALL_PROFILE_NAME}=                           IntroduciatorTester
${QUICKINSTALL_BOARD_NAME}=                             Introduciator Extension Board
${QUICKINSTALL_BOARD_DESCRIPTION}=                      Board used to check Introduciator Extension with Robot Framework
${QUICKINSTALL_DIRECTORY_NAME}=                         IntroduciatorTester
${QUICKINSTALL_IS_REDIRECT_TO_BOARD}=                   True
${QUICKINSTALL_IS_POPULATE}=                            True
${QUICKINSTALL_IS_ENABLE_DEBUG}=                        True

# Permissions names
${PERMISSION_NAME_INTRODUCIATOR_MANAGE}=                a_introduciator_manage
${PERMISSION_NAME_INTRODUCIATOR_MUST_INTRODUCE}=        u_must_introduce

# Forum's infos
${FORUM_URL}=                                           http://localhost:180/my-app/quickinstall/boards/IntroduciatorTester/index.php
${ADMIN_LOGIN}=                                         admin
${ADMIN_PASSWORD}=                                      123456
${ADMIN_2_LOGIN}=                                       tester_1
${ADMIN_2_PASSWORD}=                                    123456
${MODERATOR_LOGIN}=                                     tester_2
${MODERATOR_PASSWORD}=                                  123456
${EXTENSION_NAME}=                                      feneck91/introduciator
${INTRODUCIATOR_FORUM_NAME}=                            Your first forum
${INTRODUCIATOR_APPROVAL_LEVEL_NO}=                     ${0}
${INTRODUCIATOR_APPROVAL_LEVEL_SIMPLE}=                 ${1}
${INTRODUCIATOR_APPROVAL_LEVEL_EDIT}=                   ${2}
${INTRODUCIATOR_PAGE_CONFIGURATION}=                    Configuration
${INTRODUCIATOR_PAGE_EXPLANATION}=                      Explanation
${INTRODUCIATOR_PAGE_HREF}=                             acp-introduciator_module    # Found in HREF of Extension TAB with mode=<page> to be able to find specific extension
