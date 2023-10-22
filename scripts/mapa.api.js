// CREAR MAPA CON CAPA OSM EN EL DIV 'MAPA'

var mapa = new OpenLayers.Map({
    div: 'mapa',
    theme: null,
    projection: geographicProj,
    displayProjection: geographicProj,
    units: 'm',
    numZoomLevels: 18,
    controls: [
        new OpenLayers.Control.Attribution(),
        new OpenLayers.Control.Navigation(),
        new OpenLayers.Control.PanZoom(),
        new OpenLayers.Control.LayerSwitcher()
    ],
    layers: [
        new OpenLayers.Layer.OSM('OpenStreetMap', null)
    ]
});

// FIN _______________________________________ CREA EL MAPA VACÍO CON UNA CAPA

// que quede centrado

centrar(0, 0, 0);

// CREA CAPAS DE MARKERS POR TIPO

function crearCapa (tipo) {
  var tipo = new OpenLayers.Layer.Markers(tipo);
  mapa.addLayer(tipo);
}

// FIN _______________________________________ CREA CAPAS DE MARKERS POR TIPO


// CREA EL OBJETO DE POSICIÓN LONLAT

function crearMarcador (lat, lon, nombre, tipo) {
  lonLat = new OpenLayers.LonLat( lon ,lat )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // Transformation aus dem Koordinatensystem WGS 1984
            mapa.getProjectionObject() // in das Koordinatensystem 'Spherical Mercator Projection'
          );

  icono = "./img/"+tipo+".png";

  icon = new OpenLayers.Icon(icono, size, offset);

  marker = new OpenLayers.Marker(lonLat, icon);

  // EVENTO MOUSEOVER QUE MUESTRE INFO DEL LUGAR
  marker.events.register('mouseover', marker, function(evt) {
      popup = new OpenLayers.Popup("chicken",
                     new OpenLayers.LonLat( lon ,lat )
            .transform(
              new OpenLayers.Projection("EPSG:4326"), // Transformation aus dem Koordinatensystem WGS 1984
              mapa.getProjectionObject() // in das Koordinatensystem 'Spherical Mercator Projection'
            ),
                     new OpenLayers.Size(100,50),
                     nombre,
                     true);

      mapa.addPopup(popup);
  });

  //here add mouseout event
  marker.events.register('mouseout', marker, function(evt) {popup.hide();});

  var capa = mapa.getLayersByName(tipo)[0];
  // var capa = mapa.getLayer('aeropuerto');
  capa.addMarker(marker);
}

// ocultar / mostrar capa

function cambiarVisibilidadCapa (tipo) {
  var capa = mapa.getLayersByName(tipo)[0];
  if (capa.getVisibility() == true) {
      capa.setVisibility(false);
  } else {
      capa.setVisibility(true);
  }
}

// FIN _______________________________________ ocultar / mostrar capa

function limpiarMapa () {

  capas = mapa.layers;
  for (var i=0; i<capas.length; i++) {
    capas[i].setVisibility(false);
  }
  capa = mapa.getLayersByName('OpenStreetMap')[0];
  capa.setVisibility(true);
}
