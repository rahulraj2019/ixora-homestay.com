UPDATE faqs SET
  answer = 'IXORA is at <strong>Building No. 7-334, Ixora Homestay, Niduvaloor Gate, Niduvaloor, 670142</strong>, Kannur district, Kerala - a private <strong>family homestay in Kannur</strong> near <strong>Irikkur</strong> and <strong>Thaliparamba</strong>. See the exact pin on <a href="https://maps.app.goo.gl/ht4uuSDodgYPxeKT6" target="_blank" rel="noopener">Google Maps</a>.',
  updated_at = NOW()
WHERE question = 'Where is IXORA Homestay located?';

DELETE FROM cache WHERE `key` LIKE '%app_settings%' OR `key` LIKE '%schema_approved_reviews%';
DELETE FROM cache_locks WHERE `key` LIKE '%app_settings%';
