(function ($) {
    $(window).on('load', function () {
        initMap();
    });

    function initMap() {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2RiLXN0dWRpbyIsImEiOiJjanl3amJ5NHUweTdiM2JuNGV0b3VvOXlhIn0.4EWyUOq1U6Ib_bZi4-d2KQ';
        map = new mapboxgl.Map({
            container: 'item_map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: marker.coordinates,
            zoom: marker.zoom,
        });


        map.addControl(new MapboxLanguage({
            //defaultLanguage: 'mul'
            //defaultLanguage: 'en'
            defaultLanguage: 'ru'
        }));

        var el = document.createElement('div'), html = '';
        el.className = 'item-marker';

        mar = new mapboxgl.Marker(el)
            .setLngLat(marker.coordinates)
            .setPopup(new mapboxgl.Popup({offset: 25}))
            .addTo(map);

    }

    $(document).on({
        click: function (e) {
            e.preventDefault();
            var target = $('#item_map'), new_position;
            target.height('340px');
            new_position = target.offset();
            console.log(new_position);
            $('html, body').stop().animate({scrollTop: new_position.top}, 600);
        }
    }, '.showOnmap');

})(jQuery);
