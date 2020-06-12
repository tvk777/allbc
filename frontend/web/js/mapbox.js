(function ($) {
    var visibles = [], lg, lt, ico, element, mapParams = [], searchChecked, showMap;
    $(window).on('load', function () {
        searchChecked = false;
        showMap = false;
        $("#searchonmap").prop("checked", searchChecked);
        $("#onMap").prop("checked", showMap);
        map = initMap();
        mapFeatures(map);
        searchOnMap();
        console.log()
        if (geojson.result != 'offices') {
            $('.marker').removeClass('hover');
        }
    });

    $(".filter-form").submit(function (event) {
        searchChecked = false;
        $('#searchonmap').prop('checked') === false;
    });


    $(document).on('pjax:complete', function (event) {
        $(".map_object_templ").addClass("map_show");
        $("#onMap").prop("checked", showMap);
        if (!showMap) {
            $(".map_object_templ").removeClass("map_show");
            $(".object_map").removeClass("visible");
        }
        $("#searchonmap").prop("checked", searchChecked);
        mapFeatures(map);
        /*if (!searchChecked) {
            initMap();
        }*/
        if (geojson.result != 'offices') {
            $('.marker').removeClass('hover');
        }
        searchOnMap();
        marker_change_ico(0);
        getCardParams();
        cardSlider();
        expertsSlider();
    });

    function pjax_result(vis, cn, zm) {
        visibles = vis;
        $.pjax({
            type: 'POST',
            data: {visibles: visibles, center: cn, zoom: zm},
            container: '#cardsPjax',
            async: true,
            scrollTo: false
        });
        //console.log(visibles);
    }

    function pjax_street(id) {
        streetId = id;
        $.pjax({
            type: 'POST',
            data: {streetId: streetId},
            container: '#cardsPjax',
            async: true,
            scrollTo: false
        });
        console.log(streetId);
    }


    /*$(document).on({
     mouseenter: function () {
     if ($(this).attr('data-id')) {
     if ($('#onMap').prop('checked') == true && $('#searchonmap').prop('checked') == false && markers[$(this).attr('data-id')]._lngLat !== 'undefined') {
     var mapCenter = map.getCenter(), mapLg, mapLt;
     lg = markers[$(this).attr('data-id')]._lngLat.lng;
     lt = markers[$(this).attr('data-id')]._lngLat.lat;
     if (lt > mapCenter) {
     lt = lt + (lt - mapCenter.lat);
     }

     map.flyTo({
     center: [
     lg,
     lt
     ],
     zoom: 13,
     });

     marker_change_ico($(this).attr('data-id'));
     }
     }
     }
     }, ".objects_cards .object_card");*/

    $(document).on({
        change: function () {
            if ($('#searchonmap').prop('checked') === true) {
                searchChecked = true;
                //mapParams = getVisibles();
                //pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            } else {
                searchChecked = false;
                //pjax_result(0, 0, 0);
            }
        }
    }, '#searchonmap');

    $(document).on({
        click: function () {
            if ($(this).find("input").prop("checked")) {
                showMap = true;
                $(".map_object_templ").addClass("map_show");
                $(".object_map").addClass("visible");
            } else {
                showMap = false;
                $(".map_object_templ").removeClass("map_show");
                $(".object_map").removeClass("visible");
            }
        }
    }, '.map_checkbox');


    function marker_change_ico(id) {
        if (id === 0) return false;
        element = $(markers[id]._element);
        $('.marker').removeClass('hover');
        element.addClass('hover');
    }


    function getVisibles() {
        var bounds, minLat, maxLat, minLng, maxLng, center, zoom;
        bounds = map.getBounds();
        //console.log(bounds);
        minLat = bounds._sw.lat;
        maxLat = bounds._ne.lat;
        minLng = bounds._sw.lng;
        maxLng = bounds._ne.lng;
        visibles = [];
        for (var i = 0; i < geojson.features.length; i++) {
            if (
                geojson.features[i].geometry.coordinates[0] >= minLng &&
                geojson.features[i].geometry.coordinates[0] <= maxLng &&
                geojson.features[i].geometry.coordinates[1] >= minLat &&
                geojson.features[i].geometry.coordinates[1] <= maxLat
            ) {
                visibles.push(geojson.features[i].properties.id);
                //console.log(geojson.features[i].geometry.coordinates, visibles);
            }
        }
        center = map.getCenter();
        mapParams['center'] = [center.lng, center.lat];
        mapParams['zoom'] = map.getZoom();
        mapParams['visibles'] = visibles;
        //console.log(visibles);
        return (mapParams);
    }

    function searchOnMap() {
        map.on('dragend', function () {
            if ($('#searchonmap').prop('checked') == true) {
                mapParams = getVisibles();
                pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            }
        });
    }

    function createMarkers() {
    }


    function initMap() {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2RiLXN0dWRpbyIsImEiOiJjanl3amJ5NHUweTdiM2JuNGV0b3VvOXlhIn0.4EWyUOq1U6Ib_bZi4-d2KQ';
        map = new mapboxgl.Map({
            container: 'object_map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: center,
            zoom: zoom,
        });

        var lang = geojson.lang !== 'ua' ? geojson.lang : 'mul';
        map.addControl(new MapboxLanguage({
            defaultLanguage: lang
            //defaultLanguage: 'en'
            //defaultLanguage: 'ru'
        }));
        return map;
    }


        //console.log(geojson.features);
     function mapFeatures(map) {
         console.log(geojson.features.length);
        geojson.features.forEach(function (marker) {
            var el = document.createElement('div'), html = '', id = marker.properties.id;

            el.className = 'marker ' + id;
            if (geojson.result != 'offices') {
                html += '<div class="map-img">';
                html += '<img src="' + marker.properties.img + '"/>';
                html += '<div class="green_circle">' + marker.properties.class + '</div>';
                html += '</div>';
                html += '<h4>' + marker.properties.title + '</h4>';
                html += '<p>' + marker.properties.address + '</p>';

                mar = new mapboxgl.Marker(el)
                    .setLngLat(marker.geometry.coordinates)
                    .setPopup(new mapboxgl.Popup({offset: 25}).setHTML(html))
                    .addTo(map);
            } else {
                mar = new mapboxgl.Marker(el)
                    .setLngLat(marker.geometry.coordinates)
                    .addTo(map);
            }
            markers[id] = mar;
        });

        map.on('load', function () {
            map.addSource("bcAllbc", {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": geojson.features
                },
                cluster: true,
                clusterRadius: 40,
                clusterMaxZoom: 8
            });

            map.loadImage('./img/newmarker5.png', function (error, image) {
                if (error) throw error;
                map.addImage('pin', image);
                map.addLayer({
                    "id": "points",
                    filter: ["!", ["has", "point_count"]],
                    "type": "symbol",
                    "source": "bcAllbc",
                    "layout": {
                        "icon-image": "pin",
                        "icon-anchor": "center"
                    }
                });
            });

            map.on('click', 'points', function (e) {
                var features = map.queryRenderedFeatures(e.point, {layers: ['points']});
                var markerId = features[0].properties.id;
                if ($('#onMap').prop('checked') == true
                    && $('#searchonmap').prop('checked') == false
                    && geojson.result == 'offices'
                    && markerId !== 'undefined') {
                    console.log(markerId);
                    marker_change_ico(markerId);
                    pjax_street(markerId);
                }
            });


            map.addLayer({
                id: "cluster",
                type: "circle",
                source: "bcAllbc",
                filter: [">=", "point_count", 1],
                paint: {
                    "circle-color": "#3eb060",
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ],
                    "circle-opacity": 0.6,
                }
            });
            map.addLayer({
                id: "cluster-count",
                type: "symbol",
                source: "bcAllbc",
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 14,
                },
                "paint": {
                    "text-color": "white"
                }
            });

            map.on('click', 'cluster', function (e) {
                $('.marker').unbind('click');
                var features = map.queryRenderedFeatures(e.point, {layers: ['cluster']});
                var clusterId = features[0].properties.cluster_id;
                map.getSource('bcAllbc').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });
            map.on('mouseenter', 'cluster', function () {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'cluster', function () {
                map.getCanvas().style.cursor = '';
            });

        });

        map.on('zoomstart', function () {
            $('.marker.hover').removeClass('hover');
        });

        /*map.on('zoomend', function() {
         console.log(map.getZoom());
         });*/

    }
})(jQuery);
