document.addEventListener('DOMContentLoaded', function () {
    var scrollToTopButton = document.getElementById('scrollToTop');

    function hidePopup() {
        document.getElementById('cookiePopup').style.display = 'none';
    }

    window.addEventListener('scroll', function () {
        // Отобразить/скрыть кнопку при прокрутке
        if (window.scrollY > window.innerHeight) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }
    });

    // Плавная прокрутка при клике на кнопку
    scrollToTopButton.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

