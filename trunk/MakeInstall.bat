ECHO OFF

SET INTRODUCIATOR_VERSION="2_1_0"
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
REM svn export "https://subversion.assembla.com/svn/introduciator/trunk/Mod/feneck91" "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%"
mkdir ""%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%"
svn export "%BATCH_PATH%Mod\feneck91" "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%\feneck91"
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
CD /D "%BATCH_PATH%\Introduciator_v%INTRODUCIATOR_VERSION%"
"%BATCH_PATH%bin\zip.exe" -r "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%.zip" "feneck91"
POPD
IF %errorlevel% EQU 0 GOTO RemoveTempFolder
GOTO Error

:RemoveTempFolder
REM Delete the Introduciator export to make clean export
if exist "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%" (
    ECHO Deleting export folder...
    RD "%BATCH_PATH%Introduciator_v%INTRODUCIATOR_VERSION%" /S /Q
)

GOTO Done

:Error
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
