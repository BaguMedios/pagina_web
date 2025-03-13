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

let timeRunning = 1000;
let timeAutomaticNext = 1000000000;
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

//animacion de service se elimino por desuso

    document.addEventListener("DOMContentLoaded", function () {
        const elementos = document.querySelectorAll(".fondo");
        const contenedor = document.querySelector(".serviceBanner");

        function actualizarDimensiones() {
            return {
                maxX: contenedor.clientWidth,
                maxY: contenedor.clientHeight
            };
        }

        let { maxX, maxY } = actualizarDimensiones();
        window.addEventListener("resize", () => {
            let dimensiones = actualizarDimensiones();
            maxX = dimensiones.maxX;
            maxY = dimensiones.maxY;
        });

        let objetos = [];

        elementos.forEach(el => {
            let speedX = (Math.random() - 0.5) * 3; // Velocidad aleatoria en X
            let speedY = (Math.random() - 0.5) * 3; // Velocidad aleatoria en Y
            let posX = Math.random() * (maxX - el.clientWidth);
            let posY = Math.random() * (maxY - el.clientHeight);

            objetos.push({ el, posX, posY, speedX, speedY });
        });

        function animar() {
            objetos.forEach(obj => {
                obj.posX += obj.speedX;
                obj.posY += obj.speedY;

                // Asegurar que los elementos reboten dentro de los límites reales del contenedor
                if (obj.posX <= 0 || obj.posX >= maxX - obj.el.clientWidth) {
                    obj.speedX *= -1;
                    obj.posX = Math.max(0, Math.min(obj.posX, maxX - obj.el.clientWidth));
                }
                if (obj.posY <= 0 || obj.posY >= maxY - obj.el.clientHeight) {
                    obj.speedY *= -1;
                    obj.posY = Math.max(0, Math.min(obj.posY, maxY - obj.el.clientHeight));
                }

                obj.el.style.transform = `translate(${obj.posX}px, ${obj.posY}px)`;
            });

            requestAnimationFrame(animar);
        }

        animar();
    });

