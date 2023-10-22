var zoomGalicia = 8.25;
var lonGalicia = -8.1;
var latGalicia = 42.866929500000005;

// var zoomEspaña = 5.50;
// var lonEspaña = -3.697536;
// var latEspaña = 40.406678;

var zoomBomberos = 11;
var lonBomberos = -7.76070330;
var latBomberos = 42.71659040;

var radio_circulo = 3000000;
var size_texto = "12px";

var prefijo_apuntar_circulo = "apuntac_";
var prefijo_apuntar_texto = "apuntat_";

// SETUP ICONOS
var icono = './img/puntoazul.png';
var size = new OpenLayers.Size(15,15);
var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
var icon = new OpenLayers.Icon(icono, size, offset);

var marker;

// _________________________________________ CREA EL MAPA VACÍO CON UNA CAPA

    // PROYECCIONES GEOGRÁFICAS
    var sphericalMercatorProj = new OpenLayers.Projection('EPSG:900913');
    var geographicProj = new OpenLayers.Projection('EPSG:4326');

// FUNCIONES  _____________________________________________

function centrar(lon, lat, zoom) {
  lonLat = new OpenLayers.LonLat( lon ,lat )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // Transformation aus dem Koordinatensystem WGS 1984
            mapa.getProjectionObject() // in das Koordinatensystem 'Spherical Mercator Projection'
          );
  mapa.setCenter (lonLat, zoom);
}

function quitar_capa(capa) {
  // window.alert(mapa.getLayersByName(capa)[0].name);
  mapa.removeLayer(mapa.getLayersByName(capa)[0]);
}

function ocultar(capa) {
  mapa.getLayersByName(capa)[0].setVisibility(false);
}

function mostrar(capa) {
  mapa.getLayersByName(capa)[0].setVisibility(true);
}

function apuntar_lugar(id, lon, lat, nombre) {

  id_circulo = prefijo_apuntar_circulo+id;
  id_texto = prefijo_apuntar_texto+id;
  pintar_circulo(id_circulo, lon, lat, radio_circulo);
  pintar_texto(id_texto, nombre, lon, lat, size_texto);
}

function desapuntar_lugar(id) {

  id_circulo = prefijo_apuntar_circulo+id;
  id_texto = prefijo_apuntar_texto+id;
  // window.alert(mapa.getLayersByName('nombre_circulo')[0].name+" - "+id);
  quitar_capa(id_circulo);
  quitar_capa(id_texto);
}

function centrar_lugar(lon, lat) {
  centrar(lon, lat, 16);
}

function pintar_circulo(id, lon, lat, radio) {

  this.geometryLayer = new OpenLayers.Layer.Vector(id, 
  {
      styleMap: new OpenLayers.StyleMap(            
      {
          'strokeWidth': 5,
          'strokeColor': '#ff0000',
          'fillOpacity': 0
      })
  });

  lonlat_ = [lon, lat];

  radio_mix = radio/Math.pow(2, mapa.zoom);

  var circle = OpenLayers.Geometry.Polygon.createRegularPolygon(
  new OpenLayers.Geometry.Point(lonlat_[0], lonlat_[1]).transform(
  geographicProj,
  sphericalMercatorProj),
  radio_mix,
  30);

  // CARACTERÍSTICAS. PRIMERO SE LIMPIAN LAS QUE HUBIERA
  this.geometryLayer.removeAllFeatures();

  var circleFeatures = [];

  var circleFeature = new OpenLayers.Feature.Vector(circle);
  circleFeatures.push(circleFeature);
  this.geometryLayer.addFeatures(circleFeatures);

  // var selected_polygon_style = {
  //     strokeWidth: 5,
  //     strokeColor: '#ff0000'
  //     // add more styling key/value pairs as your need
  // };
  // selectedFeature.style = selected_polygon_style;
  // this.geometryLayer.addFeatures([selectedFeature]);

  this.mapa.addLayer(this.geometryLayer);
}

function pintar_texto(id, texto, lon, lat, size) {

  this.vectorLayer = new OpenLayers.Layer.Vector(id, 
  {
      styleMap: new OpenLayers.StyleMap(            
      {
          label : "${labelText}",                    
          fontColor: "blue",
          fontSize: size,
          fontFamily: "Courier New, monospace",
          fontWeight: "bold",
          labelAlign: "lc",
          labelXOffset: "14",
          labelYOffset: "0",
          labelOutlineColor: "white",
          labelOutlineWidth: 3
      })
  });

  var features = [];
  var pt = new OpenLayers.Geometry.Point(lon, lat).transform(
  geographicProj,
  sphericalMercatorProj);
  features.push(new OpenLayers.Feature.Vector(pt, {labelText: " "+texto}));
  this.vectorLayer.removeAllFeatures();
  this.vectorLayer.addFeatures(features);
  this.mapa.addLayer(this.vectorLayer);
}


