CREATE OR REPLACE FUNCTION update_asset_location(
    p_id INTEGER,
    p_lat DOUBLE PRECISION,
    p_long DOUBLE PRECISION
)
RETURNS VOID
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE assets
    SET lat = p_lat,
        long = p_long
    WHERE id = p_id;
END;
$$;
CREATE OR REPLACE FUNCTION get_assets_within_distance(
    p_distance_km DOUBLE PRECISION,
    p_lat DOUBLE PRECISION,
    p_long DOUBLE PRECISION
)
RETURNS TABLE (
    id INT,
    description TEXT,
    address TEXT,
    price NUMERIC,
    user_id INT,
	lat NUMERIC,
	long NUMERIC
) AS $$
DECLARE
	earth_radius CONSTANT DOUBLE PRECISION := 6371;
	assset_distance DOUBLE PRECISION;
BEGIN
	RETURN QUERY SELECT a.id, a.description, a.address, a.price, a.user_id, a.lat, a.long FROM assets a
    WHERE (
        earth_radius * acos(
            cos(radians(p_lat)) * cos(radians(a.lat)) *
            cos(radians(a.long) - radians(p_long)) +
            sin(radians(p_lat)) * sin(radians(a.lat))
        )
    ) <= p_distance_km;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION filter_assets_by_price(min_price NUMERIC, max_price NUMERIC)
RETURNS TABLE (
    id INT,
    description TEXT,
    address TEXT,
    price NUMERIC,
    user_id INT,
	lat NUMERIC,
	long NUMERIC
) AS $$
BEGIN
    RETURN QUERY
    SELECT a.id, a.description, a.address, a.price, a.user_id, a.lat, a.long
    FROM assets a
    WHERE a.price BETWEEN min_price AND max_price
    ORDER BY a.price;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION add_favorite_on_asset_insert()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO favorite_assets (user_id, asset_id)
    VALUES (NEW.user_id, NEW.id);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_favorite_assets(p_user_id INT)
RETURNS TABLE (
    id INT,
    description TEXT,
    address TEXT,
    price NUMERIC,
    user_id INT,
	lat NUMERIC,
	long NUMERIC
) AS $$
BEGIN
    RETURN QUERY
    SELECT a.id, a.description, a.address, a.price, a.user_id, a.lat, a.long
    FROM favorite_assets f
    JOIN assets a ON a.id = f.asset_id
    WHERE f.user_id = p_user_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION prevent_duplicate_favorites()
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1 FROM favorite_assets
        WHERE user_id = NEW.user_id AND asset_id = NEW.asset_id
    ) THEN
        RAISE EXCEPTION 'User % has already favorited asset %', NEW.user_id, NEW.asset_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_asset_with_category(
    p_description TEXT,
    p_address TEXT,
    p_price NUMERIC,
    p_lat DOUBLE PRECISION,
    p_lng DOUBLE PRECISION,
    p_user_id INTEGER,
    p_category_name TEXT
) RETURNS INTEGER AS $$
DECLARE
    v_asset_id INTEGER;
    v_category_id INTEGER;
BEGIN

    SELECT id INTO v_category_id FROM categories WHERE category = p_category_name;

    IF v_category_id IS NULL THEN
        RAISE EXCEPTION 'Category % not found in the database.', p_category_name;
    END IF;


    INSERT INTO assets (description, address, price, lat, long, user_id)
    VALUES (p_description, p_address, p_price, p_lat, p_lng, p_user_id)
    RETURNING id INTO v_asset_id;


    INSERT INTO asset_category (asset_id, category_id)
    VALUES (v_asset_id, v_category_id);

	RETURN v_asset_id;
END;
$$ LANGUAGE plpgsql;




DO $$
BEGIN
	perform update_asset_location(1, 10, 10);
END
$$;
SELECT * FROM get_assets_within_distance(1, 42, 20);
select * from get_favorite_assets(3);
select * from favorite_assets;
select * from users;
SELECT * FROM ASSETS;