CREATE TABLE IF NOT EXISTS login_attempts (
    scope_hash CHAR(64) NOT NULL PRIMARY KEY,
    attempt_count SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    window_started_at DATETIME NOT NULL,
    blocked_until DATETIME NULL,
    last_attempt_at DATETIME NOT NULL,
    INDEX idx_login_attempts_cleanup (last_attempt_at),
    INDEX idx_login_attempts_blocked (blocked_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
