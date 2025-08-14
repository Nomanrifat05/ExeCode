const profileImage = document.getElementById("profileImage");
const previewImage = document.getElementById("previewImage");
const uploadInput = document.getElementById("uploadInput");
const modal = document.getElementById("profilePicModal");
const zoomSlider = document.getElementById("zoomSlider");
const defaultImage = "https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png";
let imageHistory = [defaultImage];
let currentIndex = 0;
let rotation = 0;
let zoomLevel = 1;

function openModal() {
  modal.style.display = "flex";
  previewImage.src = profileImage.src;
  imageHistory = [profileImage.src];
  currentIndex = 0;
  rotation = 0;
  zoomLevel = 1;
  zoomSlider.value = 1;
  updateImageTransform();
}

function closeModal() {
  modal.style.display = "none";
  uploadInput.value = "";
  imageHistory = [profileImage.src];
  currentIndex = 0;
  rotation = 0;
  zoomLevel = 1;
  zoomSlider.value = 1;
  updateImageTransform();
}

function previewNewImage() {
  const file = uploadInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      previewImage.src = e.target.result;
      imageHistory.push(e.target.result);
      currentIndex = imageHistory.length - 1;
      rotation = 0;
      zoomLevel = 1;
      zoomSlider.value = 1;
      updateImageTransform();
    };
    reader.readAsDataURL(file);
  }
}

function resetImage() {
  previewImage.src = defaultImage;
  imageHistory = [defaultImage];
  currentIndex = 0;
  rotation = 0;
  zoomLevel = 1;
  zoomSlider.value = 1;
  uploadInput.value = "";
  updateImageTransform();
}

function zoomImage(value) {
  zoomLevel = parseFloat(value);
  updateImageTransform();
}

function rotateImage(direction) {
  rotation += direction === 'clockwise' ? 90 : -90;
  updateImageTransform();
}

function updateImageTransform() {
  previewImage.style.transform = `rotate(${rotation}deg) scale(${zoomLevel})`;
}

function saveImage() {
  const canvas = document.createElement("canvas");
  const ctx = canvas.getContext("2d");
  const img = new Image();
  img.src = previewImage.src;
  img.onload = function () {
    const size = 100;
    canvas.width = size;
    canvas.height = size;
    ctx.translate(size / 2, size / 2);
    ctx.rotate((rotation * Math.PI) / 180);
    ctx.scale(zoomLevel, zoomLevel);
    ctx.drawImage(img, -size / 2, -size / 2, size, size);
    profileImage.src = canvas.toDataURL("image/png");
    closeModal();
    // Note: Server-side image saving requires additional implementation
  };
}

const themeToggle = document.getElementById('themeToggle');

themeToggle.addEventListener('change', function () {
  const isDark = this.checked;
  document.body.style.background = isDark ? '#121212' : '#f3f3f3';
  document.querySelectorAll('.profile-box, .account-settings, .sidebar').forEach(el => {
    el.style.background = isDark ? '#1e1e1e' : 'white';
    el.style.color = isDark ? '#f0f0f0' : '#000';
  });
  document.querySelectorAll('input, select, textarea').forEach(input => {
    input.style.background = isDark ? '#2a2a2a' : '';
    input.style.color = isDark ? '#f0f0f0' : '';
    input.style.border = isDark ? '1px solid #444' : '';
  });
  const progressFill = document.querySelectorAll('.progress-fill');
  progressFill.forEach(fill => {
    fill.style.backgroundColor = isDark ? '#d1d5db' : fill.style.backgroundColor.replace(/#[0-9a-f]{6}/i, match => {
      return isDark ? '#d1d5db' : match;
    });
  });
  const circularStat = document.querySelector('.progressCircularBar circle:last-child');
  if (circularStat) {
    circularStat.style.stroke = isDark ? '#d1d5db' : '#4caf4f';
  }
});

function showSection(sectionId) {
  document.getElementById('basicInfo').style.display = sectionId === 'basicInfo' ? 'block' : 'none';
  document.getElementById('accountSettings').style.display = sectionId === 'accountSettings' ? 'block' : 'none';

  document.getElementById('basicInfoTab').classList.toggle('active', sectionId === 'basicInfo');
  document.getElementById('accountSettingsTab').classList.toggle('active', sectionId === 'accountSettings');
}

function toggleEdit(element) {
  const parent = element.parentElement;
  const isAccountSection = parent.classList.contains('info-row');
  if (isAccountSection) {
    const valueWrapper = parent.querySelector('.value-wrapper');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    valueWrapper.style.display = 'none';
    editMode.style.display = 'flex';
    editBtn.style.display = 'none';
  } else {
    const valueSpan = parent.querySelector('.value');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    valueSpan.style.display = 'none';
    editMode.style.display = 'flex';
    editBtn.style.display = 'none';
  }
}

function cancelEdit(element) {
  const parent = element.parentElement.parentElement.parentElement;
  const isAccountSection = parent.classList.contains('info-row');
  if (isAccountSection) {
    const valueWrapper = parent.querySelector('.value-wrapper');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    valueWrapper.style.display = 'flex';
    editMode.style.display = 'none';
    editBtn.style.display = 'inline-block';
  } else {
    const valueSpan = parent.querySelector('.value');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    valueSpan.style.display = 'inline-block';
    editMode.style.display = 'none';
    editBtn.style.display = 'inline-block';
  }
}

function saveField(element, validator) {
  const parent = element.parentElement.parentElement.parentElement;
  const isAccountSection = parent.classList.contains('info-row');
  if (isAccountSection) {
    const valueWrapper = parent.querySelector('.value-wrapper');
    const valueSpan = valueWrapper.querySelector('.value');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    let newValue;
    if (parent.querySelector('label').textContent === 'Location') {
      const selects = editMode.querySelectorAll('select');
      const country = selects[0].value;
      const state = selects[1].value;
      const city = selects[2].value;
      newValue = `${country}, ${state}, ${city}`;
    } else {
      const input = editMode.querySelector('input, select');
      newValue = input.value;
    }
    if (!validator(newValue, parent.querySelector('label').textContent)) {
      return;
    }
    valueSpan.textContent = newValue;
    valueWrapper.style.display = 'flex';
    editMode.style.display = 'none';
    editBtn.style.display = 'inline-block';
  } else {

    const valueSpan = parent.querySelector('.value');
    const editMode = parent.querySelector('.edit-mode');
    const editBtn = parent.querySelector('.edit-btn');
    let newValue;
    if (parent.querySelector('label').textContent === 'Location') {
      const selects = editMode.querySelectorAll('select');
      const country = selects[0].value;
      const state = selects[1].value;
      const city = selects[2].value;
      newValue = `${country}, ${state}, ${city}`;
    } else {
      const input = editMode.querySelector('input, select, textarea');
      newValue = input.value;
    }
    if (!validator(newValue, parent.querySelector('label').textContent)) {
      return;
    }
    valueSpan.textContent = newValue;
    valueSpan.style.display = 'inline-block';
    editMode.style.display = 'none';
    editBtn.style.display = 'inline-block';
  }
}

function validateNotEmpty(value, fieldName) {
  if (!value || value.trim() === '' || value === 'Not provided' || value === 'Select...') {
    alert(`${fieldName} cannot be empty or set to default value.`);
    return false;
  }
  return true;
}

function validateLocation(value, fieldName) {
  const [country, state, city] = value.split(', ').map(v => v.trim());
  if (!country || !state || !city || country === 'Country/Region' || state === 'State/Province' || city === 'City/Town') {
    alert(`${fieldName} must have valid selections for Country, State, and City.`);
    return false;
  }
  return true;
}

function validateEmail(value, fieldName) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(value)) {
    alert(`${fieldName} must be a valid email address.`);
    return false;
  }
  return true;
}

function togglePasswordEdit() {
  const passwordEdit = document.querySelector('.password-edit');
  passwordEdit.style.display = 'block';
  const passwordRow = document.querySelector('.info-row label[for="password"], .info-row:has([name="password"])');
  passwordRow.style.display = 'none';
}

function cancelPasswordEdit() {
  const passwordEdit = document.querySelector('.password-edit');
  passwordEdit.style.display = 'none';
  const passwordRow = document.querySelector('.info-row label[for="password"], .info-row:has([name="password"])');
  passwordRow.style.display = 'flex';
  document.getElementById('prevPassword').value = '';
  document.getElementById('newPassword').value = '';
  document.getElementById('confirmPassword').value = '';
}

function changePassword() {
  const prevPassword = document.getElementById('prevPassword').value;
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  if (!prevPassword || !newPassword || !confirmPassword) {
    alert("Please fill in all password fields.");
    return;
  }

  if (newPassword !== confirmPassword) {
    alert("New password and confirm password do not match!");
    return;
  }

  if (newPassword.length < 8) {
    alert("New password must be at least 8 characters long.");
    return;
  }

  // Trigger form submission for server-side processing
  const passwordForm = document.querySelector('form:has([name="prevPassword"])');
  passwordForm.submit();
}

function deleteAccount() {
  if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
    const deleteForm = document.querySelector('form:has([name="action"][value="delete_account"])');
    deleteForm.submit();
  }
}

// Form validation on submit
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', function(event) {
    const action = form.querySelector('input[name="action"]').value;
    if (action === 'update_profile') {
      const name = form.querySelector('input[name="name"]')?.value.trim();
      const execodeId = form.querySelector('input[name="execode_id"]')?.value.trim();
      const country = form.querySelector('select[name="country"]')?.value;
      const state = form.querySelector('select[name="state"]')?.value;
      const city = form.querySelector('select[name="city"]')?.value;

      if (!validateNotEmpty(name, 'Name') || !validateNotEmpty(execodeId, 'ExeCode ID')) {
        event.preventDefault();
        return;
      }
      // if (!validateEmail(email, 'Email')) {
      //   event.preventDefault();
      //   return;
      // }
      if (country || state || city) {
        const location = `${country}, ${state}, ${city}`;
        if (!validateLocation(location, 'Location')) {
          event.preventDefault();
          return;
        }
      }
    } else if (action === 'update_password') {
      const prevPassword = form.querySelector('input[name="prevPassword"]')?.value.trim();
      const newPassword = form.querySelector('input[name="newPassword"]')?.value.trim();
      const confirmPassword = form.querySelector('input[name="confirmPassword"]')?.value.trim();

      if (!prevPassword || !newPassword || !confirmPassword) {
        event.preventDefault();
        alert('All password fields are required.');
        return;
      }
      if (newPassword !== confirmPassword) {
        event.preventDefault();
        alert('New password and confirm password do not match.');
        return;
      }
      if (newPassword.length < 8) {
        event.preventDefault();
        alert('New password must be at least 8 characters long.');
        return;
      }
    }
  });
});

// Show Basic Info by default
showSection('basicInfo');
