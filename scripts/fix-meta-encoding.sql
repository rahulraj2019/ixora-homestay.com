UPDATE pages SET
  meta_description = REPLACE(REPLACE(meta_description, CHAR(8212), '-'), '—', '-'),
  og_description = REPLACE(REPLACE(og_description, CHAR(8212), '-'), '—', '-'),
  twitter_description = REPLACE(REPLACE(twitter_description, CHAR(8212), '-'), '—', '-'),
  updated_at = NOW()
WHERE slug IN ('home','stay','events','explore','gallery','booking','about','faq','reviews','contact');

UPDATE settings SET
  value = REPLACE(REPLACE(value, CHAR(8212), '-'), '—', '-'),
  updated_at = NOW()
WHERE `key` IN ('meta_description','default_meta_description','site_description','schema_description','seo_keywords');

UPDATE pages SET
  meta_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 80757 71824 / +91 94968 50582.',
  og_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 80757 71824 / +91 94968 50582.',
  twitter_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 80757 71824 / +91 94968 50582.',
  updated_at = NOW()
WHERE slug = 'contact';

DELETE FROM cache;
