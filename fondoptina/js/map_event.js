var myMap;

ymaps.ready(init);

function init () {
    var lat = document.getElementById('lat');
    var log = document.getElementById('log');
    myMap = new ymaps.Map('yamap',
                          {
                            center: [54.11460, 35.62550],
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
    myPlacemark = new ymaps.Placemark( // [lat, log],
        [54.11460, 35.62550],
                                      {
        hintContent: ''},{
        iconLayout: 'default#image',
        iconImageHref: 'C:/xampp/htdocs/fondoptina/fo-site/upload/building.png',
        iconImageSize: [30, 40],
        iconImageOffset: [0, 0]
    });
    myMap.geoObjects.add(myPlacemark);
}

function setmapcenter (lat, log, name, pic)
{
    myPlacemark = new ymaps.Placemark([lat, log],
                                      {
        hintContent: name},{
        iconLayout: 'default#image',
        iconImageHref: pic,
        iconImageSize: [30, 40],
        iconImageOffset: [0, 0]
    });
    myMap.geoObjects.add(myPlacemark);
}

function setcenter()
{
}