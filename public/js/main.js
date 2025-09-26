document.addEventListener('DOMContentLoaded', function() {
    const masks = {};
    const maskedInputs = document.querySelectorAll('[data-mask]');

    maskedInputs.forEach(function(element) {
        const maskOptions = {
            mask: element.getAttribute('data-mask')
        };
        masks[element.id] = IMask(element, maskOptions);
    });
});