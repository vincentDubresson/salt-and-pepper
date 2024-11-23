INSERT INTO `user`
    (
     `id`,
     `firstname`,
     `lastname`,
     `email`,
     `trusted_version`,
     `password`,
     `roles`,
     `address1`,
     `address2`,
     `city_id`,
     `country_id`,
     `enabled`,
     `slug`,
     `created_at`,
     `updated_at`
    )
VALUES
    (
     1,
     'Vincent',
     'Dubresson',
     "vincent.dubresson@live.fr",
     0,
     "$2y$13$TjIJuX5Y45RXgon3buNTP.yrDxuu5m.iF37OIBSAUYUmU3epgjufW",
     '["ROLE_SONATA_ADMIN", "ROLE_ADMIN", "ROLE_USER"]',
     '8 Grande Rue',
     'Bâtiment B3',
     17856,
     77,
     1,
     'vincent-dubresson',
     NOW(),
     NOW()
    )
;