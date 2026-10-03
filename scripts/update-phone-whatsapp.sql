UPDATE settings SET value = '+91 89215 25086', updated_at = NOW() WHERE `key` = 'phone_primary';
UPDATE settings SET value = '+91 80757 71824', updated_at = NOW() WHERE `key` = 'phone_secondary' AND (`value` IS NULL OR `value` = '' OR `value` LIKE '%94968%' OR `value` LIKE '%80757%');
UPDATE settings SET value = '918921525086', updated_at = NOW() WHERE `key` = 'whatsapp';

INSERT INTO settings (`group`, `key`, `value`, `type`, created_at, updated_at)
SELECT 'contact', 'phone_primary', '+91 89215 25086', 'text', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE `key` = 'phone_primary');

INSERT INTO settings (`group`, `key`, `value`, `type`, created_at, updated_at)
SELECT 'contact', 'whatsapp', '918921525086', 'text', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE `key` = 'whatsapp');

DELETE FROM cache;
SELECT `key`, `value` FROM settings WHERE `key` IN ('phone_primary','phone_secondary','whatsapp');
