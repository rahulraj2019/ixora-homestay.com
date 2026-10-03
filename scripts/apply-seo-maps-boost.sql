-- Maps pin: https://maps.app.goo.gl/ht4uuSDodgYPxeKT6 → 12.043528,75.466966

INSERT INTO settings (`group`, `key`, `value`, `type`, created_at, updated_at)
VALUES
  ('contact', 'maps_link', 'https://maps.app.goo.gl/ht4uuSDodgYPxeKT6', 'text', NOW(), NOW()),
  ('contact', 'maps_embed', 'https://www.google.com/maps?q=12.043528,75.466966+(IXORA+Homestay)&z=16&output=embed', 'text', NOW(), NOW()),
  ('contact', 'map_query', '12.043528,75.466966', 'text', NOW(), NOW()),
  ('contact', 'geo_placename', 'Niduvaloor, Irikkur, Thaliparamba, Kannur, Kerala', 'text', NOW(), NOW()),
  ('contact', 'geo_position', '12.043528;75.466966', 'text', NOW(), NOW()),
  ('contact', 'geo_latitude', '12.043528', 'text', NOW(), NOW()),
  ('contact', 'geo_longitude', '75.466966', 'text', NOW(), NOW()),
  ('contact', 'geo_region', 'IN-KL', 'text', NOW(), NOW()),
  ('general', 'site_description', 'IXORA is an affordable family homestay in Kannur at Niduvaloor Gate near Irikkur and Thaliparamba — private 2 BHK home stay in Kannur Kerala with courtyard, kitchen, parking and easy access to beaches, forts and temples.', 'text', NOW(), NOW()),
  ('general', 'schema_description', 'Best homestay in Kannur near Irikkur and Thaliparamba: private 2 BHK family rooms, kitchen, parking, courtyard, campfire and grill. Ideal affordable homestay in Kannur Kerala for families and weekend getaways.', 'text', NOW(), NOW()),
  ('seo', 'meta_description', 'Best homestay in Kannur at IXORA Niduvaloor near Irikkur & Thaliparamba — affordable family homestay in Kannur Kerala with private 2 BHK, parking and courtyard.', 'text', NOW(), NOW()),
  ('seo', 'default_meta_title', 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba', 'text', NOW(), NOW()),
  ('seo', 'default_meta_description', 'Book IXORA — affordable family homestay in Kannur near Irikkur and Thaliparamba. Private 2 BHK home stay in Kannur Kerala with kitchen, parking and courtyard.', 'text', NOW(), NOW()),
  ('seo', 'seo_keywords', 'Homestay in Kannur, Best homestay in Kannur, Affordable homestay in Kannur, Family homestay in Kannur, Homestay near Kannur, Homestay in Thaliparamba, Homestay in Irikkur, Homestay near Irikkur, Homestay near Thaliparamba, Home stay in Kannur Kerala, Niduvaloor Homestay', 'text', NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `value` = VALUES(`value`),
  `type` = VALUES(`type`),
  updated_at = NOW();

UPDATE pages SET
  meta_title = 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba',
  meta_description = 'Book the best homestay in Kannur at IXORA Niduvaloor — affordable family homestay near Irikkur & Thaliparamba. Private 2 BHK home stay in Kannur Kerala with parking & courtyard.',
  og_title = 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba',
  og_description = 'Book the best homestay in Kannur at IXORA Niduvaloor — affordable family homestay near Irikkur & Thaliparamba. Private 2 BHK home stay in Kannur Kerala with parking & courtyard.',
  twitter_title = 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba',
  twitter_description = 'Book the best homestay in Kannur at IXORA Niduvaloor — affordable family homestay near Irikkur & Thaliparamba. Private 2 BHK home stay in Kannur Kerala with parking & courtyard.',
  updated_at = NOW()
WHERE slug = 'home';

UPDATE pages SET
  meta_title = 'Family Homestay in Kannur | Affordable Homestay near Irikkur',
  meta_description = 'Affordable family rooms at IXORA — a private homestay in Kannur near Irikkur and Thaliparamba with 2 bedrooms, kitchen, dining, courtyard and parking.',
  og_title = 'Family Homestay in Kannur | Affordable Homestay near Irikkur',
  og_description = 'Affordable family rooms at IXORA — a private homestay in Kannur near Irikkur and Thaliparamba with 2 bedrooms, kitchen, dining, courtyard and parking.',
  twitter_title = 'Family Homestay in Kannur | Affordable Homestay near Irikkur',
  twitter_description = 'Affordable family rooms at IXORA — a private homestay in Kannur near Irikkur and Thaliparamba with 2 bedrooms, kitchen, dining, courtyard and parking.',
  updated_at = NOW()
WHERE slug = 'stay';

UPDATE pages SET
  meta_title = 'Homestay in Kannur for Celebrations | Event Venue Niduvaloor',
  meta_description = 'Host birthdays and family gatherings at IXORA — a Kannur homestay near Thaliparamba & Irikkur with courtyard, stage, photo point, campfire and grill.',
  og_title = 'Homestay in Kannur for Celebrations | Event Venue Niduvaloor',
  og_description = 'Host birthdays and family gatherings at IXORA — a Kannur homestay near Thaliparamba & Irikkur with courtyard, stage, photo point, campfire and grill.',
  twitter_title = 'Homestay in Kannur for Celebrations | Event Venue Niduvaloor',
  twitter_description = 'Host birthdays and family gatherings at IXORA — a Kannur homestay near Thaliparamba & Irikkur with courtyard, stage, photo point, campfire and grill.',
  updated_at = NOW()
WHERE slug = 'events';

UPDATE pages SET
  meta_title = 'Things to Do near Homestay in Kannur | Explore from IXORA',
  meta_description = 'From your homestay near Kannur & Irikkur explore Muzhappilangad Beach, St. Angelo Fort, Parassinikadavu Temple, Paithalmala and more day trips.',
  og_title = 'Things to Do near Homestay in Kannur | Explore from IXORA',
  og_description = 'From your homestay near Kannur & Irikkur explore Muzhappilangad Beach, St. Angelo Fort, Parassinikadavu Temple, Paithalmala and more day trips.',
  twitter_title = 'Things to Do near Homestay in Kannur | Explore from IXORA',
  twitter_description = 'From your homestay near Kannur & Irikkur explore Muzhappilangad Beach, St. Angelo Fort, Parassinikadavu Temple, Paithalmala and more day trips.',
  updated_at = NOW()
WHERE slug = 'explore';

UPDATE pages SET
  meta_title = 'Homestay in Kannur Photos | IXORA Rooms & Courtyard Gallery',
  meta_description = 'See rooms, courtyard and celebration spaces at IXORA — an affordable family home stay in Kannur Kerala at Niduvaloor Gate near Irikkur.',
  og_title = 'Homestay in Kannur Photos | IXORA Rooms & Courtyard Gallery',
  og_description = 'See rooms, courtyard and celebration spaces at IXORA — an affordable family home stay in Kannur Kerala at Niduvaloor Gate near Irikkur.',
  twitter_title = 'Homestay in Kannur Photos | IXORA Rooms & Courtyard Gallery',
  twitter_description = 'See rooms, courtyard and celebration spaces at IXORA — an affordable family home stay in Kannur Kerala at Niduvaloor Gate near Irikkur.',
  updated_at = NOW()
WHERE slug = 'gallery';

UPDATE pages SET
  meta_title = 'Book Homestay in Kannur | IXORA near Irikkur & Thaliparamba',
  meta_description = 'Book an affordable family homestay in Kannur at IXORA Niduvaloor Gate. Check dates for private 2 BHK stay near Irikkur and Thaliparamba — WhatsApp rates.',
  og_title = 'Book Homestay in Kannur | IXORA near Irikkur & Thaliparamba',
  og_description = 'Book an affordable family homestay in Kannur at IXORA Niduvaloor Gate. Check dates for private 2 BHK stay near Irikkur and Thaliparamba — WhatsApp rates.',
  twitter_title = 'Book Homestay in Kannur | IXORA near Irikkur & Thaliparamba',
  twitter_description = 'Book an affordable family homestay in Kannur at IXORA Niduvaloor Gate. Check dates for private 2 BHK stay near Irikkur and Thaliparamba — WhatsApp rates.',
  updated_at = NOW()
WHERE slug = 'booking';

UPDATE pages SET
  meta_title = 'About IXORA | Homestay near Irikkur, Thaliparamba & Kannur',
  meta_description = 'IXORA is a traditional Kerala family homestay in Niduvaloor near Irikkur and Thaliparamba — private house, courtyard, kitchen and parking in Kannur district.',
  og_title = 'About IXORA | Homestay near Irikkur, Thaliparamba & Kannur',
  og_description = 'IXORA is a traditional Kerala family homestay in Niduvaloor near Irikkur and Thaliparamba — private house, courtyard, kitchen and parking in Kannur district.',
  twitter_title = 'About IXORA | Homestay near Irikkur, Thaliparamba & Kannur',
  twitter_description = 'IXORA is a traditional Kerala family homestay in Niduvaloor near Irikkur and Thaliparamba — private house, courtyard, kitchen and parking in Kannur district.',
  updated_at = NOW()
WHERE slug = 'about';

UPDATE pages SET
  meta_title = 'Homestay in Kannur FAQ | Location near Irikkur & Booking Tips',
  meta_description = 'FAQs for the best homestay in Kannur near Irikkur & Thaliparamba: location, parking, kitchen, check-in, events and day trips around Kannur Kerala.',
  og_title = 'Homestay in Kannur FAQ | Location near Irikkur & Booking Tips',
  og_description = 'FAQs for the best homestay in Kannur near Irikkur & Thaliparamba: location, parking, kitchen, check-in, events and day trips around Kannur Kerala.',
  twitter_title = 'Homestay in Kannur FAQ | Location near Irikkur & Booking Tips',
  twitter_description = 'FAQs for the best homestay in Kannur near Irikkur & Thaliparamba: location, parking, kitchen, check-in, events and day trips around Kannur Kerala.',
  updated_at = NOW()
WHERE slug = 'faq';

UPDATE pages SET
  meta_title = 'IXORA Homestay Reviews | Best Homestay in Kannur Guests',
  meta_description = 'Guest reviews of IXORA — family homestay in Kannur near Irikkur and Thaliparamba. Real stays, celebrations and Kerala hospitality at Niduvaloor.',
  og_title = 'IXORA Homestay Reviews | Best Homestay in Kannur Guests',
  og_description = 'Guest reviews of IXORA — family homestay in Kannur near Irikkur and Thaliparamba. Real stays, celebrations and Kerala hospitality at Niduvaloor.',
  twitter_title = 'IXORA Homestay Reviews | Best Homestay in Kannur Guests',
  twitter_description = 'Guest reviews of IXORA — family homestay in Kannur near Irikkur and Thaliparamba. Real stays, celebrations and Kerala hospitality at Niduvaloor.',
  updated_at = NOW()
WHERE slug = 'reviews';

UPDATE pages SET
  meta_title = 'Contact Homestay in Kannur | IXORA Niduvaloor near Irikkur',
  meta_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur & Thaliparamba. IXORA Niduvaloor Gate — +91 80757 71824 / +91 94968 50582.',
  og_title = 'Contact Homestay in Kannur | IXORA Niduvaloor near Irikkur',
  og_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur & Thaliparamba. IXORA Niduvaloor Gate — +91 80757 71824 / +91 94968 50582.',
  twitter_title = 'Contact Homestay in Kannur | IXORA Niduvaloor near Irikkur',
  twitter_description = 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur & Thaliparamba. IXORA Niduvaloor Gate — +91 80757 71824 / +91 94968 50582.',
  updated_at = NOW()
WHERE slug = 'contact';

UPDATE faqs SET
  answer = 'IXORA is at <strong>Building No. 7-334, Ixora Homestay, Niduvaloor Gate, Niduvaloor, 670142</strong>, Kannur district, Kerala — a private <strong>family homestay in Kannur</strong> near <strong>Irikkur</strong> and <strong>Thaliparamba</strong>. See the exact pin on <a href="https://maps.app.goo.gl/ht4uuSDodgYPxeKT6" target="_blank" rel="noopener">Google Maps</a>.',
  updated_at = NOW()
WHERE question = 'Where is IXORA Homestay located?';

SELECT ``group``, ``key``, LEFT(``value``, 100) AS v FROM settings WHERE ``key`` IN ('maps_link','maps_embed','map_query','geo_latitude','geo_longitude','seo_keywords','default_meta_title');
SELECT slug, meta_title FROM pages WHERE slug IN ('home','stay','contact','about','booking');
