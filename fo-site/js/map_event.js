ymaps.ready(init);
var myMap;

function init () {
    myMap = new ymaps.Map("map",
                          {
                            center: [54.03482, 35.78226], // Козельск
                            zoom: 13
                          });
    // Обработка события, возникающего при щелчке
    // левой кнопкой мыши в любой точке карты.
    // При возникновении такого события перепишем координаты в соответствующие поля
    myMap.events.add('click', function (e)
    {
        var coords = e.get('coords');
        var lat = document.getElementById('lat');
        var log = document.getElementById('log');
        lat.value = coords[0].toPrecision(6);
        log.value = coords[1].toPrecision(6);
    });
}