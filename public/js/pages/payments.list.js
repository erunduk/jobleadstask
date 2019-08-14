
getTaxLocations = function(id) {
    var result = [];
    for (var state_id in rates_data.rates) {
        for (var county_id in rates_data.rates[state_id]) {
            for (var tax_id in rates_data.rates[state_id][county_id]) {
                if (tax_id == id && rates_data.rates[state_id][county_id][tax_id] > 0) {
                    result.push({
                        state: {
                            id: state_id,
                            name: rates_data.states[state_id]
                        },
                        county: {
                            id: county_id,
                            name: rates_data.counties[county_id]
                        },
                        rate: rates_data.rates[state_id][county_id][tax_id]
                    });
                }
            }
        }
    }
    return result;
};

$(document).ready(function() {
    $('#tax').on('change', function() {
        var tax_id = $(this).val();

        $('#state').children().remove();
        if (tax_id) {
            var old_state = $('#state').val();
            var locations = getTaxLocations(tax_id);
            for (var i = 0; i < locations.length; i++) {
                var location = locations[i];
                if ($('#state').children('[value=' + location.state.id + ']').length === 0) {
                    $('#state').append('<option value="' + location.state.id + '">' + location.state.name + '</option>');
                }
            }
            if (old_state && $('#state').children('[value=' + old_state + ']').length === 1) {
                $('#state').val(old_state);
            } else {
                $('#state').val('');
            }
        }
        $('#state').change();
    });
    $('#state').on('change', function() {
        var tax_id = $('#tax').val();
        var state_id = $(this).val();

        $('#county').children().remove();
        if (state_id) {
            var old_county = $('#county').val();
            var locations = getTaxLocations(tax_id);
            for (var i = 0; i < locations.length; i++) {
                var location = locations[i];
                if (location.state.id == state_id && $('#county').children('[value=' + location.county.id + ']').length === 0) {
                    $('#county').append(
                        '<option value="' +
                        location.county.id +
                        '" data-rate="' + location.rate + '">' +
                        location.county.name +
                        ' (' + (+(Math.round(location.rate * 100 + "e+2")  + "e-2")) + ' %)' +
                        '</option>'
                    );
                }
            }
            if (old_county && $('#county').children('[value=' + old_county + ']').length === 1) {
                $('#county').val(old_county);
            } else {
                $('#county').val('');
            }
        }
        $('#county').change();
    });

    $('#tax').change();

    if ($('#state').attr('data-old')) {
        $('#state').val($('#state').attr('data-old')).change();
    }

    if ($('#county').attr('data-old')) {
        $('#county').val($('#county').attr('data-old')).change();
    }
});

