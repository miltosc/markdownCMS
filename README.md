# markdownCMS

Create a small static html site from multiple markdown files for easy reading , editing and searching.

https://github.com/miltosc/markdownCMS

#Screenshots

![screenshot of UI](./screenshot1.jpg?raw=true "screenshot of UI")

#Configuration

Change "web-app\main_files\config.php" to edit your markdown files.

You can add as many files you wish from different directories, from anywhere your php installation has access.


The generated html output goes to the folder "html-output" and your original folders and markdown files remain untouched.


All you need is just PHP and a Web server.


No DB is used, just plain text files, html and markdown.


#Features

*   created html files are saved in "html-output". 
You can copy that folder and inc folder anywhere you want to have an html portable version of your notes.

*   Automatically creates menu of all headings that use markdown symbol "#" at the top of the resulted html file without adding the code to your original markdown files. So markdown files remain untouched but in the html preview you have a nice convenient menu.

*   Clicking the option "Recreate all html files and main menu" creates an extra file with all files menus and you can browse all your html output as a portable html website by clicking the option "Main Navigation menu".

*   Easily copy to your clipboard any code block for further proccessing with your favourite editor.

*   At your right, each text that is selected, pops up "Edit here" button that searches for that text in the editor at your left.
_Click multiple times the button to go to the next occurence in the editor if there are multiple_.

*   Search for a term through all your html output files and the menus created.

*   Easily search your favourite files list.

*   When you reopen a file the editor and output remembers the cursor and scroll position you where last time for quick editing and preview.
 
*   Choose between simple or rich editor and it will remember each editor's cursor position.

*   keeps backup of every file you change in the last N days in folder "tmp_backup_files".


#Notes
For those who use older version just run "Recreate all html files and main menu" from the menu at the header and will recreate correctly all the static website.

Any recommendations bug reports etc are welcome.
Keep in mind that this project created for my own personal use since i did not found something similar open source and self hosted solution.

#Credits
I used the following projects and you will find them in my files.

erusev's parsedown
https://github.com/erusev/parsedown

erusev's parsedown-extra
https://github.com/erusev/parsedown-extra 

cdolivet's EditArea
https://github.com/cdolivet/EditArea

madrobby's keymaster
https://github.com/madrobby/keymaster

jcubic's jquery.splitter
https://github.com/jcubic/jquery.splitter

Thanks to all of you folks.
