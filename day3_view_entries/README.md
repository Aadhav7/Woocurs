# Day 3 – Fetch & Display Entries (PHP + MySQL)

Covers the Day 3 PDF: display entries in a Bootstrap table, search by name or email, pagination (5 per page), and alternating/hover row styling.

## Files

| File | Purpose |
|---|---|
| `config.php` | Database connection (`$conn`) |
| `database.sql` | Creates database `woocurs_day3`, table `entries`, and 6 sample rows |
| `view.php` | The display page: table, search, pagination |

## Run it with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy the `day3_view_entries` folder into `C:\xampp\htdocs\` (so `view.php` is at `C:\xampp\htdocs\day3_view_entries\view.php`).
3. Open `http://localhost/phpmyadmin`, click **Import**, choose `database.sql`, and click **Go**.
4. Open **http://localhost/day3_view_entries/view.php**

If your MySQL login is not `root` with an empty password, edit the four values at the top of `config.php`.

## Test (PDF mini tasks)

- **Mini Task 1:** The six sample entries appear in the table.
- **Mini Task 2:** Type `nimal` (or part of an email) and press Enter. Only matching rows appear. Click **Clear** to reset.
- **Mini Task 3:** Rows alternate colours and highlight on hover.
- **Pagination:** Five rows on page 1, one on page 2. Use **Previous** and **Next**. The search term is kept while paging.

## Notes

- Search and page numbers use prepared statements, so text typed in the search box cannot change the SQL. The PDF's example code puts the search text straight into the SQL, which is unsafe.
- Re-importing `database.sql` resets the table to the six sample rows.
