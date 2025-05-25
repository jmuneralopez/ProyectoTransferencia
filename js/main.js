document.addEventListener('DOMContentLoaded', () => {
    // Smooth scrolling para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') { // Asegura que no sea solo '#'
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Ajusta el scroll para tener en cuenta el header fijo
                    const headerOffset = document.querySelector('.main-header').offsetHeight;
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - headerOffset - 20; // -20px para un pequeño margen

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            }
        });
    });

    // Efecto de aparición al hacer scroll (Intersection Observer API)
    const fadeInElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right');

    const observerOptions = {
        root: null, // viewport
        rootMargin: '0px',
        threshold: 0.1 // 10% del elemento visible para activar
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Dejar de observar una vez que es visible
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    fadeInElements.forEach(element => {
        observer.observe(element);
    });

    // Control del menú desplegable (Nuestro Equipo)
    const dropdownBtn = document.querySelector('.dropbtn');
    if (dropdownBtn) {
        const dropdownContent = dropdownBtn.nextElementSibling;
        dropdownBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Evita que el enlace de '#' haga scroll
            dropdownContent.classList.toggle('show');
            // Cierra el menú si se hace clic fuera
            document.addEventListener('click', function outsideClick(event) {
                if (!dropdownBtn.contains(event.target) && !dropdownContent.contains(event.target)) {
                    dropdownContent.classList.remove('show');
                    document.removeEventListener('click', outsideClick);
                }
            });
        });

        // Asegura que el menú se oculte si el tamaño de la ventana cambia
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) { // Si es de escritorio, asegura que esté oculto si no se está usando
                dropdownContent.classList.remove('show');
            }
        });
    }

    // Funcionalidad para el botón "scroll-down" en el hero banner
    const scrollDownButton = document.querySelector('.scroll-down');
    if (scrollDownButton) {
        scrollDownButton.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = scrollDownButton.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = document.querySelector('.main-header').offsetHeight;
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - headerOffset - 20; // -20px para un pequeño margen

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        });
    }
});