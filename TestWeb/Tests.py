#!/usr/bin/env python
# -*- coding: utf-8 -*-

# This is a sample Python script.

# Press Ctrl+F5 to execute it or replace it with your code.
# Press Double Shift to search everywhere for classes, files, tool windows, actions, and settings.

from PythonLibs.ForumManager import ForumManager

# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    try:
        forumManager = ForumManager()
        #forumManager.init("http://localhost:180/my-app/quickinstall/")
        #forumManager.generate_QuickInstall("IntroduciatorTester", "Introduciator Extension Board", "Board used to check Introduciator Extension with Robot Framework", "IntroduciatorTester", True, True, True)
        forumManager.init("http://localhost:180/my-app/quickinstall/boards/IntroduciatorTester/")
        #forumManager.set_login_name("tester_1", "123456")
        #forumManager.login()
        forumManager.set_login_name("admin", "123456")
        forumManager.login()
        forumManager.login_ACP()
        forumManager.post_new_topic_into_forum("Test forum 5", "Title message from admin",  "This is the message content of admin")
        #forumManager.clear_admin_logs()
        #forumManager.set_ucp_lang("fr")
        #forumManager.set_ucp_lang("en")
        # forumManager.configure_forum([
        #                                 { "forum"    : "Your first category",
        #                                   "config"   : { "//textarea[@id='forum_rules']" : "This is the rules of 'Your first category' forum !",
        #                                                },
        #                                   "subforums" :
        #                                   [
        #                                       {
        #                                           "forum" : "Your first forum",
        #                                           "config": { "//input[@type='radio' and @name='enable_quick_reply' and @value='1']" : "click()",
        #                                                       "//textarea[@id='forum_rules']" : "This is the rules of 'Your first forum' !"
        #                                                     }
        #                                       }
        #                                   ]
        #                                 },
        #                              ])


        #forumManager.clear_all_topics('Your first forum')
        # forumManager.set_group_permissions('5', 'a_', 'tab005', 'a_introduciator_manage', '_n')
        # forumManager.set_user_permissions('tester_1', 'a_', 'tab005', 'a_introduciator_manage', '_n')
        # forumManager.set_login_name("tester_1", "123456")
        # forumManager.login()
        # forumManager.login_ACP()
        # forumManager.set_login_name("admin", "123456")
        # forumManager.login()
        # forumManager.login_ACP()
        # forumManager.set_user_permissions('tester_1', 'a_', 'tab005', 'a_introduciator_manage', '_u')
        # forumManager._navigate_main()
        #forumManager.Introduciator_extension_configure(True, False, False, 'Your first forum', 0, False, True, 2, '')
        forumManager.wait_until_closed()
        #forumManager.clear_all_topics("Your first forum")
        # if forumManager.login():
        #     if forumManager.login_ACP():
        #         forumManager.wait_until_closed()
    except Exception as ex:
        print(f"Exception = {ex}")
        forumManager.wait_until_closed()

# To run Robot => Open Terminal Tab and type (The drive can be different)
# You should be on :
#
# One test:
# D:\Introduciator\Tests\MainEnv\Scripts\python.exe  D:\Introduciator\Tests\MainEnv\Scripts\robot.exe --pythonpath .\PythonLibs -d Tests_Robots\Results .\Tests_Robots\Check_Extension_Activation.robot
# All tests:
# E:\Introduciator\Tests\MainEnv\Scripts\python.exe  E:\Introduciator\Tests\MainEnv\Scripts\robot.exe --pythonpath .\PythonLibs -d Tests_Robots\Results .\Tests_Robots\


