let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slider-dot');

function showSlide(index) {
    slides.forEach((slide) => slide.classList.remove('active'));
    dots.forEach((dot) => dot.classList.remove('active'));

    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }

    if (slides[currentSlide]) {
        slides[currentSlide].classList.add('active');
    }

    if (dots[currentSlide]) {
        dots[currentSlide].classList.add('active');
    }
}

if (slides.length > 0) {
    setInterval(() => {
        showSlide(currentSlide + 1);
    }, 5000);
}

dots.forEach((dot, index) => {
    dot.addEventListener('click', (event) => {
        event.preventDefault();
        showSlide(index);
    });
});

function openQuoteModal() {
    const modal = document.getElementById('quoteModal');
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeQuoteModal() {
    const modal = document.getElementById('quoteModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

window.openQuoteModal = openQuoteModal;
window.closeQuoteModal = closeQuoteModal;

window.addEventListener('click', (event) => {
    const modal = document.getElementById('quoteModal');
    if (event.target === modal) {
        closeQuoteModal();
    }
});

function toggleMobileMenu() {
    const navMenu = document.getElementById('navMenu');
    const menuToggle = document.querySelector('.mobile-menu-toggle');

    if (navMenu && menuToggle) {
        navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active');
    }
}

window.toggleMobileMenu = toggleMobileMenu;

document.addEventListener('DOMContentLoaded', () => {
    const emailEndpoint = document.body.dataset.emailEndpoint;
    const quoteForm = document.getElementById('quoteForm');
    const quoteFormMessage = document.getElementById('quote-form-message');
    const quoteSubmitBtn = document.getElementById('quoteSubmitBtn');
    const contactForm = document.getElementById('contactForm');
    const contactFormMessage = document.getElementById('form-message');
    const contactSubmitBtn = document.getElementById('submitBtn');
    const navLinks = document.querySelectorAll('.nav-menu a');
    const navMenu = document.getElementById('navMenu');
    const menuToggle = document.querySelector('.mobile-menu-toggle');

    function submitInquiryForm(form, messageElement, submitButton, idleText, fallbackError, onSuccess) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
            messageElement.style.display = 'none';

            fetch(emailEndpoint || form.getAttribute('action') || '/inquiries', {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                },
            })
                .then(async (response) => {
                    const data = await response.json();
                    return { data, ok: response.ok };
                })
                .then(({ data, ok }) => {
                    messageElement.style.display = 'block';

                    if (ok && data.success) {
                        messageElement.className = 'success';
                        messageElement.textContent = data.message;
                        form.reset();

                        if (typeof onSuccess === 'function') {
                            onSuccess();
                        }
                    } else {
                        messageElement.className = 'error';
                        messageElement.textContent = data.message || fallbackError;
                    }

                    submitButton.disabled = false;
                    submitButton.textContent = idleText;
                    messageElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                })
                .catch((error) => {
                    messageElement.style.display = 'block';
                    messageElement.className = 'error';
                    messageElement.textContent = fallbackError;
                    submitButton.disabled = false;
                    submitButton.textContent = idleText;
                    console.error('Error:', error);
                    messageElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
        });
    }

    if (quoteForm && quoteFormMessage && quoteSubmitBtn) {
        submitInquiryForm(
            quoteForm,
            quoteFormMessage,
            quoteSubmitBtn,
            'Submit',
            'Sorry, there was an error sending your quote request. Please try again or contact us directly at info@ariesxpress.com',
            () => {
                setTimeout(() => {
                    closeQuoteModal();
                }, 2000);
            }
        );
    }

    if (contactForm && contactFormMessage && contactSubmitBtn) {
        submitInquiryForm(
            contactForm,
            contactFormMessage,
            contactSubmitBtn,
            'Send Message',
            'Sorry, there was an error sending your message. Please try again or contact us directly at info@ariesxpress.com'
        );
    }

    document.querySelectorAll('input[name="tracking_number"]').forEach((input) => {
        input.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            if (navMenu && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                if (menuToggle) {
                    menuToggle.classList.remove('active');
                }
            }
        });
    });

    document.addEventListener('click', (event) => {
        const nav = document.querySelector('.main-nav');
        const isClickInsideNav = nav && nav.contains(event.target);

        if (!isClickInsideNav && navMenu && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            if (menuToggle) {
                menuToggle.classList.remove('active');
            }
        }
    });
});