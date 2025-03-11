let nextDom = document.getElementById('next');
let prevDom = document.getElementById('prev');
let caruselDom = document.querySelector('.carousel');
let listItemDom = document.querySelector('.carousel .listCarousel');
let thumbnailDom = document.querySelector('.carousel .thumbnail');

nextDom.onclick = function(){
    showSlider('next');
}
prevDom.onclick = function(){
    showSlider('prev');
}

let timeRunning = 5000;
let timeAutomaticNext = 10000;
let runTimeOut;
let AutoRun = setTimeout(() => {
    nextDom.click();
}, timeAutomaticNext);

function showSlider(type){
    let itemSlider = document.querySelectorAll('.carousel .listCarousel .itemCarousel')
    let itemThrumbnail = document.querySelectorAll('.carousel .thumbnail .itemThumbnail')

    if (type === 'next'){
        listItemDom.appendChild(itemSlider[0]);
        thumbnailDom.appendChild(itemThrumbnail[0]);
        caruselDom.classList.add('next')
    }else{
        let positionLastItem = itemSlider.length - 1; 
        listItemDom.prepend(itemSlider[positionLastItem]);
        thumbnailDom.prepend(itemThrumbnail[positionLastItem]);
        caruselDom.classList.add('prev');
    }

    clearTimeout(runTimeOut);
    runTimeOut = setTimeout(() =>{
        caruselDom.classList.remove('next');
        caruselDom.classList.remove('prev');
    }, timeRunning);

    clearTimeout(AutoRun);
    AutoRun = setTimeout(() => {
        nextDom.click();
    }, timeAutomaticNext);
}