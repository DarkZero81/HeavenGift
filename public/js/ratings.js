// Ratings and Reviews JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Star rating interaction
    const ratingContainers = document.querySelectorAll(
        ".rating-stars, .rating"
    );

    ratingContainers.forEach((container) => {
        const stars = container.querySelectorAll('input[type="radio"]');
        const labels = container.querySelectorAll("label");

        // Add hover effects for rating stars
        labels.forEach((label, index) => {
            label.addEventListener("mouseenter", function () {
                // Highlight current star and all previous stars
                for (let i = 0; i <= index; i++) {
                    if (labels[i]) {
                        labels[i].style.color = "#6f00ff";
                    }
                }
            });

            label.addEventListener("mouseleave", function () {
                // Reset colors based on checked state
                resetStarColors(container);
            });
        });

        // Add click handlers for rating selection
        stars.forEach((star) => {
            star.addEventListener("change", function () {
                const rating = parseInt(this.value);
                updateRatingDisplay(container, rating);

                // Add visual feedback
                showRatingFeedback(container, rating);
            });
        });
    });

    // Helper function to reset star colors
    function resetStarColors(container) {
        const labels = container.querySelectorAll("label");
        const checkedStar = container.querySelector(
            'input[type="radio"]:checked'
        );

        labels.forEach((label) => {
            label.style.color = "#ccc";
        });

        if (checkedStar) {
            const checkedRating = parseInt(checkedStar.value);
            // Color all stars up to the checked rating
            for (let i = 0; i < checkedRating; i++) {
                if (labels[i]) {
                    labels[i].style.color = "#6f00ff";
                }
            }
        }
    }

    // Helper function to update rating display
    function updateRatingDisplay(container, rating) {
        const ratingText =
            container.parentElement.querySelector(".rating-text");
        if (ratingText) {
            ratingText.textContent = `${rating} star${
                rating !== 1 ? "s" : ""
            } selected`;
        }
    }

    // Helper function to show rating feedback
    function showRatingFeedback(container, rating) {
        // Create temporary feedback element
        const feedback = document.createElement("div");
        feedback.className = "rating-feedback";
        feedback.style.cssText = `
            position: absolute;
            background: #6f00ff;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
        `;

        const messages = {
            1: "Poor 😞",
            2: "Fair 😐",
            3: "Good 🙂",
            4: "Very Good 😄",
            5: "Excellent 🤩",
        };

        feedback.textContent = messages[rating] || `${rating} stars`;

        // Position feedback near the rating container
        container.style.position = "relative";
        container.appendChild(feedback);

        // Show feedback
        setTimeout(() => (feedback.style.opacity = "1"), 10);

        // Hide feedback after 2 seconds
        setTimeout(() => {
            feedback.style.opacity = "0";
            setTimeout(() => {
                if (feedback.parentNode) {
                    feedback.parentNode.removeChild(feedback);
                }
            }, 300);
        }, 2000);
    }

    // Form submission enhancements
    const reviewForms = document.querySelectorAll('form[action*="reviews"]');

    reviewForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            const ratingInput = this.querySelector(
                'input[name="rating"]:checked'
            );
            const commentInput = this.querySelector('textarea[name="comment"]');

            if (!ratingInput) {
                e.preventDefault();
                showNotification(
                    "Please select a rating before submitting.",
                    "warning"
                );
                return;
            }

            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                submitBtn.disabled = true;
            }
        });
    });

    // Progress bar animations for rating distribution
    const progressBars = document.querySelectorAll(".progress-bar");

    progressBars.forEach((bar) => {
        const width = bar.style.width;
        bar.style.width = "0%";

        // Animate when element comes into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 200);
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(bar);
    });

    // Helper function to show notifications
    function showNotification(message, type = "info") {
        const notification = document.createElement("div");
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Initialize star colors on page load
    ratingContainers.forEach((container) => {
        resetStarColors(container);
    });

    // Add smooth animations for star ratings display
    const style = document.createElement("style");
    style.textContent = `
        .rating {
            transition: all 0.3s ease;
        }

        .rating label {
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .rating label:hover {
            transform: scale(1.1);
        }

        .progress {
            transition: height 0.3s ease;
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }

        .rating-feedback {
            box-shadow: 0 4px 8px rgba(111, 0, 255, 0.3);
        }
    `;
    document.head.appendChild(style);
});
