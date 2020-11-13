var map;

const centerOfPolandCoordinates = {
    lat: 51.953750549999995,
    lng: 19.134378599999998
};

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: centerOfPolandCoordinates,
        zoom: 6
    });

    map.addListener('click', function(e) {
        showCurrentWeather(e.latLng.lat(), e.latLng.lng());
    });
}

function showCurrentWeather(latitude, longitude) {

    const apiEndpoint = Routing.generate('api.get_current_weather');
    const requestData = { latitude: latitude, longitude: longitude };

    $.post(apiEndpoint, requestData, function( data ) {
        $('#weatherModal').find('.modal-body').html( createBlockWithWeatherData(data.data) );
    }, 'json')
    .fail(function() {
        $('#weatherModal').find('.modal-body').text('Wystąpił błąd');
    });

    $('#weatherModal').find('.modal-body').text('Trwa ładowanie danych');
    $("#weatherModal").modal('show');
}

function createBlockWithWeatherData(weather) {
    return '<div>' +
        'Temperatura: ' + weather.temperature + '&#176;C<br />' +
        'Zachmurzenie: ' + weather.clouds + '%<br />' +
        'Wiatr: ' + weather.wind + ' km/h<br />' +
        'Opis: ' + weather.description +
    '</div>';
}

$('#weatherModal').on('hide.bs.modal', function (e) {
    //clear modal content
    var modal = $(this)
    modal.find('.modal-body').text('');
});
