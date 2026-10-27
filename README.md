# Woocurs Internship – Day 2: MySQL + PHP Backend

The HTML form saves its data to a MySQL database through PHP, with server-side validation.

## Files

| File | Purpose |
|------|---------|
| `database.sql` | Creates the database and the `entries` table |
| `config.php` | Database connection (included by the other PHP files) |
| `test_conn.php` | Quick check that PHP can reach the database |
| `form.html` | The input form (sends data to `form.php` with POST) |
| `form.php` | Validates the input, checks for duplicates, and inserts the row |

## Requirements

- XAMPP (Apache + MySQL + PHP 8+). Any similar stack such as WAMP or MAMP also works.
- A web browser.

## Setup (step by step)

1. **Start the servers.** Open the XAMPP Control Panel and start **Apache** and **MySQL**.

2. **Copy the project into the web root.**
   - Windows: `C:\xampp\htdocs\woocurs-day2\`
   - macOS: `/Applications/XAMPP/htdocs/woocurs-day2/`

3. **Create the database and table.**
   - Open http://localhost/phpmyadmin
   - Click the **SQL** tab, paste the contents of `database.sql`, and click **Go**.
   - (Alternative: use **Import** and choose `database.sql`.)
   - Check that `woocurs_internship_db` now has a table called `entries`.

4. **Check the connection.** Open http://localhost/woocurs-day2/test_conn.php
   You should see **Database Connected!** and **Table 'entries' found.**

5. **Submit the form.** Open http://localhost/woocurs-day2/form.html, fill it in, and press **Submit**.
   - Success: "Entry added successfully!"
   - Bad input: the page lists what to fix.

6. **Verify in phpMyAdmin.** Click `entries` → **Browse**. The new row should be there.

> Always open the pages through `http://localhost/...`. Opening the file directly (`file:///...`) will not run the PHP.

## Validation rules

| Field | Rule |
|-------|------|
| Name | Required, up to 100 characters |
| Email | Required, valid email format, up to 100 characters, must not already exist |
| Phone | Required, exactly 10 digits (`0712345678`) |

The rules are checked in two places: in the browser (`form.html`, for quick feedback) and on the server (`form.php`, which is the one that matters).

## Changing the database settings

If your MySQL password is not empty, or you use a different database name, edit `config.php`:

```php
$username = "root";
$password = "";                       // your MySQL password
$database = "woocurs_internship_db";  // must match the name in database.sql
```

## Troubleshooting

| Problem | Fix |
|---------|-----|
| `Access denied for user 'root'` | Check `$username` and `$password` in `config.php` |
| `Unknown database 'woocurs_internship_db'` | Run `database.sql` in phpMyAdmin |
| `Table 'entries' doesn't exist` | Run `database.sql` again |
| Form submits but nothing is saved | Make sure you opened the form via `http://localhost/...` |
| Port 80 or 3306 already in use | Stop the other program, or change the port in XAMPP |

## End-of-day tasks (done by hand)

Git:

```bash
git add .
git commit -m "Day 2 - MySQL DB + PHP backend + form insertion"
git push origin main
```

Google Sheet: add a row with Date, Task Description, Status, GitHub Link and Recording Link.

Recording: record the session and upload it to Google Drive, then paste the link in the sheet.

## References

- PHP MySQL connect: https://www.w3schools.com/php/php_mysql_intro.asp
- PHP form handling: https://www.w3schools.com/php/php_forms.asp
- GitHub guide: https://guides.github.com
