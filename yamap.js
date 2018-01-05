    ymaps.ready(init);
    var myMap;

    function init(){     
        myMap = new ymaps.Map("projectmap", {
            center: [54.034823, 35.782260], 
            zoom: 13
        });
    }