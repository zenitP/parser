# parser
Parsing an xls file in a database (pricelist.xls), followed by uploading to the browser. Work with the resulting table (adding the column "Note", work with color, various kinds of calculations). A simple filter using ajax technology (fetching data without reloading the page). Validation of fields for the presence / correctness of input data. Basic protection against sql injection through these fields.

launch on Linux, if necessary, install packages

1)service apache2 start;

2)service mysql start;

3)mysql -p

4)enter password

5)all that is required is to create a database with the command: (create database pricelist);

6)to make sure everything is done correctly, run the command (show databases;) and find the name of the database you just created

7)download and unzip the archive to / var / www / html and run in the browser line, indicating the full path. For example: localhost / parser-master / index.html

