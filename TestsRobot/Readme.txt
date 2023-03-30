This folder contains Python code to be able to test Introduciator Extension.

This is based on Selenium library and Robot Framework to make tests.

PythonLibs:
-----------
Contains the python code (ForumManager.py) called by Robot Framework to manage phpBB forum.

Tests_Robot:
------------
Contains the the tests done to be able verify Introduciator extension is working well.

.idea:
------
Used by pyCharm, it is the current project.

Notes:
------
This project can be used to check other things on phpBB's forums.
Specific constants used by Introduciator extension are put on separate files.
The robot used QuickInstall to create a new phpBB's forum to be checked.

Here it contains ONLY tests source code, not all the framework.
The framework can be put on USB key or on hard drive, in the root of a disk.
It used only Portable Apps, no need to do installation!

It can be download here:
------------------------
Link: https://dsm.darksphinx.myds.me/sharing/WTY5IWTuh
password: dfdsf554$*sdfsdqSDFF5

To launch it:
--------------
Install the Python environment (to be done only once) - DownloadAndInstallAllPythonLibs.bat
Run batch 1_RunUwAmp.bat.
Run batch 2_RunPortableApps.bat: very important because it patch drive that can change on each USB key.
Launch PyCharm through the portable app system.

The source code here must be located on Tests\TestWeb