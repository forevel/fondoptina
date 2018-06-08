/* some code got from here: 
 * https://coderwall.com/p/vsdrug/how-to-create-an-image-slider-with-javascript
 * https://javascript.ru/forum/events/33124-izmenyaem-opacity-s-pomoshhyu-animate.html
 */

var SliderImgCount = 4; /*общее количество картинок в слайдере*/
var CurSliderImg; /*текущая картинка в слайдере*/
var SliderObj = document.getElementById("slider");
var IntervalID = setInterval(CrossFade, 5000); /* 5 s to change pics */
var ul, ulitems;

/* инициализация слайдера */
function InitSlides() {
    /* количество слайдов */
    ul = document.getElementById('sliderul');
    ulitems = ul.getElementsByTagName('li');
    SliderImgCount = ulitems.length;
    /* запускаем первый слайд */
    CurSliderImg = 0;
//    alert(SliderImgCount);
    var SlideInterval = setInterval(NextSlide, 5000);
}

function NextSlide() {
    ulitems[CurSliderImg].className = 'slide';
    CurSliderImg = (CurSliderImg + 1) % SliderImgCount;
    ulitems[CurSliderImg].className = 'slide showing';
}

/*
function CrossFade() {
Prop({
  elem:SliderObj,//элемент на котором происходит анимация
  start:[1],// начальное значение
  value:[0],// конечное значение
  prop:['opacity'],// свойство анимации
  duration:2000,// время анимации
  units:'',//единицы измерение px || % || ''-без единици измерения
  });
    SliderObj
}

//generic animate function
function animate(opts){
    var start = new Date;
    var id = setInterval(function(){
        var timePassed = new Date - start;
        var progress = timePassed / opts.duration
        if(progress > 1){
            progress = 1;
        }
        var delta = opts.delta(progress);
        opts.step(delta);
        if (progress == 1){
            clearInterval(id);
           opts.callback();
         }
    }, opts.dalay || 17);
}
*/
window.onload = InitSlides;