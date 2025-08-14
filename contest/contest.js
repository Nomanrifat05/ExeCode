// Initialize Swiper for Upcoming Contests
new Swiper('#upcoming-card-wrapper', {
    loop: true,
    spaceBetween: 40,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
    },
    navigation: {
        nextEl: '.swiper-button-prev',
        prevEl: '.swiper-button-next'
    },
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        500: {
            slidesPerView: 2
        },
        1000: {
            slidesPerView: 3
        }
    }
});

// Countdown Timer for Upcoming and Ongoing Contests
function updateCountdown() {
    const now = new Date();
    const allItems = [
        ...document.querySelectorAll('#upcoming-card-list .card-item'),
        ...document.querySelectorAll('#ongoing-card-list .card-item')
    ];

    allItems.forEach(item => {
        const startTime = new Date(item.getAttribute('data-start'));
        const endTime = new Date(item.getAttribute('data-end'));
        const countdownElement = item.querySelector('.countdown-timer');
        const diff = (item.parentElement.id === 'upcoming-card-list' ? startTime : endTime) - now;

        if (diff <= 0 && item.parentElement.id === 'upcoming-card-list' && now < endTime) {
            // Move to Ongoing Contests
            const badge = item.querySelector('.badge').textContent;
            const contestId = item.getAttribute('data-contest-id');
            const isRegistered = item.querySelector('.card-button')?.getAttribute('data-registered') === 'true';

            console.log(`Transitioning contest: ${badge}, ID: ${contestId}, Registered: ${isRegistered}, Now: ${now}, Start: ${startTime}, End: ${endTime}`);

            const cardLink = document.createElement('a');
            cardLink.href = '#';
            cardLink.className = 'card-link';
            cardLink.innerHTML = `
                <div class="card-container">
                    <div class="img-box">
                        <img src="contest.jpg" alt="Card Image" class="card-image" />
                        <div class="contest-info">
                            Ends in <span class="countdown-timer" data-target="${endTime.toISOString()}"></span>
                        </div>
                    </div>
                    <div class="content-box2">
                        <p class="badge">${badge}</p>
                        ${isRegistered ? `<button class="open-contest-btn" data-contest-id="${contestId}">&#8658;</button>` : ''}
                    </div>
                </div>
            `;

            const newItem = document.createElement('li');
            newItem.className = 'card-item';
            newItem.setAttribute('data-start', item.getAttribute('data-start'));
            newItem.setAttribute('data-end', item.getAttribute('data-end'));
            newItem.setAttribute('data-contest-id', contestId);
            newItem.appendChild(cardLink);
            document.getElementById('ongoing-card-list').appendChild(newItem);

            // Update countdown for the new item
            setTimeout(() => {
                const newCountdown = newItem.querySelector('.countdown-timer');
                if (newCountdown) {
                    const endTime = new Date(newItem.getAttribute('data-end'));
                    const diff = endTime - now;
                    if (diff > 0) {
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                        const minutes = Math.floor((diff / (1000 * 60)) % 60);
                        const seconds = Math.floor((diff / 1000) % 60);
                        newCountdown.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                    } else {
                        newCountdown.textContent = "Ended";
                    }
                }

                // Add click handler for Open Contest button
                const openButton = newItem.querySelector('.open-contest-btn');
                if (openButton) {
                    openButton.onclick = () => {
                        const contestId = openButton.getAttribute('data-contest-id');
                        console.log(`Opening contest with ID: ${contestId}`);
                        alert(`Opening ${badge} with ID: ${contestId}`);
                        // TODO: Replace alert with actual navigation, e.g., window.location.href = `contest.php?id=${contestId}`;
                    };
                }
            }, 0);

            item.remove();
            updateCountdown(); // Recheck after moving
        } else if (diff > 0) {
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);
            countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        } else {
            countdownElement.textContent = item.parentElement.id === 'upcoming-card-list' ? "Started" : "Ended";
            if (item.parentElement.id === 'ongoing-card-list') {
                item.remove(); // Remove from ongoing
                window.location.reload(); // Reload to update past contests
            }
        }
    });
}

// Initial call and interval
document.addEventListener('DOMContentLoaded', () => {
    updateCountdown(); // Start the countdown
    setInterval(updateCountdown, 1000); // Update every second

    // Add click handlers for existing Open Contest buttons
    document.querySelectorAll('.open-contest-btn').forEach(button => {
        button.onclick = () => {
            const contestId = button.getAttribute('data-contest-id');
            const badge = button.closest('.content-box').querySelector('.badge').textContent;
            console.log(`Opening contest with ID: ${contestId}`);
            alert(`Opening ${badge} with ID: ${contestId}`);
            // TODO: Replace alert with actual navigation, e.g., window.location.href = `contest.php?id=${contestId}`;
        };
    });
});