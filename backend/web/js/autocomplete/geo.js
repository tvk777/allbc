(function ($) {
    $(document).ready(function () {
        var options = {
            types: ['address']
        };
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address_autocomplate_name'), options);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            geo_parse_result(place);
            $('#address_autocomplate_value').val(place.geometry.location.lat() + ',' + place.geometry.location.lng());
        });


        var optionsCities = {
            types: ['(cities)']
        };
        var autocompleteCities = new google.maps.places.Autocomplete(document.getElementById('city_autocomplate_name'), optionsCities);
        autocompleteCities.addListener('place_changed', function () {
            var place = autocompleteCities.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#city_autocomplate_value').val(place.geometry.location.lat() + ',' + place.geometry.location.lng());
        });

        var optionsCountries = {
            types: ['(regions)']
        };
        var autocompleteCountries = new google.maps.places.Autocomplete(document.getElementById('country_autocomplate_name'), optionsCountries);
        autocompleteCountries.addListener('place_changed', function () {
            var place = autocompleteCountries.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            $('#country_autocomplate_value').val(place.geometry.location.lat() + ',' + place.geometry.location.lng());
        });

        var optionsDistricts = {
            types: ['(regions)']
        };

        var autocompleteDistricts = new google.maps.places.Autocomplete(document.getElementById('district_autocomplate_name'), optionsDistricts);
        autocompleteDistricts.addListener('place_changed', function () {
            var place = autocompleteDistricts.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            $('#district_autocomplate_value').val(place.geometry.location.lat() + ',' + place.geometry.location.lng());
        });

        $('.nav-tabs li').click(function () {
            setTimeout(function () {
                if ($('#gmapbox').is(":visible"))
                    gmapbox();
            }, 600)
        });

        $("#latlng_autocomplate_name").change(function () {
            set_latlng($(this).val());
        });


        var optionsSubway = {
            types: ['geocode']
        };
        var autocompleteSubway0 = new google.maps.places.Autocomplete(document.getElementById('subway0_autocomplate_name'), optionsSubway);
        //console.log(autocompleteSubway1);
        autocompleteSubway0.addListener('place_changed', function () {
            var place = autocompleteSubway0.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#subway0_autocomplate_name').parents('form').find('.form-buttons').attr('disabled',true);
            $.ajax({
                url: 'get-subway',
                type: 'post',
                data: {
                    latlng: place.geometry.location.lat() + ',' + place.geometry.location.lng(),
                    placelatlng: $('#latlng_autocomplate_name').val()
                },
                success: function(data) {
                    result = jQuery.parseJSON(data);

                    $('#subway0_autocomplate_name').val(result[0].name);
                    $('#subway0_autocomplate_value').val(result[0].id);
                    $('#subway0_autocomplate_range').val(result[0].walk_distance);
                    $('#subway0_autocomplate_time').val(result[0].walk_seconds);
                    $('#subway0_autocomplate_name').parents('form').find('.form-buttons').attr('disabled',false);
                }
            });

        });

        var autocompleteSubway1 = new google.maps.places.Autocomplete(document.getElementById('subway1_autocomplate_name'), optionsSubway);
        autocompleteSubway1.addListener('place_changed', function () {
            var place = autocompleteSubway1.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#subway1_autocomplate_name').parents('form').find('.form-buttons').attr('disabled', true);
            $.ajax({
                url: 'get-subway',
                type: 'post',
                data: {
                    latlng: place.geometry.location.lat() + ',' + place.geometry.location.lng(),
                    placelatlng: $('#latlng_autocomplate_name').val()
                },
                success: function(data) {
                    result = jQuery.parseJSON(data);

                    $('#subway1_autocomplate_name').val(result[0].name);
                    $('#subway1_autocomplate_value').val(result[0].id);
                    $('#subway1_autocomplate_range').val(result[0].walk_distance);
                    $('#subway1_autocomplate_time').val(result[0].walk_seconds);
                    $('#subway1_autocomplate_name').parents('form').find('.form-buttons').find('button').attr('disabled',false);
                }
            });

        });

        var autocompleteSubway2 = new google.maps.places.Autocomplete(document.getElementById('subway2_autocomplate_name'), optionsSubway);
        autocompleteSubway2.addListener('place_changed', function () {
            var place = autocompleteSubway2.getPlace();

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#subway2_autocomplate_name').parents('form').find('.form-buttons').attr('disabled', true);
            $.ajax({
                url: 'get-subway',
                type: 'post',
                data: {
                    latlng: place.geometry.location.lat() + ',' + place.geometry.location.lng(),
                    placelatlng: $('#latlng_autocomplate_name').val()
                },
                success: function(data) {
                    console.log(data);

                    result = jQuery.parseJSON(data);

                    $('#subway2_autocomplate_name').val(result[0].name);
                    $('#subway2_autocomplate_value').val(result[0].id);
                    $('#subway2_autocomplate_range').val(result[0].walk_distance);
                    $('#subway2_autocomplate_time').val(result[0].walk_seconds);
                    $('#subway2_autocomplate_name').parents('form').find('.form-buttons').attr('disabled',false);
                }
            });

        });



    });

    function geo_parse_result(result) {
        $('#country_autocomplate_name').val('');
        $('#city_autocomplate_name').val('');
        $('#district_autocomplate_name').val('');
        $('#street_autocomplate_name').val('');

        for (var i = 0; i < result.address_components.length; i += 1) {
            if (result.address_components[i].types[0] == 'country' && result.address_components[i].types[1] == 'political') {
                $('#country_autocomplate_name').val(result.address_components[i].long_name);
                $('#country_autocomplate_value').val(result.geometry.location.lat() + ',' + result.geometry.location.lng());
            }
            else if (result.address_components[i].types[0] == 'locality' && result.address_components[i].types[1] == 'political') {
                $('#city_autocomplate_name').val(result.address_components[i].long_name);
                $('#city_autocomplate_value').val(result.geometry.location.lat() + ',' + result.geometry.location.lng());
            }
            else if (result.address_components[i].types[0] == 'sublocality_level_1' && result.address_components[i].types[1] == 'sublocality' && result.address_components[i].types[2] == 'political') {
                $('#district_autocomplate_name').val(result.address_components[i].long_name);
                $('#district_autocomplate_value').val(result.geometry.location.lat() + ',' + result.geometry.location.lng());
            }
            else if (result.address_components[i].types[0] == 'street_number' && result.address_components[i + 1].types[0] == 'route') {
                $('#street_autocomplate_name').val(result.address_components[i + 1].long_name + " " + result.address_components[i].long_name);
            }
        }
        set_latlng(result.geometry.location.lat() + ',' + result.geometry.location.lng());
        //GeoGetSubways(result.geometry.location.lat()+','+result.geometry.location.lng());

    }

    function set_latlng(value) {
        value = value.replace(' ', '');
        value = value.split(',');
        if (value[0] != undefined && value[1] != undefined) {
            $('#lat_autocomplate_value').val(value[0]);
            $('#lng_autocomplate_value').val(value[1]);
            $('#latlng_autocomplate_name').val(value[0] + ', ' + value[1]);
            gmapbox();
        }
        else {
            $('#lat_autocomplate_value').val('');
            $('#lng_autocomplate_value').val('');
        }
    }

    function gmapbox() {
        if ($('#lat_autocomplate_value').val() == "")
            return (0);
        var uluru = {
            lat: parseFloat($('#lat_autocomplate_value').val()),
            lng: parseFloat($('#lng_autocomplate_value').val())
        };
        var map = new google.maps.Map(document.getElementById('gmapbox'), {
            zoom: 17,
            center: uluru
        });


        var marker = new google.maps.Marker({
            position: uluru,
            draggable: true,
            map: map
        });
        marker.addListener('dragend', function () {
            set_latlng(marker.getPosition().lat() + ',' + marker.getPosition().lng());
        });
    };


})(jQuery);
