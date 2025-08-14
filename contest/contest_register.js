function showRegisterPopup(registerButton) {
    console.log('Creating registration popup for button:', registerButton);
    document.querySelectorAll('.popup').forEach(p => p.remove());
    if (!document.body) {
        console.error('Document body not available');
        return;
    }
    const contestId = registerButton.closest('.card-item').dataset.contestId;
    const popup = document.createElement('div');
    popup.className = 'popup';
    popup.setAttribute('role', 'dialog');
    popup.setAttribute('aria-modal', 'true');
    popup.innerHTML = `
        <div class="popup-content">
            <p aria-label="Contest registration confirmation"><h3>Register for Contest</h3> <br>If you can't participate, unregister before the contest begins — your rating stays safe</p>
            <button class="popup-cancel">Maybe Later</button>
            <button class="popup-confirm">Confirm Registration</button>
        </div>
    `;
    
    document.body.appendChild(popup);
    console.log('Registration popup appended to body:', popup);

    const cancelBtn = popup.querySelector('.popup-cancel');
    const confirmBtn = popup.querySelector('.popup-confirm');
    if (!cancelBtn || !confirmBtn) {
        console.error('Popup buttons not found:', popup.innerHTML);
        document.body.removeChild(popup);
        return;
    }

    cancelBtn.onclick = () => {
        console.log('Cancel registration popup');
        document.body.removeChild(popup);
    };
    confirmBtn.onclick = () => {
        console.log('Confirm registration for contest ID:', contestId);
        fetch('contest.php', { // Changed from register_contest.php to contest.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=register&contest_id=${contestId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                registerButton.textContent = 'Registered';
                registerButton.setAttribute('data-registered', 'true');
                registerButton.classList.add('registered');
                // registerButton.style.background = '#4caf4f';
                // registerButton.style.color = '#fff';
                // Add hover event listeners
                registerButton.addEventListener('mouseover', () => {
                    if (registerButton.getAttribute('data-registered') === 'true') {
                        registerButton.textContent = 'Leave Contest';
                    }
                });
                registerButton.addEventListener('mouseout', () => {
                    if (registerButton.getAttribute('data-registered') === 'true') {
                        registerButton.textContent = 'Registered';
                    }
                });
                document.body.removeChild(popup);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error during registration:', error);
            alert('Registration failed due to a server error.', error);
        });
    };

    popup.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            console.log('Escape key pressed, closing popup');
            document.body.removeChild(popup);
        }
    });
    popup.focus();
    popup.style.display = 'flex';
}

function showUnregisterPopup(registerButton) {
    console.log('Creating unregistration popup for button:', registerButton);
    document.querySelectorAll('.popup').forEach(p => p.remove());
    if (!document.body) {
        console.error('Document body not available');
        return;
    }
    const contestId = registerButton.closest('.card-item').dataset.contestId;
    const popup = document.createElement('div');
    popup.className = 'popup';
    popup.setAttribute('role', 'dialog');
    popup.setAttribute('aria-modal', 'true');
    popup.innerHTML = `
        <div class="popup-content">
            <p aria-label="Contest unregistration confirmation"><h3>Leave Contest</h3><br>Are you sure you want to unregister?<br>Your rating will stay safe if you unregister before the contest begins.</p>
            <button class="popup-cancel">Cancel</button>
            <button class="popup-confirm">Confirm Unregistration</button>
        </div>
    `;
    document.body.appendChild(popup);
    console.log('Unregistration popup appended to body:', popup);

    const cancelBtn = popup.querySelector('.popup-cancel');
    const confirmBtn = popup.querySelector('.popup-confirm');
    if (!cancelBtn || !confirmBtn) {
        console.error('Popup buttons not found:', popup.innerHTML);
        document.body.removeChild(popup);
        return;
    }

    cancelBtn.onclick = () => {
        console.log('Cancel unregistration popup');
        document.body.removeChild(popup);
    };
    confirmBtn.onclick = () => {
        console.log('Confirm unregistration for contest ID:', contestId);
        fetch('contest.php', { // Changed from register_contest.php to contest.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=unregister&contest_id=${contestId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                registerButton.textContent = 'Register';
                registerButton.setAttribute('data-registered', 'false');
                registerButton.classList.remove('registered');
                registerButton.style.background = '';
                registerButton.style.color = '';
                // Remove hover event listeners
                const mouseoverListener = registerButton._mouseoverListener;
                const mouseoutListener = registerButton._mouseoutListener;
                if (mouseoverListener) registerButton.removeEventListener('mouseover', mouseoverListener);
                if (mouseoutListener) registerButton.removeEventListener('mouseout', mouseoutListener);
                document.body.removeChild(popup);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error during unregistration:', error);
            alert('Unregistration failed due to a server error.');
        });
    };

    popup.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            console.log('Escape key pressed, closing popup');
            document.body.removeChild(popup);
        }
    });
    popup.focus();
    popup.style.display = 'flex';
}

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('card-button')) {
        e.preventDefault();
        const button = e.target;
        console.log('Card button clicked:', button, 'data-registered:', button.getAttribute('data-registered'));
        const isRegistered = button.getAttribute('data-registered') === 'true';
        if (isRegistered) {
            showUnregisterPopup(button);
        } else {
            showRegisterPopup(button);
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const registerButtons = document.querySelectorAll('.card-button');
    console.log('DOM loaded, registration states initialized:', registerButtons.length, 'buttons processed');
    registerButtons.forEach(button => {
        // Registration state is now handled server-side in contest.php
        button._mouseoverListener = () => {
            if (button.getAttribute('data-registered') === 'true') {
                button.textContent = 'Leave Contest';
            }
        };
        button._mouseoutListener = () => {
            if (button.getAttribute('data-registered') === 'true') {
                button.textContent = 'Registered';
            }
        };
        if (button.getAttribute('data-registered') === 'true') {
            button.addEventListener('mouseover', button._mouseoverListener);
            button.addEventListener('mouseout', button._mouseoutListener);
        }
    });
});