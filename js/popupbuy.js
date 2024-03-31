// Открываем попап
function openPopup() {
    const orderPopup = document.getElementById("orderPopup"); // задаем путь к коду, который открываем
    orderPopup.style.display = "block"; //стиль отображения
}

// Закрываем попап
function closePopup() {
    const orderPopup = document.getElementById("orderPopup");
    orderPopup.style.display = "none"; //не отображаем этот элемент
}

document.addEventListener("DOMContentLoaded", function () { //включаем ожидание события
    
    const openPopupBtns = document.querySelectorAll(".openPopupBtn"); //применяем ко всем классам openPopupBtn чтобы все элементы каталога вызывали этот попап
    openPopupBtns.forEach(function (openBtn) {
        openBtn.addEventListener("click", openPopup); // задаем событие для активации - клик
    });

    
    const orderForms = document.querySelectorAll(".orderForm"); //добавляем к яве класс для формы заказа
    orderForms.forEach(function (form) { //ожидание события и для каждой из форм
        form.addEventListener("submit", function (event) { // активация субмит -> произойдет событие
            event.preventDefault(); // команда для  нестандартного события
            // выводим это сообщение
            alert("Ďakujem! Vaša objednávka bola prijatá. S Vami sa spojí manažér.");
            closePopup();
        });
    });
    
});