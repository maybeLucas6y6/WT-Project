let map;
let pollutionCircles = [];

function initMap() { //logica efectiva pt harta (trebuie musai js)
    const geocoder = new google.maps.Geocoder();
    const address = "Iasi, Romania";

    //eu ii dau o adresa normala, pe care apoi o geocodez in lat si lng ca sa pot sa o dau la google
    geocoder.geocode({ address: address }, function (results, status) {
        if (status === 'OK') {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: results[0].geometry.location
            });

            new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
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
}
// fac un apel AJAX la index.php, care apoi merge la model, and so on, pana cand am la final toate cercurile randate
function fetchPollutionData() {
    const center = map.getCenter();
    const lat = center.lat();
    const lng = center.lng();

    console.log("Fetching pollution data for:", lat, lng);

    fetch(`index.php?action=pollution&lat=${lat}&lng=${lng}&radius=10000&limit=50`)
        .then(res => res.json())
        .then(data => {
            const results = data.results;

            results.forEach(entry => {
                const sensor = entry.sensors?.[2];
                if (!sensor) return;

                const sensorId = sensor.id;

                fetch(`index.php?action=sensor&id=${sensorId}`)
                    .then(res => res.json())
                    .then(measurementData => {
                        const value = measurementData.results[0].value;
                        if (value === undefined) return;

                        const color = getPollutionColor(value);

                        const circle = new google.maps.Circle({
                            strokeColor: color,
                            strokeOpacity: 0.8,
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

function getPollutionColor(value) {
    if (value <= 12) return '#00e400';        
    else if (value <= 35.4) return '#ffff00'; 
    else if (value <= 55.4) return '#ff7e00'; 
    else if (value <= 150.4) return '#ff0000'; 
    else if (value <= 250.4) return '#8f3f97';
    else return '#7e0023';                    
}


window.initMap = initMap;