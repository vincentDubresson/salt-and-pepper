INSERT INTO recipe
(
 id,
 subcategory_id,
 cooking_type_id,
 difficulty_id,
 cost_id,
 user_id,
 label,
 description,
 serving_number,
 preparation_time,
 cooking_time,
 resting_time,
 meta_description,
 meta_keywords,
 enabled,
 created_at,
 updated_at,
 slug
)
VALUES
(
 1,
 26,
 2,
 1,
 1,
 1,
 'Oeufs brouillés',
 'Des oeufs brouillés d''une onctuosité veloutée, délicatement crémeux et fondants, préparés avec soin. Leur texture soyeuse révèle une gourmandise délicate, où chaque bouchée offre un nuage moelleux de saveurs délicieuses. Un plat simple mais raffiné, qui transforme un classique en une expérience culinaire d''une élégante simplicité.',
 1,
 '00:05:00',
 '00:05:00',
 '00:00:00',
 'Oeufs brouillés crémeux et onctueux : un délice gourmand, fondant en bouche, préparé avec passion pour un encas raffiné et savoureux.',
 'oeufs brouillés, recette crémeuse, petit-déjeuner gourmand, plat onctueux, recette facile, oeufs fondants, cuisine française, petit-déjeuner raffiné',
 0,
 NOW(),
 NOW(),
 'oeufs-brouilles'
);