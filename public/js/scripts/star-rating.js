document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating label');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.htmlFor.replace('star', '');
            document.querySelector(`#star${rating}`).checked = true;
        });
    });
});
