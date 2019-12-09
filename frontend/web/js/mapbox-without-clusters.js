(function ($) {
    var visibles = [], lg, lt, ico, element, mapParams = [], searchChecked;
    $(window).on('load', function () {
        searchChecked = false;
        $("#searchonmap").prop("checked", searchChecked);
        initMap();
        searchOnMap();
        console.log(markers);
    });

    $(document).on('pjax:complete', function (event) {
        $(".map_object_templ").addClass("map_show");
        $("#onMap").prop("checked", true);
        $("#searchonmap").prop("checked", searchChecked);
        initMap();
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
            async: false,
        });
        //console.log(visibles);
    }


    $(document).on({
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
    }, ".objects_cards .object_card");

    $(document).on({
        change: function () {
            if($('#searchonmap').prop('checked')===true) {
                searchChecked = true;
                mapParams = getVisibles();
                pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            } else {
                searchChecked = false;
                pjax_result(0, 0, 0);
            }
        }
    }, '#searchonmap');





    function marker_change_ico(id) {
        if(id===0) return false;
        //console.log($('.marker'));
        element = $(markers[id]._element);
        //console.log($(markers[id]._element));
        ico = element.css('background-image');

        if (ico.indexOf('newmarker5.png') !== -1) {

            $('.marker').each(function(i,elem) {
                //console.log($(elem).css('background-image'));
                ico = $(elem).css('background-image');
                if (ico.indexOf('marker_map.png') !== -1) {
                    ico = ico.replace('marker_map.png', 'newmarker5.png');
                    $(elem).css('background-image', ico);
                    $(elem).css('width', '15px');
                    $(elem).css('height', '15px');
                    $(elem).css('z-index', 1);
                }
            });

            ico = ico.replace('newmarker5.png', 'marker_map.png');
            element.css('background-image', ico);
            element.css('width', '26px');
            element.css('height', '35px');
            element.css('z-index', 9);

        }
    }


    function getVisibles(){
        var bounds, minLat, maxLat, minLng, maxLng, center, zoom;
        bounds = map.getBounds();
        minLat = bounds._sw.lat;
        maxLat = bounds._ne.lat;
        minLng = bounds._sw.lng;
        maxLng = bounds._ne.lng;
        visibles = {};
        for (var i = 0; i < geojson.features.length; i++) {
            if (
                geojson.features[i].geometry.coordinates[0] >= minLng &&
                geojson.features[i].geometry.coordinates[0] <= maxLng &&
                geojson.features[i].geometry.coordinates[1] >= minLat &&
                geojson.features[i].geometry.coordinates[1] <= maxLat
            )
                visibles[i] = geojson.features[i].properties.id;
        }
        center = map.getCenter();
        mapParams['center'] = [center.lng, center.lat]
        mapParams['zoom'] = map.getZoom();
        mapParams['visibles'] = visibles;
        return(mapParams);
    }

    function searchOnMap() {
        map.on('dragend', function () {
            if ($('#searchonmap').prop('checked') == true) {
                mapParams = getVisibles();
                //console.log(mapParams);
                pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            }
        });
    }

    function getPopupHtml($prop) {
        //alert($prop);
       var html = '';
        html +='<h6>' + $prop.title + '</h6>';
        html += '<p>' + $prop.address + '</p>';
        html += '<p>' + $prop.img + '</p>';
        html += '<p>' + $prop.class + '</p>';
    }


    function initMap() {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2RiLXN0dWRpbyIsImEiOiJjanl3amJ5NHUweTdiM2JuNGV0b3VvOXlhIn0.4EWyUOq1U6Ib_bZi4-d2KQ';
        map = new mapboxgl.Map({
            container: 'object_map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: center,
            zoom: zoom,
        });


        map.addControl(new MapboxLanguage({
            //defaultLanguage: 'mul'
            //defaultLanguage: 'en'
            defaultLanguage: 'ru'
        }));

        geojson.features.forEach(function (marker) {
            var el = document.createElement('div'), html = '';

            html += '<div class="map-img">';
            html += '<img src="' + marker.properties.img + '"/>';
            html += '<div class="green_circle">' + marker.properties.class + '</div>';
            html += '</div>';
            html +='<h4>' + marker.properties.title + '</h4>';
            html += '<p>' + marker.properties.address + '</p>';

            id = marker.properties.id;
            el.className = 'marker ' + id;
            mar = new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(html))
                .addTo(map);
            markers[id] = mar;
        });

    }
})(jQuery);
