class StarRating {
    constructor() {
        this.ratings = document.querySelectorAll('.star-rating');
        this.init();
    }

    init() {
        this.ratings.forEach(rating => {
            this.setupRating(rating);
        });
    }

    setupRating(ratingElement) {
        const stars = ratingElement.querySelectorAll('input[type="radio"]');
        const labels = ratingElement.querySelectorAll('label');

        stars.forEach((star, index) => {
            star.addEventListener('change', () => {
                this.updateRatingDisplay(ratingElement, index + 1);
            });

            const label = labels[index];
            label.addEventListener('mouseenter', () => {
                this.setHoverState(ratingElement, index + 1);
            });
        });

        ratingElement.addEventListener('mouseleave', () => {
            this.clearHoverState(ratingElement);
        });
    }

    updateRatingDisplay(ratingElement, rating) {
        const labels = ratingElement.querySelectorAll('label');
        labels.forEach((label, index) => {
            if (index < rating) {
                label.style.color = '#ffc107';
            } else {
                label.style.color = '#ddd';
            }
        });
    }

    setHoverState(ratingElement, hoverIndex) {
        const labels = ratingElement.querySelectorAll('label');
        labels.forEach((label, index) => {
            if (index < hoverIndex) {
                label.style.color = '#ffc107';
                label.style.opacity = '0.7';
            }
        });
    }

    clearHoverState(ratingElement) {
        const checkedInput = ratingElement.querySelector('input:checked');
        const currentRating = checkedInput ? parseInt(checkedInput.value) : 0;
        this.updateRatingDisplay(ratingElement, currentRating);

        const labels = ratingElement.querySelectorAll('label');
        labels.forEach(label => {
            label.style.opacity = '1';
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new StarRating();
});
