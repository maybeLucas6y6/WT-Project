
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Documentatie proiect TW - REAL ESTATE MANAGER</title>
    <link rel="stylesheet" href="/views/mapView.css">
</head>
<body>
<div class="big-wrapper">
<h1>Documentatie proiect TW - REAL ESTATE MANAGER</h1>
<h2>Cuprins</h2>
<ul>
    <li><a href="#cerinte-obligatorii-specifice">Cerinte Obligatorii Specifice Proiectului</a></li>
    <li><a href="#cerinte-obligatorii">Cerinte Obligatorii</a></li>
    <li><a href="#apeluri-api">Apeluri de API</a></li>
    <li><a href="#implementari-motivatii">Implementari, motivatii.</a></li>
</ul>
<section id="cerinte-obligatorii-specifice">
    <p><b> Enunt proiect: </b></p>
    <p> Este necesară o <b>aplicație Web</b> menită a gestiona eficient tranzacțiile imobiliare. Sistemul va <b>permite managementul unor imobile spre vânzare și/sau închiriere, inclusiv informații precum descriere, preț, coordonatele locației, date de contact, starea clădirii, facilități oferite, riscuri posibile </b> etc. Pentru localizarea facilă, se va recurge la un <b>serviciu de cartografiere (e.g., OpenStreetMap)</b>. În plus, se va oferi și posibilitatea atașării de <b>straturi suplimentare </b>pentru vizualizarea unor informații de interes -- e.g. diversele tipuri de poluare, nivelul de aglomerație, numărul de raportări de jafuri, costul mediu de trai, temperatura medie anuală, existența parcărilor ori altor obiective de interes (i.e. magazine) și altele. Utilizatorii interesați de închirierea/cumpărarea unei locuințe (e.g. apartament, casă, loc de veci etc.) vor putea efectua diverse operațiuni folosind harta pusă la dispoziție: <b>selectarea zonei de interes pentru afișarea opțiunilor existente, selectarea diverselor straturi pentru luarea deciziei, filtrare în funcție de alte criterii (e.g., preț, suprafață, facilități).</b></p>
</section>

<section id="cerinte-obligatorii">
    <h2>Cerinte Obligatorii</h2>
    <p> <b>Licenta deschisa:</b> Proiectul este creat cu limbajele PHP si JS pentru Back-end si HTML si CSS pentru Front-end. Pe langa aceste limbaje, folosim Smarty pentru template-uri,
    Google JS API pentru harti, OpenAQ pentru poluare si Nasa pentru temperatura medie anuala.
     </p>
     <p>
        <b>Neutilizarea framework-urilor:</b> Proiectul nu utilizeaza nici un fel de framework.
     </p>
     <p>
        <b>Arhitectura va fi bazata pe servicii Web. Invocarea prin suita de tehnologii Ajax:</b> Folosim apeluri fetch din JS pentru a obtine datele de la API-uri, in maniera asincrona.
     </p>
     <p>
        <b>Pentru partea de client, interfaţa aplicaţiei Web va fi marcată obligatoriu în HTML5 – codul trebuind să fie valid conform specificaţiilor Consorţiului Web:</b> Dupa testarea html-ului folosit, codul a fost marcat ca fiind valid.
     </p>
     <p>
        <b>Pentru stocarea şi managementul datelor, se vor putea utiliza servere de baze de date relaţionale:</b> Folosim o baza de date Postgres, hostata pe AWS.
     </p>
     <p>
        <b>Se vor folosi pe cât posibil machete (template-uri):</b> Aceasta pagina, la fel ca toate celelalte este un template Smarty.
     </p>
     <p>
        <b>Adoptarea principiilor designului Web responsiv:</b> Site-ul foloseste flexbox din css pentru a asigura responsivitatea.
     </p>
     <p>
        <b>Recurgerea la tehnici de prevenire a atacurilor:</b> Folosim interogari prepared pentru securitate.
     </p>
     <p>
        <b>Import/export de date folosind formate deschise:</b> Datele din baza noastra de date pot fi exportate folosind butoanele de pe pagina principala.
     </p>
     <p>
        <b>Existenţa unui modul propriu de administrare a aplicaţiei Web:</b> Avem un login special, de admin.
     </p>
     <p>
        <b></b>
     </p>


</section>

<section id="apeluri-api">
    <h2>Apeluri de API</h2>
    <p>Am ales mai multe surse de informatii pentru a furniza datele de pe harta si din overlay-uri, si anume:</p>
    <p>Google JS API: https://developers.google.com/maps/documentation/javascript/overview</p>
    <p>OpenAQ: https://openaq.org/developers/platform-overview/</p>
    <p>NASA: https://power.larc.nasa.gov/docs/services/api/application/</p>
</section>

<section id="implementari-motivatii">
    <h2>Implementari, motivatii.</h2>
    <p>Am ales aceasta tema deoarece parea ca un prilej bun de a lucra cu API-ul de la Google. Ca si implementare, am folosit modelul "MVC" studiat la seminar, deoarece ne-a ajutat sa ramanem organizati.</p>
    <p>Fiecare pagina este alcatuita dintr-un Controller, care da handle la diferitele request-uri, un Model, care ia date din baza de date sau din diferite API Call-uri, si un View care, cu ajutorul unui template Smarty, da render la pagina Web.</p>
    <p>Pentru login am folosit JWT-uri, care sunt necesare pentru accesarea restului website-ului.</p>
</section>
</div>
</body>
</html>
