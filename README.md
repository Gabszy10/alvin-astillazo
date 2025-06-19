# alvin-astillazo
Project of Alvin

## Doctor Accounts

This update introduces a simple login and dashboard for veterinarians.  Doctors
can sign in through `doctor_login.php` and view their pending appointments and
appointment history on `doctor_dashboard.php`.  The database schema now includes
a `password_hash` column in the `vets` table for authentication.

The regular `login.php` page also provides a link to the doctor login for easy
access.
