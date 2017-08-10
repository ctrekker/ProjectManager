rmdir C:\Users\ctrek\Documents\Programming\server\ProjectManager\build /s /q
xcopy C:\Users\ctrek\Documents\Programming\server\ProjectManager C:\Users\ctrek\Documents\Programming\server\_tmp_ /e /i /h /y
xcopy C:\Users\ctrek\Documents\Programming\server\_tmp_ C:\Users\ctrek\Documents\Programming\server\ProjectManager\build /e /i /h /y
rmdir C:\Users\ctrek\Documents\Programming\server\_tmp_ /s /q
del .\build\build.bat
del .\build\compiler.jar
java -jar compiler.jar --js .\build\lib\js\main.js --js_output_file .\build\lib\js\main.js --compilation_level SIMPLE