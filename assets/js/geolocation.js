//Geolocation
let lc = L.control.locate({
    strings: {
        title: "Géolocalisation"
    },
    locateOptions: {
        maxZoom: 12
    }
}).addTo(map);