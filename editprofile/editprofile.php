<?php
include '../Include/Connection.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];


// Initialize variables for form data
$profile_data = [
  'username' => '',
  'email' => '',
  'name' => '',
  'gender' => 'Not provided',
  'location' => '',
  'birthday' => '',
  'summary' => '',
  'website' => '',
  'github' => '',
  'linkedin' => '',
  'x_twitter' => '',
  'work' => '',
  'education' => '',
  'technical_skills' => ''
];
$message = '';

// Fetch user info from users_info
function fetchUserInfo($conn, $user_id)
{
  $query = "SELECT username, email FROM users_info WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $stmt->close();
  return $user ?: ['username' => '', 'email' => ''];
}

// Fetch solved problems count and total problems
function fetchSolvedInfo($conn, $user_id)
{
  // Count total accepted submissions for the user
  $query = "SELECT COUNT(*) as solved_count FROM submissions WHERE user_id = ? AND status = 'Accepted'";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $solved = $result->fetch_assoc()['solved_count'];
  $stmt->close();

  // Count total problems in problem_set
  $query = "SELECT COUNT(*) as total_problems FROM problem_set";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  $total = $result->fetch_assoc()['total_problems'];
  $stmt->close();

  // Calculate percentage (avoid division by zero)
  $percentage = ($total > 0) ? round(($solved / $total) * 100) : 0;

  return ['solved_count' => $solved, 'total_problems' => $total, 'percentage' => $percentage];
}

// Fetch solved problems by difficulty
function fetchSolvedByDifficulty($conn, $user_id)
{
  $difficulties = ['Easy', 'Medium', 'Hard'];
  $result = ['Easy' => 0, 'Medium' => 0, 'Hard' => 0, 'EasyTotal' => 0, 'MediumTotal' => 0, 'HardTotal' => 0];

  // Count solved problems per difficulty
  $query = "SELECT p.difficulty, COUNT(*) as count 
              FROM submissions s 
              JOIN problem_set p ON s.problem_id = p.id 
              WHERE s.user_id = ? AND s.status = 'Accepted' 
              GROUP BY p.difficulty";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) {
    if (in_array($row['difficulty'], $difficulties)) {
      $result[$row['difficulty']] = $row['count'];
    }
  }
  $stmt->close();

  // Count total problems per difficulty
  $query = "SELECT difficulty, COUNT(*) as count FROM problem_set GROUP BY difficulty";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) {
    if (in_array($row['difficulty'], $difficulties)) {
      $result[$row['difficulty'] . 'Total'] = $row['count'];
    }
  }
  $stmt->close();

  // Calculate percentages (avoid division by zero)
  $result['EasyPercent'] = ($result['EasyTotal'] > 0) ? round(($result['Easy'] / $result['EasyTotal']) * 100) : 0;
  $result['MediumPercent'] = ($result['MediumTotal'] > 0) ? round(($result['Medium'] / $result['MediumTotal']) * 100) : 0;
  $result['HardPercent'] = ($result['HardTotal'] > 0) ? round(($result['Hard'] / $result['HardTotal']) * 100) : 0;

  return $result;
}

// Fetch profile info from users_profile
function fetchProfileInfo($conn, $user_id)
{
  $query = "SELECT name, gender, location, birthday, summary, website, github, linkedin, x_twitter, work, education, technical_skills FROM users_profile WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $profile = $result->fetch_assoc();
  $stmt->close();
  return $profile ?: [
    'name' => '',
    'gender' => 'Not provided',
    'location' => '',
    'birthday' => '',
    'summary' => '',
    'website' => '',
    'github' => '',
    'linkedin' => '',
    'x_twitter' => '',
    'work' => '',
    'education' => '',
    'technical_skills' => ''
  ];
}

// Update or insert profile info
function updateProfileInfo($conn, $user_id, $data)
{
  $query = "SELECT id FROM users_profile WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $exists = $result->num_rows > 0;
  $stmt->close();

  if ($exists) {
    $query = "UPDATE users_profile SET name = ?, gender = ?, location = ?, birthday = ?, summary = ?, website = ?, github = ?, linkedin = ?, x_twitter = ?, work = ?, education = ?, technical_skills = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssssi", $data['name'], $data['gender'], $data['location'], $data['birthday'], $data['summary'], $data['website'], $data['github'], $data['linkedin'], $data['x_twitter'], $data['work'], $data['education'], $data['technical_skills'], $user_id);
  } else {
    $query = "INSERT INTO users_profile (id, name, gender, location, birthday, summary, website, github, linkedin, x_twitter, work, education, technical_skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssssssssss", $user_id, $data['name'], $data['gender'], $data['location'], $data['birthday'], $data['summary'], $data['website'], $data['github'], $data['linkedin'], $data['x_twitter'], $data['work'], $data['education'], $data['technical_skills']);
  }

  $success = $stmt->execute();
  $stmt->close();
  return $success;
}

// Update user info (username, email)
function updateUserInfo($conn, $user_id, $username, $email)
{
  $query = "UPDATE users_info SET username = ?, email = ? WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssi", $username, $email, $user_id);
  $success = $stmt->execute();
  $stmt->close();
  return $success;
}

// Update password
function updatePassword($conn, $user_id, $new_password)
{
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
  $query = "UPDATE users_info SET password = ? WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $hashed_password, $user_id);
  $success = $stmt->execute();
  $stmt->close();
  return $success;
}

// Delete account
function deleteAccount($conn, $user_id)
{
  $query = "DELETE FROM users_info WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $success = $stmt->execute();
  $stmt->close();
  return $success;
}

// Fetch data on page load
$user_info = fetchUserInfo($conn, $user_id);
$profile_info = fetchProfileInfo($conn, $user_id);
$solved_info = fetchSolvedInfo($conn, $user_id);
$difficulty_info = fetchSolvedByDifficulty($conn, $user_id);
$profile_data['username'] = $user_info['username'];
$profile_data['email'] = $user_info['email'];
$profile_data = array_merge($profile_data, $profile_info);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'update_profile') {
    $profile_data['name'] = $_POST['name'] ?? '';
    $profile_data['gender'] = $_POST['gender'] ?? 'Not provided';
    $profile_data['location'] = implode(', ', array_filter([
      $_POST['country'] ?? '',
      $_POST['state'] ?? '',
      $_POST['city'] ?? ''
    ]));
    $profile_data['birthday'] = $_POST['birthday'] ?? '';
    $profile_data['summary'] = $_POST['summary'] ?? '';
    $profile_data['website'] = $_POST['website'] ?? '';
    $profile_data['github'] = $_POST['github'] ?? '';
    $profile_data['linkedin'] = $_POST['linkedin'] ?? '';
    $profile_data['x_twitter'] = $_POST['x_twitter'] ?? '';
    $profile_data['work'] = $_POST['work'] ?? '';
    $profile_data['education'] = $_POST['education'] ?? '';
    $profile_data['technical_skills'] = $_POST['technical_skills'] ?? '';
    $username = $_POST['execode_id'] ?? $profile_data['username'];
    $email = $_POST['email'] ?? $profile_data['email'];

    // Validate required fields
    if (empty($profile_data['name']) || empty($email) || empty($username)) {
      $message = '<div class="alert alert-warning">Name, ExeCode ID, and Email are required</div>';
    } else {
      $conn->begin_transaction();
      try {
        if (updateProfileInfo($conn, $user_id, $profile_data) && updateUserInfo($conn, $user_id, $username, $email)) {
          $conn->commit();
          $message = '<div class="alert alert-success">Profile updated successfully</div>';
          $profile_info = fetchProfileInfo($conn, $user_id);
          $user_info = fetchUserInfo($conn, $user_id);
          $profile_data = array_merge($profile_data, $profile_info);
          $profile_data['username'] = $user_info['username'];
          $profile_data['email'] = $user_info['email'];
        } else {
          $conn->rollback();
          $message = '<div class="alert alert-danger">Failed to update profile</div>';
        }
      } catch (Exception $e) {
        $conn->rollback();
        $message = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
      }
    }
  } elseif ($action === 'update_password') {
    $prev_password = $_POST['prevPassword'] ?? '';
    $new_password = $_POST['newPassword'] ?? '';
    $confirm_password = $_POST['confirmPassword'] ?? '';

    $query = "SELECT password FROM users_info WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($prev_password, $user['password'])) {
      $message = '<div class="alert alert-warning">Previous password is incorrect</div>';
    } elseif (empty($new_password) || $new_password !== $confirm_password) {
      $message = '<div class="alert alert-warning">New passwords do not match or are empty</div>';
    } elseif (strlen($new_password) < 8) {
      $message = '<div class="alert alert-warning">New password must be at least 8 characters long</div>';
    } else {
      if (updatePassword($conn, $user_id, $new_password)) {
        $message = '<div class="alert alert-success">Password updated successfully</div>';
      } else {
        $message = '<div class="alert alert-danger">Failed to update password</div>';
      }
    }
  } elseif ($action === 'delete_account') {
    $conn->begin_transaction();
    try {
      if (deleteAccount($conn, $user_id)) {
        $conn->commit();
        session_destroy();
        header('Location: login.php');
        exit;
      } else {
        $conn->rollback();
        $message = '<div class="alert alert-danger">Failed to delete account</div>';
      }
    } catch (Exception $e) {
      $conn->rollback();
      $message = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
  } elseif ($action === 'update_account') {
    $username = $_POST['execode_id'] ?? '';
    $email = $_POST['email'] ?? '';

    // Validate required fields
    if (empty($username) || empty($email)) {
      $message = '<div class="alert alert-warning">ExeCode ID and Email are required</div>';
    } else {
      if (updateUserInfo($conn, $user_id, $username, $email)) {
        $message = '<div class="alert alert-success">Account information updated successfully</div>';
        $profile_data['username'] = $username;
        $profile_data['email'] = $email;
      } else {
        $message = '<div class="alert alert-danger">Failed to update account information</div>';
      }
    }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profile</title>
  <link rel="stylesheet" href="editprofile.css" />
  <link rel="stylesheet" href="../Include/Navbar.css" />
</head>

<body>
  <?php include('../Include/Navbar.php'); ?>
  <div class="container-editprofile">
    <div class="sidebar">
      <h3>Profile</h3>
      <a id="basicInfoTab" class="active" onclick="showSection('basicInfo')">Basic Info</a>
      <a id="accountSettingsTab" onclick="showSection('accountSettings')">Account</a>
      <div class="theme-switch">
        <!-- <label>
          <input type="checkbox" id="themeToggle" /> Dark Mode
        </label> -->
      </div>
    </div>

    <div class="main">
      <?php echo $message; ?>
      <div class="profile-header">
        <div class="profile-pic-container">
          <img id="profileImage" src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Profile" class="profile-pic" />
          <div class="profile-pic-overlay" onclick="openModal()">
            <span>Edit</span>
          </div>
        </div>
        <div class="profile-details">
          <h2><?php echo htmlspecialchars($profile_data['username']); ?></h2>
          <p id="exeCodeId">ExeCode ID: <?php echo htmlspecialchars($user_id); ?></p>
        </div>
        <div class="stats-container">
          <div class="progressCircularBarContainer">
            <div class="progressCircularBar" id="dirrerentIDForEachCircle" data-status="Solved" data-problem-solved="<?php echo htmlspecialchars($solved_info['solved_count']); ?>" data-total-problem="<?php echo htmlspecialchars($solved_info['total_problems']); ?>" data-percent="<?php echo htmlspecialchars($solved_info['percentage']); ?>" data-size="120" data-line="10"></div>
          </div>
          <div class="progress-bars">
            <div class="progress-bar">
              <span>Easy:</span>
              <div class="progress">
                <div class="progress-fill" id="progressFillEasy" data-percent="<?php echo htmlspecialchars($difficulty_info['EasyPercent']); ?>"></div>
              </div>
            </div>
            <div class="progress-bar">
              <span>Medium:</span>
              <div class="progress">
                <div class="progress-fill" id="progressFillMedium" data-percent="<?php echo htmlspecialchars($difficulty_info['MediumPercent']); ?>"></div>
              </div>
            </div>
            <div class="progress-bar">
              <span>Hard:</span>
              <div class="progress">
                <div class="progress-fill" id="progressFillHard" data-percent="<?php echo htmlspecialchars($difficulty_info['HardPercent']); ?>"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="profilePicModal" class="modal">
        <div class="modal-content">
          <span class="close-btn" onclick="closeModal()">×</span>
          <h3>Upload a New Avatar</h3>
          <div class="preview-container">
            <div class="preview-image-wrapper">
              <img id="previewImage" src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" alt="Preview" class="preview-image" />
            </div>
            <button class="reset-btn" onclick="resetImage()">Reset</button>
          </div>
          <div class="controls-container">
            <button class="rotate-btn" onclick="rotateImage('counterclockwise')">↺</button>
            <div class="zoom-container">
              <input type="range" id="zoomSlider" min="0.1" max="2" step="0.01" value="0.1" oninput="zoomImage(this.value)" />
            </div>
            <button class="rotate-btn" onclick="rotateImage('clockwise')">↻</button>
          </div>
          <input type="file" id="uploadInput" accept="image/*" class="file-input" onchange="previewNewImage()" />
          <div class="modal-actions">
            <button class="save-btn" onclick="saveImage()">Save</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
          </div>
        </div>
      </div>

      <div class="profile-box" id="basicInfo" style="display: block;">
        <h3>Basic Info</h3>
        <form method="POST">
          <input type="hidden" name="action" value="update_profile">
          <!-- add execCodeId as hidden input -->
          <input type="hidden" name="execode_id" value="<?php echo htmlspecialchars($profile_data['username']); ?>">
          <div class="profile-info">
            <div class="info-item">
              <label>Name</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['name'] ?: $profile_data['username']); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="text" name="name" value="<?php echo htmlspecialchars($profile_data['name'] ?: $profile_data['username']); ?>" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn" onclick="saveField(this, validateNotEmpty)">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Gender</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['gender']); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <select name="gender">
                  <option value="Not provided" <?php echo $profile_data['gender'] === 'Not provided' ? 'selected' : ''; ?>>Select...</option>
                  <option value="Male" <?php echo $profile_data['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" <?php echo $profile_data['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                  <option value="Other" <?php echo $profile_data['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Location</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['location'] ?: 'Your location'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <div class="location-group">
                  <select name="country">
                    <option value="">Country/Region</option>
                    <option value="USA" <?php echo strpos($profile_data['location'], 'USA') !== false ? 'selected' : ''; ?>>USA</option>
                    <option value="Canada" <?php echo strpos($profile_data['location'], 'Canada') !== false ? 'selected' : ''; ?>>Canada</option>
                    <option value="Bangladesh" <?php echo strpos($profile_data['location'], 'Bangladesh') !== false ? 'selected' : ''; ?>>Bangladesh</option>

                  </select>
                  <select name="state">
                    <option value="">State/Province</option>
                    <option value="California" <?php echo strpos($profile_data['location'], 'California') !== false ? 'selected' : ''; ?>>California</option>
                    <option value="Ontario" <?php echo strpos($profile_data['location'], 'Ontario') !== false ? 'selected' : ''; ?>>Ontario</option>
                    <option value="Dhaka" <?php echo strpos($profile_data['location'], 'Dhaka') !== false ? 'selected' : ''; ?>>Dhaka</option>

                  </select>
                  <select name="city">
                    <option value="">City/Town</option>
                    <option value="Los Angeles" <?php echo strpos($profile_data['location'], 'Los Angeles') !== false ? 'selected' : ''; ?>>Los Angeles</option>
                    <option value="Toronto" <?php echo strpos($profile_data['location'], 'Toronto') !== false ? 'selected' : ''; ?>>Toronto</option>
                    <option value="Dhaka" <?php echo strpos($profile_data['location'], 'Dhaka') !== false ? 'selected' : ''; ?>>Dhaka</option>

                  </select>
                </div>
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Birthday</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['birthday'] ?: 'Your birthday'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="date" name="birthday" value="<?php echo htmlspecialchars($profile_data['birthday']); ?>" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item" style="width: 100%;">
              <label>Summary</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['summary'] ?: 'Tell us about yourself...'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <textarea name="summary"><?php echo htmlspecialchars($profile_data['summary'] ?: 'Tell us about yourself...'); ?></textarea>
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Website</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['website'] ?: 'Your blog, portfolio, etc.'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="url" name="website" value="<?php echo htmlspecialchars($profile_data['website'] ?: ''); ?>" placeholder="Your blog, portfolio, etc." />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Github</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['github'] ?: 'Your Github URL'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="url" name="github" value="<?php echo htmlspecialchars($profile_data['github'] ?: ''); ?>" placeholder="Your Github URL" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>LinkedIn</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['linkedin'] ?: 'Your LinkedIn URL'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="url" name="linkedin" value="<?php echo htmlspecialchars($profile_data['linkedin'] ?: ''); ?>" placeholder="Your LinkedIn URL" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>X (Twitter)</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['x_twitter'] ?: 'Your X (Twitter) URL'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="url" name="x_twitter" value="<?php echo htmlspecialchars($profile_data['x_twitter'] ?: ''); ?>" placeholder="Your X (Twitter) URL" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Work</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['work'] ?: 'Add a workplace'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="text" name="work" value="<?php echo htmlspecialchars($profile_data['work'] ?: ''); ?>" placeholder="Add a workplace" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item">
              <label>Education</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['education'] ?: 'Add a school'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <input type="text" name="education" value="<?php echo htmlspecialchars($profile_data['education'] ?: ''); ?>" placeholder="Add a school" />
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
            <div class="info-item" style="width: 100%;">
              <label>Technical Skills</label>
              <span class="value"><?php echo htmlspecialchars($profile_data['technical_skills'] ?: 'List your technical skills...'); ?></span>
              <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
              <span class="edit-mode">
                <textarea name="technical_skills"><?php echo htmlspecialchars($profile_data['technical_skills'] ?: 'List your technical skills...'); ?></textarea>
                <div class="edit-actions">
                  <button type="submit" class="save-btn">Save</button>
                  <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                </div>
              </span>
            </div>
          </div>
        </form>
      </div>

      <div class="account-settings" id="accountSettings" style="display: none;">
        <h3>Account Information</h3>
        <form method="POST">
          <input type="hidden" name="action" value="update_account">
          <div class="info-row">
            <label>ExeCode ID</label>
            <div class="value-wrapper">
              <span class="value"><?php echo htmlspecialchars($profile_data['username']); ?></span>
            </div>
            <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
            <div class="edit-mode">
              <input type="text" id="execode_id" name="execode_id" value="<?php echo htmlspecialchars($profile_data['username']); ?>" />
              <div class="edit-actions">
                <button type="submit" class="save-btn">Save</button>
                <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
              </div>
            </div>
          </div>
          <div class="info-row">
            <label>Email</label>
            <div class="value-wrapper">
              <span class="value"><?php echo htmlspecialchars($profile_data['email']); ?></span>
            </div>
            <span class="edit-btn" onclick="toggleEdit(this)">Edit</span>
            <div class="edit-mode">
              <input type="email" name="email" value="<?php echo htmlspecialchars($profile_data['email']); ?>" />
              <div class="edit-actions">
                <button type="submit" class="save-btn">Save</button>
                <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
              </div>
            </div>
          </div>
        </form>
        <form method="POST">
          <input type="hidden" name="action" value="update_password">
          <div class="info-row">
            <label>Password</label>
            <div class="value-wrapper">
              <span class="value">Change Password</span>
            </div>
            <span class="edit-btn" onclick="togglePasswordEdit()">Edit</span>
          </div>
          <div class="password-edit" style="display: none;">
            <div class="info-row">
              <label>Previous Password</label>
              <input type="password" name="prevPassword" id="prevPassword" placeholder="Enter previous password" />
            </div>
            <div class="info-row">
              <label>New Password</label>
              <input type="password" name="newPassword" id="newPassword" placeholder="Enter new password" />
            </div>
            <div class="info-row">
              <label>Confirm Password</label>
              <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm new password" />
            </div>
            <div class="edit-actions">
              <button type="submit" class="save-btn">Change Password</button>
              <button type="button" class="cancel-btn" onclick="cancelPasswordEdit()">Cancel</button>
            </div>
          </div>
        </form>
        <form method="POST">
          <input type="hidden" name="action" value="delete_account">
          <button type="submit" class="delete-btn">Delete Account</button>
        </form>
      </div>
    </div>
  </div>
  <script src="editprofile.js"></script>
  <script src="editprofile-progress.js"></script>
</body>

</html>