document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating label');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.htmlFor.replace('star', '');
            document.querySelector(`#star${rating}`).checked = true;
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');

    if (commentTextarea && charCount) {
        commentTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;

            if (this.value.length > 900) {
                charCount.style.color = '#dc3545';
            } else if (this.value.length > 800) {
                charCount.style.color = '#ffc107';
            } else {
                charCount.style.color = '#6c757d';
            }
        });

        charCount.textContent = commentTextarea.value.length;
    }

    const form = document.querySelector('.review-form');
    form.addEventListener('submit', function(e) {
        const rating = document.querySelector('input[name="rating"]:checked');
        if (!rating) {
            e.preventDefault();
            alert('Пожалуйста, поставьте оценку туру');
            return false;
        }
    });
});
