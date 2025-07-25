<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Real estate manager for people looking to buy and sell estates.">
    <title>Asset Details</title>
    <link rel="stylesheet" href="/views/mapView.css">
</head>

<body>
    <div class="big-wrapper">
        <h1>Asset Details</h1>
        <p><strong>Address:</strong> {$address} </p>
        <p><strong>Description:</strong> {$description}</p>
        <p><strong>Price:</strong> {$price}</p>
        <p><strong>Phone number:</strong> {$phone}</p>
        <p><strong>E-mail:</strong> {$email}</p>
        <a href="/map" class="fancy-button">Inapoi catre harta</a>
        <div class="small-wrapper">
            <button id="add-to-favorites-button" class="fancy-button" data-asset-id={$id}>Adaugati la favorite</button>
            <button id="remove-from-favorites-button" class="fancy-button" data-asset-id={$id}>Stergeti din
                favorite</button>
        </div>

        {if {$is_admin} == true || {$is_owner} == true}
            <form action="/asset/deleteAsset" method="POST"">
                <input type="hidden" name="id" value="{$id}"></input>
                <input type="submit" value="Sterge acest asset" class="fancy-button"></input>
            </form>
        {/if}
    </div>

    <script src="/views/assetView.js"></script>
</body>

</html>