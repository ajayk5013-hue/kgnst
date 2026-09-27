# kgnst.com website

A PHP 8.1+ and SQLite website for kgnst.com, an initiative of Khawaja Garib Nawaj Sewa Trust. Official domain: `https://kgnst.com`.

## Features

- Public home and about pages
- Student account registration with server-generated KGNST registration numbers
- SQLite database (`data/kgn.sqlite`, created automatically)
- Passwords stored securely using PHP password hashing
- One-time setup to create the administrator account
- Protected admin dashboard to view student registrations

## Run locally

1. Install PHP 8.1 or newer with the `pdo_sqlite` extension enabled.
2. Extract the project and open a terminal in this folder.
3. Start the built-in server:

   ```bash
   php -S localhost:8000
   ```

4. Open `http://localhost:8000/setup.php` and create the administrator account.
5. Visit `http://localhost:8000/` for the public website. Use `/admin.php` to view registrations.

## Deployment

Upload every file to a PHP-enabled host. Ensure the web-server process has write permission for the `data/` directory so it can create and update `kgn.sqlite`. Use HTTPS in production and back up `data/kgn.sqlite` regularly.

## Trust founded year

The Trust’s founding year has not been supplied, so this project intentionally does not claim one. Add only a verified year to `about.php` when available.
