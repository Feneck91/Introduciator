ECHO OFF

SET INTRODUCIATOR_VERSION="1_1_0"
SET BATCH_PATH=%~dp0

ECHO ------------------------------------
ECHO Creating Introduciator install kit
ECHO Version :  %INTRODUCIATOR_VERSION%
ECHO ------------------------------------
ECHO.

REM Delete the Introduciator export to make clean export
if exist "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%" (
    ECHO Deleting export folder...
    RD "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%" /S /Q
)

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
svn export "https://subversion.assembla.com/svn/introduciator/trunk/Mod" "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%"
IF %errorlevel% EQU 0 GOTO MakeZip

REM Error while exporting Introduciator
ECHO.
ECHO.
ECHO ------------------------------------
ECHO Error while exporting Introduciator!
ECHO.
pause
GOTO End


REM Make Zip file
:MakeZip
ECHO.
ECHO ------------------------------------
ECHO Creating Introduciator_v%INTRODUCIATOR_VERSION%.zip
ECHO ------------------------------------
PUSHD %CD%
CD /D "%BATCH_PATH%"
"%BATCH_PATH%bin\zip.exe" -r "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%.zip" "Introduciator_v%INTRODUCIATOR_VERSION%"
POPD
IF %errorlevel% EQU 0 GOTO Done

REM Error while creating zip
ECHO.
ECHO.
ECHO ------------------------------------
ECHO Error while creating zip file!
ECHO.
pause
GOTO End

:Done
ECHO.
ECHO.
ECHO "Introduciator_v%INTRODUCIATOR_VERSION%.zip" successfully created.

:End
