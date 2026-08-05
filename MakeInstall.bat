ECHO OFF

SET INTRODUCIATOR_VERSION=3_0_0
SET BATCH_PATH=%~dp0

ECHO ------------------------------------
ECHO Creating Introduciator install kit
ECHO Version :  %INTRODUCIATOR_VERSION%
ECHO ------------------------------------
ECHO.

REM Delete the Introduciator zip file to make clean export
if exist "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%.zip" (
    ECHO Deleting zip file...
    del "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%.zip" /Q
)

REM Export to clean Folder
ECHO.
ECHO ------------------------------------
ECHO Exporting "Introduciator_v%INTRODUCIATOR_VERSION%"
ECHO ------------------------------------
REM Package only the phpBB extension and omit development tests.
git -C "%BATCH_PATH%." archive --format zip --prefix="feneck91/introduciator/" --output "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%.zip" "master:Ext/feneck91/introduciator" . ":(exclude)tests"
IF %errorlevel% EQU 0 GOTO Done

REM Error while exporting Introduciator
ECHO.
ECHO.
ECHO ------------------------------------
ECHO Error while exporting Introduciator!
ECHO.
pause
GOTO End

:Done
ECHO.
ECHO.
ECHO "Introduciator_v%INTRODUCIATOR_VERSION%.zip" successfully created.
pause

:End
