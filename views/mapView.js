let map;
let pollutionCircles = [];
let markers = []
let geocoder;
let heatmap = null;
let temperatureCircles = [];
function initMap() { //logica efectiva pt harta (trebuie musai js)
    const address = "Iasi, Romania";
    geocoder = new google.maps.Geocoder();
    //eu ii dau o adresa normala, pe care apoi o geocodez in lat si lng ca sa pot sa o dau la google
    geocoder.geocode({ address: address }, function (results, status) {
        if (status === 'OK') {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: results[0].geometry.location,
                mapTypeId: 'satellite'
            });

            fetchAssets();
        } else {
            alert('Geocode failed: ' + status);
        }
    });


    //Astept sa vad daca trebuie randat overlay ul de poluare
    document.getElementById("pollution-toggle").addEventListener("change", function () {
        if (this.checked) {
            fetchPollutionData();
        } else {
            clearPollutionLayer();
        }
    });

    document.getElementById("heatmap-toggle").addEventListener("change", function () {
        if (this.checked) {
            fetchTempData();
        } else {
            clearTempLayer();
        }
    });
    
    document.getElementById("favorite-toggle").addEventListener("change", function () {
        if (this.checked) {
            clearMarkers();
            fetchFavoriteAssets();
        } else {
            clearMarkers();
            fetchAssets();
        }
    });
    document.getElementById("add-asset-form").addEventListener("submit", handleAssetFormSubmit);
    document.getElementById("filter-form").addEventListener("submit", handleFilterFormSubmit);
    document.getElementById("nearby-form").addEventListener("submit", handleNearbyFormSubmit);
    document.getElementById("JSON-button").addEventListener("click", handleJSONButtonClick);
    document.getElementById("CSV-button").addEventListener("click", handleCSVButtonClick);
}

function handleCSVButtonClick(){
    window.location.href = '/map/getCSV';
}

function handleJSONButtonClick(){
    window.location.href = '/map/getJSON';
}

function handleNearbyFormSubmit(e) {
    e.preventDefault();
    const address = document.getElementById("nearby-address").value;

    if(!address){
        alert("Va rog sa completati campul.")
    }
    else{
        geocoder.geocode({address: address}, function(results, status) {
            if(status === 'OK'){
            fetch(`/map/fetchNearbyAssets/${results[0].geometry.location.lat()}/${results[0].geometry.location.lng()}`)
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    clearMarkers();
                    data.forEach(asset => {
                        const lat = parseFloat(asset.lat);
                        const lng = parseFloat(asset.long);
                        const id = parseInt(asset.id);
                        const marker = new google.maps.Marker({
                            map: map,
                            position: {lat: lat, lng: lng},
                            title: `${asset.address}\n${asset.description}`
                        });

                        marker.addListener("click", function () {
                            window.location.href = `/asset/viewAsset/${id}`;
                        });

                        markers.push(marker);
                    });
                })
            }
            else{
                alert("Va rog introduceti o adresa valida");
            }
        })
    }
}

function fetchFavoriteAssets(){

    fetch(`map/fetchFavoriteAssets`)
        .then(res => res.json())
        .then(data => {
            console.log(data);
            data.forEach(asset => {
                const lat = parseFloat(asset.lat);
                const lng = parseFloat(asset.long);
                const id = parseInt(asset.id);
                const marker = new google.maps.Marker({
                    map: map,
                    position: {lat: lat, lng: lng},
                    title: `${asset.address}\n${asset.description}`
                });

                marker.addListener("click", function () {
                    window.location.href = `/asset/viewAsset/${id}`;
                });

                markers.push(marker);
            })
        })
}

function handleFilterFormSubmit(e){
    e.preventDefault();
    const minValue = document.getElementById("min-price").value || -1;
    const maxValue = document.getElementById("max-price").value ||  Number.MAX_VALUE;

    fetch(`map/filterAssets/${minValue}/${maxValue}`)
        .then(res=>res.json())
        .then(data => {
            clearMarkers();
            data.forEach(asset => {
                const lat = parseFloat(asset.lat);
                const lng = parseFloat(asset.long);
                const id = parseInt(asset.id);
                const marker = new google.maps.Marker({
                    map: map,
                    position: {lat: lat, lng: lng},
                    title: `${asset.address}\n${asset.description}`
                });

                marker.addListener("click", function () {
                    window.location.href = `/asset/viewAsset/${id}`;
                });

                markers.push(marker);
            })
        });
}

function clearMarkers(){
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

function handleAssetFormSubmit(e){
        e.preventDefault();
        const address = document.getElementById("address").value;
        const description = document.getElementById("description").value;
        const price = document.getElementById("price").value;
        const category = document.getElementById("category").value;
        //Trebuie pus ceva in fiecare camp, ca sa nu bubuie baza de date.
        if(!address || !description || !price){
            alert("Completati toate campurile.");
        }
        else{
            //Trebuie sa fie valida adresa.
            geocoder.geocode({address: address}, function(results, status) {
                if(status === 'OK' ) {
                    //e valida adresa, o bagam si ii facem marker.
                    fetch(`map/addAsset/${description}/${address}/${price}/${results[0].geometry.location.lat()}/${results[0].geometry.location.lng()}/${category}`)
                        .then(res => res.json())
                        .then(asset => {
                            console.log(asset.id);
                            const marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: address.concat('\n').concat(document.getElementById("description").value)
                            });
                            marker.addListener("click", function () {
                                window.location.href = `/asset/viewAsset/${asset.id}`;
                            });
                            markers.push(marker);
                        });
                    
                }
                else {
                    alert("Adresa invalida! Incercati din nou cu o adresa de pe Google Maps.");
                }
            })
        }
    }



function fetchTempData(){
    console.log("Fetching temp data...");
    const center = map.getCenter();
    const lat = center.lat();
    const lng = center.lng();

    fetch(`map/temperature/${lat}/${lng}`)
        .then(res => res.json())
        .then(data => {
            console.log("Data received: ", data);
            const avgTemp = data.properties.parameter.T2M.ANN;

            if(!avgTemp) {
                console.warn("no temperature found.");
                return;
            }   

            const color = getTemperatureColor(avgTemp);

            const circle = new google.maps.Circle({
                strokeColor: color,
                strokeOpacity: 0.5,
                strokeWeight: 1,
                fillColor: color,
                fillOpacity: 0.35,                            
                map: map,
                center: {
                    lat: lat,
                    lng: lng
                },
                radius: 10000,
                title: avgTemp
            });


            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <strong>Temperatura medie anuala:</strong> ${avgTemp}<br/>
                    </div>
                `
            });

            const position = {
                lat: lat,
                lng: lng
            }

            circle.addListener("mouseover", function () {
                infoWindow.setPosition(position);
                infoWindow.open(map);
            });

            circle.addListener("mouseout", function () {
                infoWindow.close();
            });

            temperatureCircles.push(circle);
        })
}

function clearTempLayer(){
    console.log("Removing temperature layer...");
    temperatureCircles.forEach(circle => circle.setMap(null));
    temperatureCircles = [];
}

function fetchAssets(){
    console.log("Fetching assets...");

    fetch("map/asset")
        .then(res => res.json())
        .then(data => {
            console.log("data received:", data);
            data.forEach(asset => {
                const lat = parseFloat(asset.lat);
                const lng = parseFloat(asset.long);
                const id = parseInt(asset.id);
                    const marker = new google.maps.Marker({
                        map: map,
                        position:  {lat: lat, lng: lng},
                        title: asset.address.concat('\n').concat(asset.description) 
                    });
                    marker.addListener("click", function () {
                        window.location.href = `/asset/viewAsset/${id}`;
                    });
                    markers.push(marker);


            });
        });
}
// fac un apel AJAX la index.php, care apoi merge la model, and so on, pana cand am la final toate cercurile randate
function fetchPollutionData() {
    const center = map.getCenter();
    const lat = center.lat();
    const lng = center.lng();

    console.log("Fetching pollution data for:", lat, lng);

    fetch(`map/pollution/${lat}/${lng}/10000/50`)
        .then(res => res.json())
        .then(data => {
            const results = data.results;

            results.forEach(entry => {
                const sensor = entry.sensors?.[2];
                if (!sensor) return;

                const sensorId = sensor.id;

                fetch(`map/sensor/${sensorId}`)
                    .then(res => res.json())
                    .then(measurementData => {
                        const value = measurementData.results[0].value;
                        if (value === undefined) return;

                        const color = getPollutionColor(value);


                        const circle = new google.maps.Circle({
                            strokeColor: color,
                            strokeOpacity: 0.5,
                            strokeWeight: 1,
                            fillColor: color,
                            fillOpacity: 0.35,
                            map: map,
                            center: {
                                lat: entry.coordinates.latitude,
                                lng: entry.coordinates.longitude
                            },
                            radius: 1800
                        });

                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                <div>
                                    <strong>Rata de poluare:</strong> ${value}<br/>
                                </div>
                            `
                        });

                        const position = {
                                lat: entry.coordinates.latitude,
                                lng: entry.coordinates.longitude
                            }

                        circle.addListener("mouseover", function () {
                            infoWindow.setPosition(position);
                            infoWindow.open(map);
                        });

                        circle.addListener("mouseout", function () {
                            infoWindow.close();
                        });

                        pollutionCircles.push(circle);
                    })
                    .catch(err => console.error("Sensor fetch error:", err));
            });
        })
        .catch(err => console.error("Pollution data fetch error:", err));
}
//Sterg cercurile
function clearPollutionLayer() {
    pollutionCircles.forEach(circle => circle.setMap(null));
    pollutionCircles = [];
    console.log("Pollution data removed.");
}

function getTemperatureColor(value) {
    if (value >= 22) return '#bf2c15';
    else if (value >= 16) return '#bf7315';
    else if (value >= 7) return '#d1cb52';
    else return '#529ed1';
}

function getPollutionColor(value) {
    if (value <= 12) return '#00e400';        
    else if (value <= 35) return '#ffff00'; 
    else if (value <= 55) return '#ff7e00'; 
    else if (value <= 150) return '#ff0000'; 
    else if (value <= 250) return '#8f3f97';
    else return '#7e0023';                    
}


window.initMap = initMap;