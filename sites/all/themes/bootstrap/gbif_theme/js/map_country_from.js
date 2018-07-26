(function ($) {

  $(document).ready(function (){
console.log("plop");
    if ($('.country_iso').length==0) return;
    var country_iso = $(".country_iso").html();
    console.log(country_iso);

    var mbAttr =  'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                  '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                  'Imagery © <a href="http://mapbox.com">Mapbox</a>';

    var mapbox =  L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    noWrap:true,
                    continuousWorld: false,
                    maxZoom: 20,
                    attribution: mbAttr,
                    id: 'examples.map-i875mjb7'
    });

    var stamen = L.tileLayer('http://{s}.tile.stamen.com/toner-background/{z}/{x}/{y}.png', {
                        attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        subdomains: 'abcd',
                        minZoom: 0,
                        noWrap:true,
                        continuousWorld: false,
                        maxZoom: 20 });

    var api_url = "http://api.gbif.org/v1/map/density/tile?x={x}&y={y}&z={z}";
    var gbifAttr = api_url + "&key="+country_iso+"&type=PUBLISHING_COUNTRY&palette=yellows_reds&resolution=2";
    var gbif =  L.tileLayer(gbifAttr, { continuousWorld: false,noWrap:true,attribution:'<a href="http://www.gbif.org">GBIF Api</a>'});
    var map = L.map('ma_part',{layers: [mapbox, gbif], fullscreenControl: true}).setView([-19,48], 5);
    var baseLayers = {"Fond de carte monde": mapbox,"Fond de carte noir et blanc" : stamen};
    var overlays = {"Données publiées sur le GBIF": gbif};
    L.control.layers(baseLayers, overlays).addTo(map);
  });

})(jQuery);
