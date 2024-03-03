<br>
<div id="carte"></div>

<script>

  // Carte Leaflet 
  var map = L.map('carte', {
      minZoom: 3,
      maxZoom: 8
  }).setView([29.0, -45.6], 3);
  map.addControl(new L.Control.Fullscreen());

  // Mise en place de panneaux pour régler l'ordre des couches
  map.createPane("pane_pays").style.zIndex = 252;
  map.createPane("pane_autoch").style.zIndex = 250;
  map.createPane("pane_usa").style.zIndex = 251;
  map.createPane("pane_afr").style.zIndex = 253;
  map.createPane("pane450").style.zIndex = 450;
  map.createPane("pane550").style.zIndex = 550;

  // Fond ESRI relief
  var Esri_WorldShadedRelief = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}', {
    noWrap: true,
    attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
    maxZoom: 13
  });

  // Fond World Terrain Base
  var ESRI_Terrain_Base = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Terrain_Base/MapServer/tile/{z}/{y}/{x}', {
    noWrap: true,
    attribution: 'Tiles &copy; Esri &mdash; Source: USGS, Esri, TANA, DeLorme, and NPS',
    maxZoom: 13
  });

  // Fond ESRI World Physical
  var Esri_WorldPhysical = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Physical_Map/MapServer/tile/{z}/{y}/{x}', {
    noWrap: true,
    attribution: 'Tiles &copy; Esri &mdash; Source: US National Park Service',
    maxZoom: 8
  }).addTo(map);

  // Ajout d'une échelle
  var echelle = L.control.scale().addTo(map);

  // Button to return to initial view
  L.control.resetView({
    position: "topleft",
    title: '<?= lang('Map.reset_view')?>',
    latlng: L.latLng([29.0, -45.6]),
    zoom: 3,
  }).addTo(map);

  // Création des différentes couches GeoJSON 
  <?php 

    //Frontières etatsuniennes
    if (! empty($us_border) && is_array($us_border)) {
      $nbt = count($us_border);
      $reponse = 'var maps = {"type": "FeatureCollection", "features": [';
      for ($i = 0; $i < $nbt; $i++) {
        $reponse .= '{"geometry": '.$us_border[$i]['geoj'].', "type": "Feature", "properties": {"label": "'.$us_border[$i]['label'].'","category": "'.$us_border[$i]['category'].'"}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
    }

    //Royaumes africains
    if (! empty($african_kingdoms) && is_array($african_kingdoms)) {
      $nbt = count($african_kingdoms);
      $reponse = 'var african_kingdoms = {"type": "FeatureCollection", "features": [';
      for ($i = 0; $i < $nbt; $i++) {
        $reponse .= '{"geometry": '.$african_kingdoms[$i]['geoj'].',"id": '.$african_kingdoms[$i]['id'].', "type": "Feature", "properties": {"Nom": "'.$african_kingdoms[$i]['name'].'"}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
    } 

    // Aires autochtones amérindiennes
    if (! empty($indigenous_areas) && is_array($indigenous_areas)) {
      $nbt = count($indigenous_areas);
      $reponse = 'var aires_aut = {"type": "FeatureCollection", "features": [';
      for ($i = 0; $i < $nbt; $i++) {
        $reponse .= '{"geometry": '.$indigenous_areas[$i]['geoj'].',"id": '.$indigenous_areas[$i]['id'].', "type": "Feature", "properties": {"id_style": "'.$indigenous_areas[$i]['id_style'].'",}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
    }

    // Les ponctuels (naissance, esclavage, décès, lieu de vie, de publication)
    if (! empty($points) && is_array($points)) {
      $nbt = count($points);
      $reponse = 'var point = {"type": "FeatureCollection", "features": [';
      for ($i = 0; $i < $nbt; $i++) {
        $narrative_title = str_replace('"','\"', str_replace("'","\'", $points[$i]['title_beginning']));
        if (strlen($narrative_title) > 100)
          $suffix = '...';
        else
          $suffix = '';
        $reponse .= '{"geometry": {"type": "Point", "coordinates": ['.$points[$i]['longitude'].','.$points[$i]['latitude'].']},"id": '.$points[$i]['id_point'].', "type": "Feature", "properties": {"type": "'.$points[$i]['type_point'].'"
        ,"id_narrative":"'.$points[$i]['id_narrative'].'","ville": "'.$points[$i]['place'].'"
        ,"slave_name": "'.$points[$i]['name'].'","resume": "'.$points[$i]['link'].'", "id_point": "'.$points[$i]['id_point'].'",'.
        '"localized_type": "'.strtolower(lang('Narrative.'.$points[$i]['type_point'])).'", "titre": "'.$narrative_title.'"}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
    }     

    // Les polygones correspondant aux pays et états         
    if (!empty($custom_locations) && is_array($custom_locations)) {
      $nbt = count($custom_locations);
      $reponse = 'var poly = {"type": "FeatureCollection", "features": [';
      $type = 'var type_pays =[';
      for ($i = 0; $i < $nbt; $i++) {
        $reponse .= '{"geometry": '.$custom_locations[$i]['geoj'].',"id": '.$custom_locations[$i]['id_cl'].', "type": "Feature", "properties": {"type": "'.$custom_locations[$i]['type_cl'].'"
        ,"id_narrative":"'.$custom_locations[$i]['id_nar'].'",
        "name":"'.$custom_locations[$i]['name'].'"
        }},'."\r\n";
        $type .="'".$custom_locations[$i]['type_cl']."',";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      $type.= '];';
      echo $reponse;
      echo $type;
    }

  ?>

  fillop = 0.7; weight = 0.2; 
  naissance = "#1CB1C4";
  death = "#6E2168";
  lieuvie = "#20A238";
  esclavage = "#2E4C9B";
  publication = "#ED6D1D";

  // Dessin des polygones (pays et états)
  if (typeof poly !== 'undefined') {
      var pays = L.geoJSON(poly, {
          style: function (feature) {
              switch (feature.properties.type) {
                  case 'naissance':
                      return {
                          fillColor: naissance, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'publication':
                      return {
                          fillColor: publication, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'deces':
                      return {
                          fillColor: death, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'lieuvie':
                      return {
                          fillColor: lieuvie, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'lieuvie_deces':
                      return {
                          fillColor: lieuvie, color: death, weight: 2.5,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'esclavage':
                      return {
                          fillColor: esclavage, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'naissance_esclavage':
                      return {
                          fillColor: esclavage, color: naissance, weight: 2.5,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'esclavage_lieuvie':
                      return {
                          fillColor: esclavage, color: lieuvie, weight: 2.5,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'esclavage_lieuvie_deces':
                      return {
                          fillColor: esclavage, color: lieuvie, weight: 2.5,
                          opacity: 1, fillOpacity: fillop
                      };
                  case 'naissance_esclavage_lieuvie_deces':
                      return {
                          fillColor: esclavage, color: "#000", weight: weight,
                          opacity: 1, fillOpacity: fillop
                      };
              }
          }, pane: "pane_pays",
          onEachFeature: function (feature, layer) {
              layer.bindPopup("<p>" + feature.properties.name + "</p>");
          }
      }).addTo(map);
  }

  // Création des clusters
  var markers = new L.MarkerClusterGroup({
    iconCreateFunction: function(cluster) {
      return L.divIcon({ 
        html: cluster.getChildCount(), 
        className: 'mycluster', 
        iconSize: null 
      });
    }
  });

  //ajout des points au cluster
	var fp = point;
  markers.addLayer(L.geoJSON(fp,{
    pointToLayer: function (feature, latlng) {
      var style_feat = style_pt(feature); 
      var ville = feature.properties.ville;

      return L.circleMarker(latlng, style_feat)
    },

    onEachFeature: function (feature, layer) {
      var url = '<?=site_url()."narrative/"?>' + feature.properties.id_narrative ;
      layer.bindPopup(
        '<a href="' + url +'">' + "<h3 id='h3popup'>"+feature.properties.slave_name+"</h3></a>"+
        "<p class='text_popup'> <?= lang('Map.popup_city')?> : "+feature.properties.ville+"</p>"+
        "<p class='text_popup'> <?= lang('Map.popup_title')?> : <i>" + feature.properties.titre + "</i></p>" +
        "<form id='formulaire' method='get'>"+
        " <button id='bouton' type='submit' name ='place' value="+ feature.properties.type +"> <p id='pop_carte'> <?= lang('Map.popup_see_similar_places')?> <br>"+ feature.properties.localized_type +"</p>" +
        "</button></form>"+
        <?php
          if (isset($_SESSION['idAdmin'])) { ?>
            '<a href="' + "<?= site_url() . "point/delete/" ?>" + feature.properties.id_point +'" class="delete-point">' + "<?= lang('Map.popup_delete_point')?></a><br>"
        <?php } else { ?>
            '<br>'
        <?php } ?>
      ),

      layer.bindTooltip(feature.properties.ville,
        {permanent: true, direction: 'auto',opacity: 0.65}
      ).openTooltip(),

      layer.on('mouseover', function () {
        this.bindTooltip(feature.properties.ville,
          {permanent: false, direction: 'right',opacity: 0.65}
        );
      });
          
    }
  }));
    
  map.addLayer(markers);
  var extens = markers.getBounds();

///////////// FRONTIERES USA //////////////////
  var maps = L.geoJSON(maps,{
    style:{
      color:"black",
      fillColor:"lightgrey",
      fillOpacity:0.1,
      weight:0.4
    },
    pane: "pane_usa",
    onEachFeature: function (feature, layer) {
      layer.bindPopup("<p>"+feature.properties.label+"</p>");
    }
  }).addTo(map);

////////// ROYAUMES AFRICAINS //////////////
  var african_kingdoms = L.geoJSON(african_kingdoms,{
    function(feature){
      var style_afr = style_afr(feature)
    },
    style: style_afr,
    onEachFeature: function (feature, layer) {
      layer.bindPopup("<p>"+feature.properties.Nom+"</p>");
    },
    pane:"pane_afr"
  
  }).addTo(map);
    
      
////////////////// AIRES AMERINDIENNES //////////////////
  var aires_aut = L.geoJSON(aires_aut,{
    function(feature){
      var style_autoch = style_autoch(feature)
    },
    style: style_autoch,
    pane:"pane_autoch",

  }).addTo(map);

  // Fonds de carte
  var baseMaps = {
    "ESRI World Physical": Esri_WorldPhysical,
    "ESRI Shaded Relief": Esri_WorldShadedRelief,
    "ESRI Terrain Base": ESRI_Terrain_Base
  };

  var overlayMaps = {
    "Aires autochtones amérindiennes": aires_aut,
    "Royaumes Africains": african_kingdoms,
    "Frontières étatsuniennes": maps
  };

  // Ajout d'une fonctionnalité permettant le choix du fond de carte et des couches
  var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);

</script>
<br><br><br><br>
