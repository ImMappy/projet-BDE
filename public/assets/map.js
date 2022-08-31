

const getMap = () => {

    const url = `http://localhost:8000/lieu/api/${4}`
    fetch(url).then((resp) => resp.json()).then((data) => {
        let {latitude, longitude} = data;
        let map = L.map('map').setView([latitude, longitude], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        let marker = L.marker([latitude, longitude]).addTo(map);

    })
}

getMap()