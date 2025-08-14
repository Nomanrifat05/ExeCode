// Global variables
window.contestsPerPage = 30; // 10 contests per page
window.currentPage = 1;
window.totalPages = 0;
let allContestCards = []; // Array to store all original contest cards

// Wait for DOM to load before initializing
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded, initializing pagination...');
    // Store all contest cards in the array
    allContestCards = Array.from(document.querySelectorAll('#past-contests-list .contest-card'));
    console.log('Total contest cards stored:', allContestCards.length);
    displayPastContests(window.currentPage);
    updatePagination();
});

function displayPastContests(page) {
    window.currentPage = page;
    const start = (page - 1) * window.contestsPerPage;
    const end = start + window.contestsPerPage;
    console.log('Displaying page', page, 'with items from index', start, 'to', end, '- Total items:', allContestCards.length);
    const paginatedContests = allContestCards.slice(start, end);

    const contestList = document.getElementById('past-contests-list');
    contestList.innerHTML = ''; // Clear and re-append visible items
    paginatedContests.forEach(contest => contestList.appendChild(contest.cloneNode(true)));

    updatePagination(); // Update pagination after each page change
}

function updatePagination() {
    const pageNumbers = document.getElementById('page-numbers');
    pageNumbers.innerHTML = '';

    window.totalPages = Math.ceil(allContestCards.length / window.contestsPerPage);
    console.log('Updating pagination - Total past contests:', allContestCards.length, 'Total pages:', window.totalPages);

    const prevButton = document.getElementById('prev-page');
    prevButton.disabled = window.currentPage === 1;

    if (window.totalPages === 0) {
        pageNumbers.innerHTML = '<span>No past contests</span>';
        return;
    }

    const maxVisiblePages = 5; // Maximum number of page buttons to show
    let startPage = Math.max(1, window.currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(window.totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage < maxVisiblePages - 1) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.className = i === window.currentPage ? 'active' : '';
        pageButton.onclick = () => {
            console.log('Switching to page', i);
            window.currentPage = i;
            displayPastContests(window.currentPage);
        };
        pageNumbers.appendChild(pageButton);
    }

    if (endPage < window.totalPages) {
        if (endPage < window.totalPages - 1) {
            const ellipsis = document.createElement('span');
            ellipsis.textContent = '...';
            ellipsis.style.padding = '8px 12px';
            pageNumbers.appendChild(ellipsis);
        }
        const lastPageButton = document.createElement('button');
        lastPageButton.textContent = window.totalPages;
        lastPageButton.onclick = () => {
            console.log('Switching to page', window.totalPages);
            window.currentPage = window.totalPages;
            displayPastContests(window.currentPage);
        };
        pageNumbers.appendChild(lastPageButton);
    }

    const nextButton = document.getElementById('next-page');
    nextButton.disabled = window.currentPage === window.totalPages;
}

function changePage(direction) {
    if (direction === 'prev' && window.currentPage > 1) {
        window.currentPage--;
    } else if (direction === 'next' && window.currentPage < window.totalPages) {
        window.currentPage++;
    }
    console.log('Changing page to', window.currentPage, 'due to', direction);
    displayPastContests(window.currentPage);
}

function showSubTab(subTabId) {
    document.querySelectorAll('.sub-tab-content').forEach(subTab => {
        subTab.classList.remove('active');
    });
    document.querySelectorAll('.sub-tabs button').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById(subTabId).classList.add('active');
    document.querySelector(`.sub-tabs button[onclick="showSubTab('${subTabId}')"]`).classList.add('active');
}

function addContest() {
    const contestName = document.getElementById('contest-name').value;
    const contestDate = document.getElementById('contest-date').value;
    const contestRating = document.getElementById('contest-rating').value;
    const contestSolved = document.getElementById('contest-solved').value;
    const contestRanking = document.getElementById('contest-ranking').value;

    if (contestName && contestDate && contestRating && contestSolved && contestRanking) {
        const tbody = document.getElementById('my-contests-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${contestName}</td>
            <td>${contestRating}</td>
            <td>${contestDate}</td>
            <td>${contestSolved}</td>
            <td>${contestRanking}</td>
        `;
        tbody.appendChild(newRow);

        document.getElementById('contest-name').value = '';
        document.getElementById('contest-date').value = '';
        document.getElementById('contest-rating').value = '';
        document.getElementById('contest-solved').value = '';
        document.getElementById('contest-ranking').value = '';
    } else {
        alert('Please fill in all fields.');
    }
}