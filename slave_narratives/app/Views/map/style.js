// après vérification cette fonction n'est pas utilisée
// à voir si on peut la supprimer
function style_pays(p) {
    fillop = 0.8; weight = 0.5;
    naissance = "#1CB1C4";
    deces = "#6E2168";
    lieuvie = "#20A238";
    esclavage = "#2E4C9B";
    publication = "#ED6D1D";
    //  var p = feature.properties.type;
    switch (p) {
      case 'naissance': return {
        fillColor: naissance,
        color: "#000",
        weight: weight,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'publication': return {
        fillColor: publication,
        color: "#000",
        weight: weight,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'deces': return {
        fillColor: deces,
        color: "#000",
        weight: weight,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'lieuvie': return {
        fillColor: lieuvie,
        color: "#000",
        weight: weight,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'esclavage': return {
        fillColor: esclavage,
        color: "#000",
        weight: weight,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'naissance_esclavage': return {
        fillColor: esclavage,
        color: naissance,
        weight: 2,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'esclavage_lieuvie': return {
        fillColor: esclavage,
        color: lieuvie,
        weight: 2,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'esclavage_lieuvie_deces': return {
        fillColor: "#a98c09",
        color: "#767676",
        weight: 3,
        opacity: 1,
        fillOpacity: fillop
      } ;
      case 'naissance_esclavage_lieuvie_deces': return {
        fillColor: "#9c0b0b",
        color: "#000",
        weight: 3,
        opacity: 1,
        fillOpacity: fillop
      } ;
    }
}

function style_clust(p) {
    switch (p) {
      case 'birth': return 'naissance';
      case 'publication': return 'publication';
      case 'death': return 'deces';
      case 'life': return 'lieuvie';
      case 'slavery': return 'esclavage';
    }
}

function style_pt(feature) {
    var field = feature.properties.type;
    var r=9;
    var fillop=0.8;
    if (field == "publication") {
      return {
        radius: r,
        fillColor: "#ff7800",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: fillop
      };
    } else if (field == "birth"){
      return {
        radius: r,
        fillColor: "#1ba4b6",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: fillop
      };
    } else if (field== "death") {
      return {
        radius: r,
        fillColor: "#6E2168",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: fillop
      };
    } else if (field== "slavery") {
      return {
        radius: r,
        fillColor: "#2E4C9B",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: fillop
      };
    } else if (field== "life") {
      return {
        radius: r,
        fillColor: "#20A238",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: fillop
      };
    }
}

function style_afr(feature) {
    var nom = feature.properties.Nom;
    if (nom == "Empire Ottoman") {
      return {
        color:"white",
        fillColor:"#80cdc1",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Maroc"){
      return {
        color:"white",
        fillColor:"#f6e8c3",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Royaumes Musulmans"){
      return {
        color:"white",
        fillColor:"#543005",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Royaumes Animistes"){
      return {
        color:"white",
        fillColor:"#8c510a",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Ashanti"){
      return {
        color:"white",
        fillColor:"#003c30",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Dahomey"){
      return {
        color:"white",
        fillColor:"#35978f",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Oyo"){
      return {
        color:"white",
        fillColor:"#dfc27d",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Cités Haoussa"){
      return {
        color:"white",
        fillColor:"##01665e",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Bornou"){
      return {
        color:"white",
        fillColor:"#003c30",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Darfour"){
      return {
        color:"white",
        fillColor:"#80cdc1",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Royaume Funj"){
      return {
        color:"white",
        fillColor:"#bf812d",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Ethiopie"){
      return {
        color:"white",
        fillColor:"#c7eae5",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    } else if(nom == "Ouaddaï"){
      return {
        color:"white",
        fillColor:"#dfc27d",
        fillOpacity:0.7,
        weight:0.4,
        opacity:0
      };
    }
}

function style_autoch(feature) {
    var cat = feature.properties.id_style;
    if (cat == "1") {
      return {
        color:"white",
        fillColor:"#a56d50",
        fillOpacity:0.3,
        weight:0.4,
        opacity:0
      };
    } else if(cat=="2"){
      return{
        color:"white",
        fillColor:"#31927e",
        fillOpacity:0.3,
        weight:3,
        opacity:0
      };
    } else if(cat=="3"){
      return{
        color:"white",
        fillColor:"#d4dc37",
        fillOpacity:0.3,
        weight:3,
        opacity:0
      };
    } else if(cat=="4"){
      return{
        color:"white",
        fillColor:"#d5a847",
        fillOpacity:0.3,
        weight:3,
        opacity:0
      };
    } else if(cat=="5"){
      return{
        color:"white",
        fillColor:"#406d2c",
        fillOpacity:0.3,
        weight:3,
        opacity:0
      };
    } else if(cat=="6"){
      return{
        color:"white",
        fillColor:"#47abc4",
        fillOpacity:0.3,
        weight:3,
        opacity:0
      };
    } else if(cat=="8"){
      return{
        color:"#a7dfbf",
        fillColor:"#a7dfbf",
        fillOpacity:0.6,
        weight:3,
        opacity:0
      };
    }
}