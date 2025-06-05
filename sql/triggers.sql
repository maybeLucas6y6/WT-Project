CREATE TRIGGER trigger_add_favorite
AFTER INSERT ON assets
FOR EACH ROW
EXECUTE FUNCTION add_favorite_on_asset_insert();

CREATE TRIGGER trigger_prevent_duplicate_favorites
BEFORE INSERT ON favorite_assets
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_favorites();
