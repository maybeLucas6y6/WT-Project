document.getElementById('add-to-favorites-button').addEventListener('click', addFavorite);
document.getElementById('remove-from-favorites-button').addEventListener('click', removeFavorite);

function removeFavorite() {
    const button = document.getElementById('remove-from-favorites-button');
    const assetId = button.getAttribute('data-asset-id');
    fetch(`/asset/removeFavorite/${assetId}`)
        .then(res => res.json())
        .then(data =>{
            console.log(data);

        })
}

function  addFavorite() {
    const button = document.getElementById('add-to-favorites-button');
    const assetId = button.getAttribute('data-asset-id');
    fetch(`/asset/addFavorite/${assetId}`)
        .then(res => res.json())
        .then(data =>{
            console.log(data);
            if(data.error){
                alert("Asset is already in favorites list!")
            }
        })
}
