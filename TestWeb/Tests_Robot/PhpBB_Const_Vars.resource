#=======================================================================================
#==                                                                                   ==
#==                      Constants used to manage phpBB's forums                      ==
#==                                                                                   ==
#=======================================================================================

*** Variables ***

# Forum's groups (for permissions)
${GROUP_GUESTS}=                                        1
${GROUP_REGISTERED_USERS}=                              2
${GROUP_GLOBAL_MODERATORS}=                             4
${GROUP_ADMINISTRATORS}=                                5
${GROUP_BOTS}=                                          6
${GROUP_NEWLY REGISTERED USERS}=                        7

# Forum's permission type
${PERMISSION_TYPE_ADMINISTRATIVE}=                      a_
${PERMISSION_TYPE_MODERATOR}=                           m_
${PERMISSION_TYPE_USER}=                                u_

# Forum's tab permission
# -> ADMINISTRATIVE
${PERMISSION_ADMINISTRATIVE_TAB_SETTINGS}=              tab000
${PERMISSION_ADMINISTRATIVE_TAB_FORUMS}=                tab001
${PERMISSION_ADMINISTRATIVE_TAB_POSTING}=               tab002
${PERMISSION_ADMINISTRATIVE_TAB_USER_AND_GROUP}=        tab003
${PERMISSION_ADMINISTRATIVE_TAB_PERMISSIONS}=           tab004
${PERMISSION_ADMINISTRATIVE_TAB_MISC}=                  tab005
# -> MODERATOR
${PERMISSION_MODERATOR_TAB_POSTS_ACTIONS}=              tab000
${PERMISSION_MODERATOR_TAB_TOPIC_ACTIONS}=              tab001
${PERMISSION_MODERATOR_TAB_MISC}=                       tab002
# -> USER
${PERMISSION_USER_TAB_PROFILE}=                         tab000
${PERMISSION_USER_TAB_POST}=                            tab001
${PERMISSION_USER_TAB_PRIVATE_MESSAGES}=                tab002
${PERMISSION_USER_TAB_MISC}                             tab003
# Permissions rights
${PERMISSON_RIGHT_YES}=                                 _y
${PERMISSON_RIGHT_NO}=                                  _u
${PERMISSON_RIGHT_NEVER}=                               _n
