DO $$
DECLARE
    category_names TEXT[] := ARRAY[
        'Apartment', 'House', 'Studio', 'Commercial', 'Land', 'Luxury',
        'New Construction', 'Vacation Home', 'Office Space', 'Warehouse'
    ];
    cat_name TEXT;
    asset_id INT;
    cat_id INT;
BEGIN
    -- Insert each category into categories table
    FOREACH cat_name IN ARRAY category_names LOOP
        INSERT INTO categories(category)
        VALUES (cat_name);
    END LOOP;

    -- For each asset, assign exactly one random category
    FOR asset_id IN SELECT id FROM assets LOOP
        SELECT id INTO cat_id
        FROM categories
        ORDER BY RANDOM()
        LIMIT 1;

        INSERT INTO asset_category(asset_id, category_id)
        VALUES (asset_id, cat_id)
        ON CONFLICT DO NOTHING;
    END LOOP;
END $$;


select * from asset_category;