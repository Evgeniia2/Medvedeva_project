 
 const shakingIcon = document.getElementById('icon');// путь к изображению


 window.addEventListener('load', startShakeAnimation); // анимация при загрузке страницы

 
 function startShakeAnimation() {
     // запускаем дрожание с интервалом
     const shakeInterval = setInterval(() => {  
         // смещение
         const offsetX = Math.random() * 10 - 5; // диапазон смещения
         const offsetY = Math.random() * 10 - 5;

         // применяем полученные диапазон
         shakingIcon.style.transform = `translate(${offsetX}px, ${offsetY}px)`;

         // Время дрожания в милисекундах
         setTimeout(() => {
             shakingIcon.style.transform = 'translate(0, 0)'; // вернуть изображение в стандартное состояние
         }, 500);
     }, 1000); // частота дрожания 1 секунда

     // время через которое прекращаем дрожать
     setTimeout(() => {
         clearInterval(shakeInterval); // сбрасываем интервал
         shakingIcon.style.transform = 'translate(0, 0)'; // вернуть изображение в стандартное состояние
     }, 50000); // прекращаем чере 50 секунд
 }
