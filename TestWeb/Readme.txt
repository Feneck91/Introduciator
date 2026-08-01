Introduciator functional tests for phpBB 3.3.x
================================================

This directory contains the Robot Framework and Selenium end-to-end suite.
The tests intentionally target an installed phpBB version >= 3.3.0 and < 3.4.0
and Introduciator 3.0.0. The version assertions are in
Tests_Robot/02_Extension_Activation.robot.

Prerequisites
-------------

1. Configure phpBB QuickInstall with a profile based on the phpBB 3.3.x branch.
2. Make feneck91/introduciator available to that board.
3. Install Python 3, Chrome, and the Python dependencies:

   python -m venv .venv
   .\.venv\Scripts\python.exe -m pip install -r requirements.txt

Configuration
-------------

The defaults retain the original local QuickInstall setup. Override them with:

* PHPBB_QUICKINSTALL_URL - QuickInstall URL used by suite 01.
* PHPBB_TEST_URL - generated phpBB board URL used by suites 02-08.
* PHPBB_TEST_HEADLESS=true - run Chrome in headless mode.
* SELENIUM_REMOTE_URL - optional Selenium Grid endpoint.

Execution
---------

Run the complete ordered suite from TestWeb:

   .\.venv\Scripts\robot.exe --pythonpath .\PythonLibs -d .\Tests_Robot\Results .\Tests_Robot

Parse the suite without opening a browser:

   .\.venv\Scripts\robot.exe --dryrun --pythonpath .\PythonLibs -d .\Tests_Robot\Results .\Tests_Robot

Suite 01 creates a clean populated board. The remaining suites deliberately run
in numeric order because they validate activation, configuration, permissions,
logs, and posting behaviour on that board. Every suite closes its WebDriver
session in teardown, including after a failure.

phpBB-native validation
-----------------------

The extension also contains PHPUnit tests in Ext/feneck91/introduciator/tests.
Install the extension at phpBB/ext/feneck91/introduciator in a phpBB 3.3.x Git
clone, install phpBB's development dependencies, and run from the clone root:

   php phpBB/vendor/bin/phpunit -c phpBB/ext/feneck91/introduciator/phpunit.xml.dist

Run the official Extension Pre-Validator against the packaged directory layout
(the directory supplied to EPV must contain feneck91/introduciator):

   php EPV.php run --dir=Ext
