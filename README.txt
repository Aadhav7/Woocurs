WOOCURS INTERNSHIP - DAYS 3, 4 & 5 COMPLETE PROJECT
===================================================

WHAT IS INCLUDED
- Day 3: PHP/MySQL read operation, Bootstrap table, search by name/email/phone, pagination, table hover.
- Day 4: Edit and delete records, server-side validation, prepared SQL statements, safe delete flow.
- Day 5: JavaScript live validation, uppercase names, digits-only phone input, sortable table columns, Bootstrap delete confirmation modal, success alerts, responsive layout.
- Supporting create.php is included so you can add test entries without needing the previous day's project.

REQUIREMENTS
- Windows with XAMPP (Apache + MySQL)
- A web browser
- Internet connection for Bootstrap CDN styling/scripts (the PHP app and database still run locally; CDN styling requires internet)

RUN IT IN XAMPP
1. Extract the ZIP file.
2. Copy the folder "Woocurs_Day3-5_Complete" into:
   C:\xampp\htdocs\
   Final folder should be C:\xampp\htdocs\Woocurs_Day3-5_Complete\
3. Open XAMPP Control Panel and start Apache and MySQL.
4. Open http://localhost/phpmyadmin
5. Click the Import tab, choose:
   C:\xampp\htdocs\Woocurs_Day3-5_Complete\sql\database.sql
   Then click Import/Go. (If import is not convenient, open the SQL tab and paste the contents of database.sql.)
6. Open this URL:
   http://localhost/Woocurs_Day3-5_Complete/view.php
7. Try Add Entry, search, pagination, click Name/Email/Phone/Created headings to sort, Edit a row, and Delete a row (the Bootstrap modal asks for confirmation).

DATABASE SETTINGS
Default settings in config.php:
Host: localhost
Database: woocurs_entries
Username: root
Password: (blank)
If your MySQL root account has a password, update $password in config.php.

TROUBLESHOOTING
- Apache/MySQL won't start: check whether another program is using ports 80/443 or 3306.
- Unknown database: import sql/database.sql first.
- Database connection failed: confirm MySQL is running and config.php credentials match your XAMPP setup.
- Page shows PHP code as text: open it through http://localhost/... rather than double-clicking the PHP file.
- Bootstrap design missing: check internet connection because Bootstrap is loaded from a CDN.

TEST CHECKLIST
[ ] Seed sample records appear in the table.
[ ] Search by part of a name, email or phone works.
[ ] Pagination works when enough records exist.
[ ] Add Entry saves a valid entry; invalid input is blocked.
[ ] Edit changes persist after returning to the table.
[ ] Delete opens a confirmation modal; Cancel keeps the record, Yes deletes it.
[ ] Table column sorting works for the currently visible rows.
[ ] Phone field strips non-numeric characters and name becomes uppercase while typing.

NOTE ABOUT EXTERNAL DELIVERABLES
The PDFs also ask you to push the project to your own GitHub repository, update your internship Google Sheet, and share a coding recording. Those steps require your own accounts and cannot be completed inside this ZIP. After testing, you can use the commit messages in each PDF or commit with:
  git add .
  git commit -m "Day 3-5 - PHP MySQL CRUD and front-end enhancements"
  git push origin main
