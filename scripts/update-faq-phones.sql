UPDATE faqs SET
  answer = REPLACE(REPLACE(answer, '918075771824', '918921525086'), '+91 80757 71824', '+91 89215 25086')
WHERE answer LIKE '%80757%' OR answer LIKE '%94968%' OR answer LIKE '%wa.me%';

UPDATE faqs SET
  answer = REPLACE(answer, '+91 94968 50582', '+91 80757 71824'),
  updated_at = NOW()
WHERE answer LIKE '%94968%';

UPDATE pages SET
  meta_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 89215 25086 / +91 80757 71824.',
  og_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 89215 25086 / +91 80757 71824.',
  twitter_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 89215 25086 / +91 80757 71824.',
  updated_at = NOW()
WHERE slug = 'contact';

DELETE FROM cache;
