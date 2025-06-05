DO $$
DECLARE
i INT := 0;
u_id INT;
a_id INT;
lista_nume TEXT[] := ARRAY[
        'Ababei','Acasandrei','Adascalitei','Afanasie','Agafitei','Agape','Aioanei','Alexandrescu','Alexandru','Alexe',
        'Alexii','Amarghioalei','Ambroci','Andonesei','Andrei','Andrian','Andrici','Andronic','Andros','Anghelina',
        'Anita','Antochi','Antonie','Apetrei','Apostol','Arhip','Arhire','Arteni','Arvinte','Asaftei','Asofiei',
        'Aungurenci','Avadanei','Avram','Babei','Baciu','Baetu','Balan','Balica','Banu','Barbieru','Barzu','Bazgan',
        'Bejan','Bejenaru','Belcescu','Belciuganu','Benchea','Bilan','Birsanu','Bivol','Bizu','Boca','Bodnar',
        'Boistean','Borcan','Bordeianu','Botezatu','Bradea','Braescu','Budaca','Bulai','Bulbuc-aioanei','Burlacu',
        'Burloiu','Bursuc','Butacu','Bute','Buza','Calancea','Calinescu','Capusneanu','Caraiman','Carbune','Carp',
        'Catana','Catiru','Catonoiu','Cazacu','Cazamir','Cebere','Cehan','Cernescu','Chelaru','Chelmu','Chelmus',
        'Chibici','Chicos','Chilaboc','Chile','Chiriac','Chirila','Chistol','Chitic','Chmilevski','Cimpoesu',
        'Ciobanu','Ciobotaru','Ciocoiu','Ciofu','Ciornei','Citea','Ciucanu','Clatinici','Clim','Cobuz','Coca',
        'Cojocariu','Cojocaru','Condurache','Corciu','Corduneanu','Corfu','Corneanu','Corodescu','Coseru','Cosnita',
        'Costan','Covatariu','Cozma','Cozmiuc','Craciunas','Crainiceanu','Creanga','Cretu','Cristea','Crucerescu',
        'Cumpata','Curca','Cusmuliuc','Damian','Damoc','Daneliuc','Daniel','Danila','Darie','Dascalescu','Dascalu',
        'Diaconu','Dima','Dimache','Dinu','Dobos','Dochitei','Dochitoiu','Dodan','Dogaru','Domnaru','Dorneanu',
        'Dragan','Dragoman','Dragomir','Dragomirescu','Duceac','Dudau','Durnea','Edu','Eduard','Eusebiu','Fedeles',
        'Ferestraoaru','Filibiu','Filimon','Filip','Florescu','Folvaiter','Frumosu','Frunza','Galatanu','Gavrilita',
        'Gavriliuc','Gavrilovici','Gherase','Gherca','Ghergu','Gherman','Ghibirdic','Giosanu','Gitlan','Giurgila',
        'Glodeanu','Goldan','Gorgan','Grama','Grigore','Grigoriu','Grosu','Grozavu','Gurau','Haba','Harabula',
        'Hardon','Harpa','Herdes','Herscovici','Hociung','Hodoreanu','Hostiuc','Huma','Hutanu','Huzum','Iacob',
        'Iacobuta','Iancu','Ichim','Iftimesei','Ilie','Insuratelu','Ionesei','Ionesi','Ionita','Iordache',
        'Iordache-tiroiu','Iordan','Iosub','Iovu','Irimia','Ivascu','Jecu','Jitariuc','Jitca','Joldescu','Juravle',
        'Larion','Lates','Latu','Lazar','Leleu','Leon','Leonte','Leuciuc','Leustean','Luca','Lucaci','Lucasi',
        'Luncasu','Lungeanu','Lungu','Lupascu','Lupu','Macariu','Macoveschi','Maftei','Maganu','Mangalagiu',
        'Manolache','Manole','Marcu','Marinov','Martinas','Marton','Mataca','Matcovici','Matei','Maties','Matrana',
        'Maxim','Mazareanu','Mazilu','Mazur','Melniciuc-puica','Micu','Mihaela','Mihai','Mihaila','Mihailescu',
        'Mihalachi','Mihalcea','Mihociu','Milut','Minea','Minghel','Minuti','Miron','Mitan','Moisa','Moniry-abyaneh',
        'Morarescu','Morosanu','Moscu','Motrescu','Motroi','Munteanu','Murarasu','Musca','Mutescu','Nastaca',
        'Nechita','Neghina','Negrus','Negruser','Negrutu','Nemtoc','Netedu','Nica','Nicu','Oana','Olanuta','Olarasu',
        'Olariu','Olaru','Onu','Opariuc','Oprea','Ostafe','Otrocol','Palihovici','Pantiru','Pantiruc','Paparuz',
        'Pascaru','Patachi','Patras','Patriche','Perciun','Perju','Petcu','Pila','Pintilie','Piriu','Platon',
        'Plugariu','Podaru','Poenariu','Pojar','Popa','Popescu','Popovici','Poputoaia','Postolache','Predoaia',
        'Prisecaru','Procop','Prodan','Puiu','Purice','Rachieru','Razvan','Reut','Riscanu','Riza','Robu','Roman',
        'Romanescu','Romaniuc','Rosca','Rusu','Samson','Sandu','Sandulache','Sava','Savescu','Schifirnet','Scortanu',
        'Scurtu','Sfarghiu','Silitra','Simiganoschi','Simion','Simionescu','Simionesei','Simon','Sitaru','Sleghel',
        'Sofian','Soficu','Sparhat','Spiridon','Stan','Stavarache','Stefan','Stefanita','Stingaciu','Stiufliuc',
        'Stoian','Stoica','Stoleru','Stolniceanu','Stolnicu','Strainu','Strimtu','Suhani','Tabusca','Talif','Tanasa',
        'Teclici','Teodorescu','Tesu','Tifrea','Timofte','Tincu','Tirpescu','Toader','Tofan','Toma','Toncu','Trifan',
        'Tudosa','Tudose','Tuduri','Tuiu','Turcu','Ulinici','Unghianu','Ungureanu','Ursache','Ursachi','Urse','Ursu',
        'Varlan','Varteniuc','Varvaroi','Vasilache','Vasiliu','Ventaniuc','Vicol','Vidru','Vinatoru','Vlad','Voaides',
        'Vrabie','Vulpescu','Zamosteanu','Zazuleac'
    ];
	addresses TEXT[] := ARRAY[
  'Strada Sfântul Lazăr 27, Iași',
  'Bulevardul Tudor Vladimirescu 79, Iași',
  'Strada Palat 3C, Iași',
  'Strada Smârdan 5, Iași',
  'Strada Codrescu 1, Iași',
  'Strada Vasile Lupu 62, Iași',
  'Aleea Nicolina 12, Iași',
  'Strada Universității 16, Iași',
  'Strada Petre Andrei 8, Iași',
  'Strada Sărărie 132, Iași',
  'Strada Canta 45, Iași',
  'Strada Toma Cozma 47, Iași',
  'Strada Păcurari 50, Iași',
  'Strada Gării 1, Iași',
  'Strada Pantelimon Halipa 20, Iași',
  'Strada Cismeaua Păcurari 15, Iași',
  'Strada Mușatini 9, Iași',
  'Strada Decebal 33, Iași',
  'Strada Petru Rareș 26, Iași',
  'Strada Grigore Ghica Vodă 15, Iași',
  'Strada Zugravi 19, Iași',
  'Strada Poitiers 10, Iași',
  'Strada Mitropolit Varlaam 14, Iași',
  'Strada Săulescu 5, Iași',
  'Strada Pantelimon 17, Iași',
  'Strada Regele Ferdinand 1, Iași',
  'Strada Lăpușneanu 21, Iași',
  'Strada Aurel Vlaicu 4, Iași',
  'Strada Sf. Ilie 3, Iași',
  'Strada Ion Creangă 6, Iași',
  'Strada Cicoarei 12, Iași',
  'Strada Nicolae Iorga 22, Iași',
  'Strada Mănăstirii 7, Iași',
  'Strada Rândunicii 10, Iași',
  'Strada Zimbrului 2, Iași',
  'Strada Cerna 18, Iași',
  'Strada Arcu 10, Iași',
  'Strada Vasile Conta 7, Iași',
  'Strada Stejar 6, Iași',
  'Strada Libertății 15, Iași',
  'Strada Dr. Savini 1, Iași',
  'Strada Ciric 3, Iași',
  'Strada Fundătura Răchitașului 5, Iași',
  'Strada Eternitate 11, Iași',
  'Strada Clopotari 9, Iași',
  'Strada Frumoasa 1, Iași',
  'Strada Aurel Popovici 12, Iași',
  'Strada Dr. Vicol 6, Iași',
  'Strada Zugravi 3, Iași',
  'Strada Bacinschi 14, Iași',
  'Strada Academiei 14, București',
  'Bulevardul Unirii 22, București',
  'Strada Eroilor 5, Cluj-Napoca',
  'Strada Republicii 30, Timișoara',
  'Strada Mihai Viteazu 12, Sibiu',
  'Strada Traian 8, Constanța',
  'Strada Cuza Vodă 9, Craiova',
  'Strada Alexandru cel Bun 4, Botoșani',
  'Strada Horea 21, Oradea',
  'Strada Petofi Sandor 16, Târgu Mureș',
  'Strada Ion Luca Caragiale 11, Ploiești',
  'Strada Gheorghe Doja 19, Arad',
  'Strada Tineretului 2, Baia Mare',
  'Strada Ștefan cel Mare 10, Suceava',
  'Strada 1 Decembrie 1918 13, Bistrița',
  'Strada Calea Moldovei 44, Bacău',
  'Strada Rozelor 7, Alba Iulia',
  'Strada Libertății 3, Satu Mare',
  'Strada Barbu Ștefănescu Delavrancea 6, Pitești',
  'Strada Stadionului 25, Slatina',
  'Strada Independenței 4, Focșani',
  'Strada Crinului 2, Zalău',
  'Strada Școlii 11, Reșița',
  'Strada Griviței 29, Râmnicu Vâlcea',
  'Strada Bucegi 8, Deva',
  'Strada Castanilor 5, Tulcea',
  'Strada Morii 17, Giurgiu',
  'Strada Primăverii 19, Alexandria',
  'Strada Progresului 6, Târgoviște',
  'Strada Mărășești 2, Călărași',
  'Strada Toamnei 4, Drobeta-Turnu Severin',
  'Strada Florilor 13, Piatra Neamț',
  'Strada Fabricii 15, Hunedoara',
  'Strada Constructorilor 20, Galați',
  'Strada Avram Iancu 18, Reghin',
  'Strada Timișului 12, Vaslui',
  'Strada Salcâmilor 7, Caracal',
  'Strada Gării 4, Tecuci',
  'Strada Tudor Vladimirescu 9, Bârlad',
  'Strada Cuza Vodă 11, Lugoj',
  'Strada Zorilor 6, Făgăraș',
  'Strada Mureșului 8, Medgidia',
  'Strada Brândușelor 10, Mangalia',
  'Strada Viitorului 3, Câmpina',
  'Strada Teilor 14, Câmpulung',
  'Strada Lalelelor 15, Sighetu Marmației',
  'Strada Bujorului 9, Pașcani',
  'Strada Spitalului 6, Buzău',
  'Strada Panait Cerna 5, Slobozia',
  'Strada Stadionului 1, Oltenița'
];
descs TEXT[] := ARRAY[
        'Spatioasa si moderna.',
        'Perfect pentru familii.',
        'Renovat recent.',
        'Locatie buna.',
        'Bun pentru investitori.',
        'Linistit.',
        'Aproape de autobuz.',
        'Cu gradina mare inclusa.',
        'Low maintenance.',
        'Gata de locuit.'
];

description TEXT;
price numeric;
user_id INT;
address TEXT;

name TEXT;
phone TEXT;
email TEXT;

category_names TEXT[] := ARRAY[
        'Apartment', 'House', 'Studio', 'Commercial', 'Land', 'Luxury',
        'New Construction', 'Vacation Home', 'Office Space', 'Warehouse'
    ];
    cat_name TEXT;
    asset_id INT;
    cat_id INT;
BEGIN
--GENERARE USERI
FOR i in 1..array_length(lista_nume,1) LOOP
	name := lista_nume[i];
	phone := '+40' || lpad((trunc(random() * 1000000000))::text,9,'0');

	email := lower(name) || '@gmail.com';

	INSERT INTO users (username, password, email, phone_number, role) VALUES
						(name, crypt(name, gen_salt('bf')), email, phone, 0);
	END LOOP;


FOR i in 1..array_length(addresses, 1) LOOP
	address := addresses[i];
	description := descs[ceil(random() * array_length(descs, 1))::int];
	price := round((random() * 90000 + 10000)::numeric, 2); 
	SELECT id INTO user_id FROM users ORDER BY random() LIMIT 1;

	INSERT INTO assets (description, price, address, user_id, lat, long)
    VALUES (description, price, address, user_id, NULL, NULL);
END LOOP;

    WHILE i < 100 LOOP  
        SELECT id INTO u_id FROM users ORDER BY random() LIMIT 1;
        SELECT id INTO a_id FROM assets ORDER BY random() LIMIT 1;

  
        BEGIN
            INSERT INTO favorite_assets (user_id, asset_id)
            VALUES (u_id, a_id);
        EXCEPTION WHEN unique_violation THEN

        END;

        i := i + 1;
    END LOOP;

	FOREACH cat_name IN ARRAY category_names LOOP
        INSERT INTO categories(category)
        VALUES (cat_name);
    END LOOP;

    FOR asset_id IN SELECT id FROM assets LOOP
        SELECT id INTO cat_id
        FROM categories
        ORDER BY RANDOM()
        LIMIT 1;

        INSERT INTO asset_category(asset_id, category_id)
        VALUES (asset_id, cat_id)
        ON CONFLICT DO NOTHING;
    END LOOP;
END;
$$