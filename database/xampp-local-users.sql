-- Local XAMPP account setup for the existing mobile_store database.
-- Run this file in phpMyAdmin while logged in as a MySQL administrator.
-- Replace every CHANGE_THIS_* value with a strong password you choose.
-- Use the exact same values in the matching .env variables.
-- This does not create, alter, or delete application tables or their data.

CREATE USER IF NOT EXISTS 'mobile_store_app'@'localhost'
    IDENTIFIED BY 'CHANGE_THIS_APP_PASSWORD';
ALTER USER 'mobile_store_app'@'localhost'
    IDENTIFIED BY 'CHANGE_THIS_APP_PASSWORD';
GRANT SELECT, INSERT, UPDATE, DELETE
    ON mobile_store.* TO 'mobile_store_app'@'localhost';

CREATE USER IF NOT EXISTS 'mobile_store_migrator'@'localhost'
    IDENTIFIED BY 'CHANGE_THIS_MIGRATION_PASSWORD';
ALTER USER 'mobile_store_migrator'@'localhost'
    IDENTIFIED BY 'CHANGE_THIS_MIGRATION_PASSWORD';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX
    ON mobile_store.* TO 'mobile_store_migrator'@'localhost';
