<br>
<div id="carte"></div>
<script> 

  // Carte Leaflet 
  var map = L.map('carte', {
      minZoom: 3,
      maxZoom: 8
  }).setView([40.0, -45.0], 3.5);
  map.addControl(new L.Control.Fullscreen());

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

  var OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
    noWrap: true,
    maxZoom: 17,
    attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
  });

  // Mise en place de panneaux pour régler l'ordre des couches
  map.createPane("pane_autoch").style.zIndex = 250;
  map.createPane("pane_afr").style.zIndex = 253;

  // Ajout d'une échelle
  var echelle = L.control.scale().addTo(map);

  // Button to return to initial view
  L.control.resetView({
    position: "topleft",
    title: '<?= lang('Map.reset_view')?>',
    latlng: L.latLng([40.0, -45.0]),
    zoom: 3.5,
  }).addTo(map);
  
  // Création des geojson
  <?php 
    if (!empty($nar_place) && is_array($nar_place)) {
      $nbt = count($nar_place);
      $reponse = 'var place = {"type": "FeatureCollection", "features": [';
      $type = 'var type = '."'".$nar_place[0]['type_point']."';";
      for ($i = 0; $i < $nbt; $i++) {
        $narrative_title = str_replace('"','\"', str_replace("'","\'", $nar_place[$i]['title_beginning']));
        if (strlen($narrative_title) > 100)
          $suffix = '...';
        else
          $suffix = '';
        $reponse .= '{"geometry": {"type": "Point", "coordinates": ['.$nar_place[$i]['longitude'].','.$nar_place[$i]['latitude'].']},"id": '.$nar_place[$i]['id_point'].', "type": "Feature", "properties": {
        "type": "'.$nar_place[$i]['type_point'].'","slave_name": "'.$nar_place[$i]['name'].'",
        "ville": "'.$nar_place[$i]['place'].'","id_narrative": "'.$nar_place[$i]['id_narrative'].'",
        "publication_date": "'.$nar_place[$i]['publication_date'].'",
        "titre": "'.$narrative_title.'", "id_point": "'.$nar_place[$i]['id_point'].'"}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
      echo $type;
    }

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

    if (! empty($indigenous_areas) && is_array($indigenous_areas)) {
      $nbt = count($indigenous_areas);
      $reponse = 'var aires_aut = {"type": "FeatureCollection", "features": [';
      for ($i = 0; $i < $nbt; $i++) {
        $reponse .= '{"geometry": '.$indigenous_areas[$i]['geoj'].',"id": '.$indigenous_areas[$i]['id'].', "type": "Feature", "properties": {"id_style": "'.$indigenous_areas[$i]['id_style'].'"}},'."\r\n";
      }
      $reponse = substr($reponse,0,strlen($reponse)-1);
      $reponse .= ']};';
      echo $reponse;
    }
  ?>

  var style_c = style_clust("<?= $place ?>");
  var cluster = new L.MarkerClusterGroup({
    iconCreateFunction: function(cluster) {
      return L.divIcon({ 
        html: "<div class=" + style_c +">" + cluster.getChildCount()+"</div>",
        className: "", 
        iconSize: null 
      });
    }
  });

  cluster.addLayer(L.geoJSON(place,{
    pointToLayer: function (feature, latlng) {
      var slave_name =feature.properties.slave_name;
      var style_test = style_pt(feature);
      return L.circleMarker(latlng, style_test)
    }, onEachFeature: function (feature, layer) {
      var url = '<?=site_url()."narrative/"?>' + feature.properties.id_narrative ;
      var id_narrative =feature.properties.id_narrative;
      layer.bindPopup(
        '<a href="' + url +'">' + "<h3 id='h3popup'>"+feature.properties.slave_name+"</h3>" + "</a><br>"+
        "<p class='text_popup'> <?= lang('Map.popup_date')?> : "+ feature.properties.publication_date + "</p>" +
        "<p class='text_popup'> <?= lang('Map.popup_title')?> : <i>" + feature.properties.titre + "</i></p>" +
        "<form id='formulaire' method='get'>"+
        " <button id='bouton' type='submit' name ='narrative' value="+ id_narrative +"> <p id='pop_carte'> <?= lang('Map.see_map_of_this_narrative')?> </p>" +
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
        this.bindTooltip(feature.properties.ville + "<br>"+feature.properties.slave_name ,
          {permanent: false, direction: 'right',opacity: 0.65}
        );
      });      
    }}));
  map.addLayer(cluster);

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
    pane:"pane_autoch"    
  }).addTo(map);

  // Fonds de carte
  var baseMaps = {
    "OpenTopoMap": OpenTopoMap,
    "ESRI World Physical": Esri_WorldPhysical,
    "ESRI Shaded Relief": Esri_WorldShadedRelief,
    "ESRI Terrain Base": ESRI_Terrain_Base
  };

  var overlayMaps = {
    "Aires amérindiennes": aires_aut,
    "Royaumes Africains": african_kingdoms,
    "Points": cluster
  };

   
  // Ajout d'une fonctionnalité permettant le choix du fond de carte et des couches
  var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);

</script>
<br><br><br><br>
