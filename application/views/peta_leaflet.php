<!-- 
<div class="content"> ​

   <div id="map" style="width: 100%; height: 530px; color:black;">

   </div> ​

</div> 

 <script>

	const map = L.map('map', {
 	center: [-1.7912604466772375, 116.42311966554416],
 	zoom: 5,
 	layers:[]
}); 
	const tiles = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
		maxZoom: 5,
		subdomains:['mt0','mt1','mt2','mt3']
		// attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);
	var baseLayers = {'Google Satellite Hybrid': GoogleSatelliteHybrid};
var overlayLayers = {}
L.control.layers(baseLayers, overlayLayers, {collapsed: false}).addTo(map);

</script> -->

<div class="content">
 <div id="map" style="width: 100%; height: 560px; color:black;"></div>
</div>

<script>

// var
var prov = new L.LayerGroup();
var faskes = new L.LayerGroup();
var sungai = new L.LayerGroup();
var provin = new L.LayerGroup();
var bataswilayahbekasi = L.layerGroup();
var sungaibekasi = L.layerGroup();
var jalanbekasi = L.layerGroup();
// end var

// map
var map = L.map('map', {
    center: [-6.238270, 106.975571], // Koordinat Kota Bekasi
    zoom: 12, // Zoom lebih detail untuk area kota
    zoomControl: true, // Aktifkan kontrol zoom
    layers: []
});


var GoogleSatelliteHybrid= L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
maxZoom: 22,
attribution: 'Latihan Web GIS'
}).addTo(map);
//end map

// basemap esri
var OpenStreetMap_Mapnik = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

// googlemaps
var GoogleMaps = new
L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { opacity: 1.0,
attribution: 'Latihan Web GIS'
});
//end googlemaps

//googleroads
var GoogleRoads = new
L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}',{
opacity: 1.0,
attribution: 'Latihan Web GIS'
});
//end google road

	// control layers
var baseLayers = {'Google Satellite Hybrid': GoogleSatelliteHybrid,'OpenStreetMap_Mapnik': OpenStreetMap_Mapnik,'GoogleMaps': GoogleMaps,'GoogleRoads':GoogleRoads};
// var overlayLayers = {}
// L.control.layers(baseLayers, overlayLayers, {collapsed: true}).addTo(map);
// end control layers

var groupedOverlays = {
"Peta Dasar":{
	'Ibu Kota Provinsi' :prov,
	'Jaringan Sungai':sungai,
	'Provinsi' :provin,
	'Batas Wilayah Bekasi' :bataswilayahbekasi,
	'Sungai Bekasi' :sungaibekasi,
	'Jalan Bekasi' :jalanbekasi,
},
"Peta Khusus":{
	'Fasilitas Kesehatan' :faskes
}
};
L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map);

//mini map
var
osmUrl='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
var osmAttrib='Map data &copy; OpenStreetMap contributors';
var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib });
var rect1 = {color: "#ff1100", weight: 3};
var rect2 = {color: "#0000AA", weight: 1, opacity:0, fillOpacity:0};
var miniMap = new L.Control.MiniMap(osm2, {toggleDisplay: true, position : "bottomright",
aimingRectOptions : rect1, shadowRectOptions: rect2}).addTo(map);
//minimap

// geocoder
const geo = L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);
// endgecoder

// koordinat
/* GPS enabled geolocation control set to follow the user's location */
/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({ 
position: "topleft", 
drawCircle: true, 
follow: true, 
setView: true, 
keepCurrentZoomLevel: true, 
markerStyle: { 
weight: 1, 
opacity: 0.8, 
fillOpacity: 0.8 
}, 
circleStyle: { 
weight: 1, 
clickable: false 
}, 
icon: "fa fa-location-arrow", 
metric: false, 
strings: { 
title: "My location", 
popup: "You are within {distance} {unit} from this point", 
outsideMapBoundsMsg: "You seem located outside the boundaries of the map" 
}, 
locateOptions: { 
maxZoom: 18, 
watch: true, 
enableHighAccuracy: true, 
maximumAge: 10000, 
timeout: 10000 
} 
}).addTo(map);
// koordinat

// controlzoombar
var zoom_bar = new L.Control.ZoomBar({position: 'topleft'}).addTo(map);
// end control zoombar

// leaflet coordinates
L.control.coordinates({
position:"bottomleft",
decimals:2,
decimalSeperator:",",
labelTemplateLat:"Latitude: {y}",
labelTemplateLng:"Longitude: {x}"
}).addTo(map);
/* scala */
L.control.scale({metric: true, position: "bottomleft"}).addTo(map);
// leaflet coordinates

// mata angin
var north = L.control({position: "bottomleft"});
north.onAdd = function(map) {
var div = L.DomUtil.create("div", "info legend");
div.innerHTML = '<img src="<?=base_url()?>assets/arah-mata-angin.png"style=width:200px;>';
return div; }
north.addTo(map);
//mataangin

// geojson provinsi
$.getJSON("<?=base_url()?>assets/provinsi.geojson",function(data){
var ratIcon = L.icon({
iconUrl: '<?=base_url()?>assets/marker.png',
iconSize: [12,10]
});
L.geoJson(data,{
pointToLayer: function(feature,latlng){
var marker = L.marker(latlng,{icon: ratIcon});
marker.bindPopup(feature.properties.CITY_NAME);
return marker;
}
}).addTo(prov);
});
// enndgeojson

//geojson rsu
$.getJSON("<?=base_url()?>assets/rsu.geojson",function(data){
var ratIcon = L.icon({
iconUrl: '<?=base_url()?>assets/marker2.png',
iconSize: [12,10]
});
L.geoJson(data,{
pointToLayer: function(feature,latlng){
var marker = L.marker(latlng,{icon: ratIcon});
marker.bindPopup(feature.properties.NAMOBJ);
return marker;
}
}).addTo(faskes);
});
//end geojson

//poliklinik geojson
$.getJSON("<?=base_url()?>assets/poliklinik.geojson",function(data){
var ratIcon = L.icon({
iconUrl: '<?=base_url()?>assets/marker3.png',
iconSize: [12,10]
});
L.geoJson(data,{
pointToLayer: function(feature,latlng){
var marker = L.marker(latlng,{icon: ratIcon});
marker.bindPopup(feature.properties.NAMOBJ);
return marker;
}
}).addTo(faskes);
});
//end geojson

//geojson puskesmas
$.getJSON("<?=base_url()?>assets/puskesmas.geojson",function(data){
var ratIcon = L.icon({
iconUrl: '<?=base_url()?>assets/marker4.png',
iconSize: [12,10]
});
L.geoJson(data,{
pointToLayer: function(feature,latlng){
var marker = L.marker(latlng,{icon: ratIcon});
marker.bindPopup(feature.properties.NAMOBJ);
return marker;
}
}).addTo(faskes);
});
//end geojson

//geojson sungai
$.getJSON("<?=base_url()?>/assets/sungai.geojson",function(kode){
 L.geoJson( kode, {
 style: function(feature){
 var color,
 kode = feature.properties.kode;
 if ( kode < 2 ) color = "#f2051d";
 else if ( kode > 0 ) color = "#f2051d";
 else color = "#f2051d"; // no data
 return { color: "#999", weight: 5, color: color, fillOpacity: .8 };
 },
 onEachFeature: function( feature, layer ){
 layer.bindPopup
 ()
 } }).addTo(sungai);
});
//end geojson

//Kota Bekasi
// GeoJSON Batas Wilayah Bekasi
$.getJSON("<?=base_url()?>assets/bataswilayahbekasi.geojson", function (data) {
    var buildingIcon = L.icon({
        iconUrl: '<?=base_url()?>assets/marker5.png',
        iconSize: [12, 10]
    });
    L.geoJson(data, {
        pointToLayer: function (feature, latlng) {
            var marker = L.marker(latlng, { icon: buildingIcon });
            marker.bindPopup("Batas Wilayah Bekasi: " + feature.properties.NAME);
            return marker;
        }
    }).addTo(bataswilayahbekasi);
});
// End GeoJSON Batas Wilayah Bekasi

// GeoJSON Sungai
$.getJSON("<?=base_url()?>assets/sungaibekasi.geojson", function (data) {
    L.geoJson(data, {
        style: function (feature) {
            var color = "#3498db"; // Warna biru untuk sungai
            return { color: color, weight: 3, opacity: 0.8 };
        },
        onEachFeature: function (feature, layer) {
            layer.bindPopup("Sungai Bekasi: " + feature.properties.NAME);
        }
    }).addTo(sungaibekasi);
});
// End GeoJSON Sungai

// GeoJSON Jalan
$.getJSON("<?=base_url()?>assets/jalanbekasi.geojson", function (data) {
    L.geoJson(data, {
        style: function (feature) {
            var color = "#e67e22"; // Warna oranye untuk jalan
            return { color: color, weight: 2, opacity: 0.8 };
        },
        onEachFeature: function (feature, layer) {
            layer.bindPopup("Jalan Bekasi: " + feature.properties.NAME);
        }
    }).addTo(jalanbekasi);
});
// End GeoJSON Jalan

// Menampilkan batas wilayah Bekasi menggunakan GeoJSON
$.getJSON("assets/bataswilayahbekasi.geojson", function (kode) {
  L.geoJSON(kode, {
    style: function (feature) {
      return {
        color: "pink",         // Warna garis batas
        weight: 5,             // Ketebalan garis
        fillOpacity: 0.1       // Transparansi area dalam batas
      };
    },
    onEachFeature: function (feature, layer) {
      layer.bindPopup("<b>Batas Wilayah Bekasi</b><br>Informasi lebih lanjut bisa ditambahkan di sini.");
    }
  }).addTo(bataswilayahbekasi); // Menambahkan layer ke peta
});

var markersDataCoffeeShop = [
  {
    coords: [-6.308373972311017, 107.02664317086617],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>La'Romanza coffe and tea</b><br>Jl. Dukuh Zamrud Blok U 16 no 110 Kota Legenda, Kota Bks, Jawa Barat 17414<b><br>Jam Operasional</b><br>4.00pm - 12.00am<br><b>Price</b><br>Rp 1-25K per person"
  },
  {
    coords: [-6.32064772130679, 107.01875135336009],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Kopi Insight</b><br>Jl. Bantar Gebang Setu, RT.003/RW.017, Cimuning, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17155<b><br>Jam Operasional</b><br>10.00am - 12.00am<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.323157658776667, 106.98626272452384],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Little Talk Coffe</b><br>Insitu, Bumiwedari, Vida Bekasi, RT.001/RW.008, Bantargebang, Kec. Bantar Gebang, Kota Bks, Jawa Barat 17151<b><br>Jam Operasional</b><br>7.00am - 10.00pm<br><b>Price</b><br>Rp 50-100K per person"
  },
  {
    coords: [-6.322571162247195, 106.98584429991016],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Kopitagram</b><br>Area Danau Insitu, Kawasan Bumiwedari, Vida, Kota Bks, Jawa Barat 17157<b><br>Jam Operasional</b><br>8.00am - 11.00pm<br><b>Price</b><br>Rp 50-100K per person"
  },
  {
    coords: [-6.308158007790981, 107.0280397821962],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Kopilagi</b><br>Jl. Zamrud Utara No.136 Blok U 16, RT.002/RW.006, Cimuning, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17511<b><br>Jam Operasional</b><br>1.30pm - 12.00am<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.3087052693807, 107.02846956499752],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>VF. Coffe</b><br>Jl. Mustika Jaya, RT.002/RW.006, Cimuning, Kec. Mustika Jaya, Kota Bks, Jawa Barat<b><br>Jam Operasional</b><br>4.00pm - 11.30pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.3060286323714525, 107.02953171978609],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Selasar Timur</b><br>Jl Cendrawasih No.1, Cimuning, Kec. Bekasi Tim., Kota Bks, Jawa Barat 17155<b><br>Jam Operasional</b><br>9.00am - 11.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.315873355630853, 107.00132436870506],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Toko Kopi Tuku</b><br>RT.002/RW.001, Padurenan, Mustika Jaya, Bekasi, West Java 16340<b><br>Jam Operasional</b><br>8.00am - 8.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.315843433768412, 107.00182080826505],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Shorea Coffe</b><br>Jl. Alun Alun Utara, Padurenan, Kec. Mustika Jaya, Kota Bks, Jawa Barat 16340<b><br>Jam Operasional</b><br>9.00am - 10.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.305807459702921, 107.02957001365884],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Coffee Shop AYA Coffee</b><br>Jl. Cendra Wasih, RT.003/RW.007, Cimuning, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17155<b><br>Jam Operasional</b><br>9.00am - 11.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.319602975423291, 107.01733376499757],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Tommoro Coffe</b><br>Ruko Dukuh Zamrud, Jl. Zamrud Utara Blok B1, RT.001/RW.017, Padurenan, Mustika Jaya, Bekasi, West Java<b><br>Jam Operasional</b><br>7.00am - 10.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.317440611030996, 107.01917742267011],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Janji Jiwa & Jiwa Toast</b><br>Jl. Zamrud Selatan No.41, RT.001/RW.017, Padurenan, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17156<b><br>Jam Operasional</b><br>10.00am-10.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.298013955693932, 107.0273420803424],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Tokyo Space</b><br>Jl. Bayan 1 No.122, RT.005/RW.011, Mustika Jaya, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17158<b><br>Jam Operasional</b><br>4.00pm - 12.00am<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.2934712042555265, 107.03093242266986],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Suatu Waktu Coffe</b><br>Jl. Mustika Jaya, Lambangsari, Kec. Mustika Jaya, Kabupaten Bekasi, Jawa Barat<b><br>Jam Operasional</b><br>3.00pm - 11.30pm<br><b>Price</b><br>Rp 25-50K per person"
  },
  {
    coords: [-6.302089277681195, 107.03912032266994],
    popupText: "</b> <img src=assets/ style=width:100%; margin-top:10px; border-radius:5px;><b>Kopi Dari Hati</b><br>Jl. Gondang No.16, RT.001/RW.010, Mustika Jaya, Kec. Mustika Jaya, Kota Bks, Jawa Barat 17158<b><br>Jam Operasional</b><br>10.00am - 10.00pm<br><b>Price</b><br>Rp 25-50K per person"
  },
];

markersDataCoffeeShop.forEach(function(marker) {
  var newMarker = L.marker(marker.coords).addTo(bataswilayahbekasi);
  newMarker.bindPopup(marker.popupText).openPopup();
});

//geojson provinsi polygon
$.getJSON("<?=base_url()?>/assets/provinsi_polygon.geojson",function(kode){
 L.geoJson( kode, {
 style: function(feature){
 var fillColor,
 kode = feature.properties.kode;
 if ( kode > 21 ) fillColor = "#006837";
 else if (kode>20) fillColor="#fec44f"
 else if (kode>19) fillColor="#c2e699"
 else if (kode>18) fillColor="#fee0d2"
 else if (kode>17) fillColor="#756bb1"
 else if (kode>16) fillColor="#8c510a"
 else if (kode>15) fillColor="#01665e"
 else if (kode>14) fillColor="#e41a1c"
 else if (kode>13) fillColor="#636363"
 else if (kode>12) fillColor= "#762a83"
 else if (kode>11) fillColor="#1b7837"
 else if (kode>10) fillColor="#d53e4f"
 else if (kode>9) fillColor="#67001f"
 else if (kode>8) fillColor="#c994c7"
 else if (kode>7) fillColor="#fdbb84"
 else if (kode>6) fillColor="#dd1c77"
 else if (kode>5) fillColor="#3182bd"
 else if ( kode > 4 ) fillColor ="#f03b20"
 else if ( kode > 3 ) fillColor = "#31a354";
 else if ( kode > 2 ) fillColor = "#78c679";
 else if ( kode > 1 ) fillColor = "#c2e699";
 else if ( kode > 0 ) fillColor = "#ffffcc";
 else fillColor = "#f7f7f7"; // no data
 return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
 },
 onEachFeature: function( feature, layer ){
 layer.bindPopup(feature.properties.PROV)
 }
 }).addTo(provin);
 });
 //end geosjon
 
</script>