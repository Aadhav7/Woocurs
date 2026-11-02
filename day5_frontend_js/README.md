# Day 5 – Front-End JavaScript, Modals & Responsive UI

Covers the Day 5 PDF and includes everything from Days 3 and 4 (search, pagination, edit, delete).

## Files

| File | Purpose |
|---|---|
| `config.php` | Database connection (`$conn`) |
| `database.sql` | Creates database `woocurs_day5`, table `entries`, and 6 sample rows |
| `view.php` | Entries list: sorting, hover highlight, live filter, delete modal, alerts, pagination |
| `register.php` | Add Entry form (real-time validation, uppercase names, numbers-only phone) |
| `update.php` | Edit Entry form (same form and checks as Add) |
| `delete.php` | Deletes one entry, then returns to the list with a message |
| `includes/header.php` | Page top: Bootstrap, responsive navbar |
| `includes/footer.php` | Page bottom: footer and Bootstrap JavaScript |
| `includes/entry_form.php` | The form shared by Add and Edit |
| `includes/helpers.php` | `e()` escaping, server-side `validateEntry()`, `flashAlert()` messages |

## Run it with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy the `day5_frontend_js` folder into `C:\xampp\htdocs\`.
3. Open `http://localhost/phpmyadmin`, click **Import**, choose `database.sql`, and click **Go**.
4. Open **http://localhost/day5_frontend_js/view.php**

If your MySQL login is not `root` with an empty password, edit the four values at the top of `config.php`.

Bootstrap loads from a CDN, so you need an internet connection for the styling.

## Test (PDF mini tasks)

**Form (Add Entry and Edit Entry)**
- Type two letters in Name: the border turns red. Type a third: it turns green.
- Type lowercase letters in Name: they change to UPPERCASE.
- Type letters in Phone: they disappear. Only digits remain.
- Submit with a bad email or a short phone number: the errors are listed and nothing is saved.
- Submit a valid entry: the list appears with "Entry submitted successfully!".

**Table (All Entries)**
- Click the **Name**, **Email** or **Phone** heading: the rows sort. Sorting is alphabetical text, so "10" comes before "9".
- Move the mouse over a row: it turns light grey.
- Type in the search box: rows that do not match are hidden straight away. Press Enter or **Search** to search all pages.

**Modal and alerts**
- Click **Delete**: a Bootstrap modal appears (not the browser's popup). **Cancel** or Esc does nothing.
- Click **Yes, Delete**: that entry is removed and "Entry deleted successfully!" appears. Check a different row to confirm the correct entry was deleted.
- **Edit** an entry and save: "Entry updated successfully!" appears.

**Responsive**
- Press F12, then Ctrl+Shift+M, and choose a phone size. The table scrolls sideways and the navbar collapses into the ☰ button.

## Notes

- The JavaScript checks are a convenience. The server (`includes/helpers.php`) checks the same rules again before saving.
- Search and page numbers use prepared statements. The PDF's examples put text straight into the SQL, which is unsafe.
- The PDF's modal link always pointed at `delete.php?id=1`. Here each row's Delete button passes its own id.
- Re-importing `database.sql` resets the table to the six sample rows.
