# Day 4 – Update & Delete Records (PHP + MySQL CRUD)

Covers the Day 4 PDF: `delete.php`, `update.php` with validation, and Edit/Delete buttons in `view.php`. It also includes everything from Day 3 (search and pagination).

## Files

| File | Purpose |
|---|---|
| `config.php` | Database connection (`$conn`) |
| `database.sql` | Creates database `woocurs_day4`, table `entries`, and 6 sample rows |
| `view.php` | List page with search, pagination, and Edit / Delete buttons |
| `update.php` | Edit form. Loads the record, validates, and saves |
| `delete.php` | Deletes a record by id, then returns to `view.php` |

## Run it with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy the `day4_update_delete` folder into `C:\xampp\htdocs\`.
3. Open `http://localhost/phpmyadmin`, click **Import**, choose `database.sql`, and click **Go**.
4. Open **http://localhost/day4_update_delete/view.php**

If your MySQL login is not `root` with an empty password, edit the four values at the top of `config.php`.

## Test (PDF mini tasks)

- **Delete:** Click **Delete** and confirm the browser prompt. The row disappears. Cancel leaves it in place. Check phpMyAdmin if you want to see the change in the database.
- **Edit:** Click **Edit**. The fields are filled in. Change a value and click **Update**. The change appears in the list.
- **Validation:** On the edit page, clear a field and click **Update**: "All fields are required!" appears and nothing is saved. Also try an invalid email, or a phone number shorter than 7 characters.

## Notes

- Every query that uses an id or a search term uses a prepared statement. The PDF's examples put that text straight into the SQL, which is unsafe.
- Validation messages appear above the form. The PDF used `die()`, which would show a bare error page.
- Re-importing `database.sql` resets the table to the six sample rows.
