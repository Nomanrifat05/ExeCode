# ExeCode - Where Code Meets Challenge

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

## 📖 Overview

ExeCode is a comprehensive online competitive programming platform that provides a complete ecosystem for coding enthusiasts, students, and professionals to practice, compete, and improve their programming skills. The platform features an integrated development environment (IDE), contest management system, problem sets, user rankings, and a social community aspect.

## ✨ Features

### 🏠 **Home Dashboard**
- **Announcements & Posts**: Community posts with images and text
- **Upcoming Contests**: Real-time countdown timers for upcoming competitions
- **Top Rankings**: Live leaderboard showing top performers
- **User Profiles**: Detailed user statistics and achievements

### 🏆 **Contest System**
- **Weekly Contests**: Regularly scheduled programming competitions
- **Real-time Registration**: Easy contest registration/unregistration
- **Contest Categories**: Upcoming, Ongoing, and Past contests
- **Automatic Status Updates**: Contest status changes based on time
- **Trophy System**: Visual rewards and achievements

### 💻 **Integrated Development Environment (IDE)**
- **Monaco Editor**: Professional-grade code editor with syntax highlighting
- **Multiple Language Support**: JavaScript, PHP, Python, C++, Java, and more
- **Dark Theme**: Modern dark theme for comfortable coding
- **Real-time Code Execution**: Compile and run code directly in the browser

### 📚 **Practice Problems**
- **Problem Sets**: Curated collection of programming challenges
- **Difficulty Levels**: Easy, Medium, and Hard problems
- **Acceptance Tracking**: Monitor your problem-solving progress
- **Solution Submissions**: Submit and track your solutions

### 👥 **User Management**
- **User Registration & Login**: Secure authentication system
- **Profile Management**: Edit personal information and preferences
- **Password Recovery**: Forgot password functionality
- **User Rankings**: Global and contest-specific leaderboards

### 🎯 **Problem Management**
- **Problem Creation**: Admin tools to create new programming challenges
- **Test Cases**: Comprehensive testing framework
- **Submission Tracking**: Monitor user submissions and results
- **Performance Analytics**: Detailed statistics and insights

### 🏅 **Ranking System**
- **Global Rankings**: Overall platform leaderboard
- **Contest Rankings**: Individual contest results
- **Country-based Rankings**: Geographic leaderboards
- **Score Calculation**: Points based on problem difficulty and submission time

## 🛠️ Technology Stack

- **Backend**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript
- **Code Editor**: Monaco Editor (VS Code's web editor)
- **Server**: Apache/Nginx with XAMPP support
- **Styling**: Custom CSS with modern design principles

## 📋 Prerequisites

Before running ExeCode, make sure you have the following installed:

- **XAMPP** (or similar local server stack)
- **PHP 8.2** or higher
- **MySQL 8.0** or higher
- **Apache/Nginx** web server
- **Modern web browser** (Chrome, Firefox, Safari, Edge)

## 🚀 Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/ExeCode.git
cd ExeCode
```

### Step 2: Set Up XAMPP
1. Download and install [XAMPP](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Place the ExeCode folder in your `htdocs` directory

### Step 3: Database Setup
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `execode`
3. Import the database schema:
   ```bash
   # Import the latest database file
   phpMyAdmin > Import > Select execode.sql from Database/ folder
   ```

### Step 4: Configure Database Connection
1. Open `Include/Connection.php`
2. Update database credentials if needed:
   ```php
   $host = "localhost";
   $dbname = "execode";
   $dbuser = "root";
   $dbpass = "";
   ```

### Step 5: Access the Application
1. Open your web browser
2. Navigate to `http://localhost/ExeCode/Home/Home.php`
3. Register a new account or use the default admin credentials

## 📁 Project Structure

```
ExeCode/
├── Admin/                 # Admin panel and management tools
│   ├── admin.php         # Main admin dashboard
│   ├── create_contest.php # Contest creation interface
│   ├── createProblem.php # Problem creation tools
│   └── announcement.php  # Announcement management
├── contest/              # Contest system
│   ├── contest.php       # Main contest page
│   ├── contest.js        # Contest functionality
│   └── contest.css       # Contest styling
├── IDE/                  # Integrated Development Environment
│   ├── ide.html         # Monaco editor interface
│   ├── script.js        # IDE functionality
│   └── styles.css       # IDE styling
├── PracticsProblem/      # Practice problems
│   ├── practiceproblem.php # Problem listing
│   ├── problem.php      # Individual problem view
│   └── problem.css      # Problem styling
├── User/                 # User authentication
│   ├── Login.php        # User login
│   ├── Signup.php       # User registration
│   └── Forget.php       # Password recovery
├── Include/              # Shared components
│   ├── Connection.php   # Database connection
│   └── Navbar.php       # Navigation component
├── Database/            # Database schemas and migrations
└── README.md           # This file
```

## 🎮 Usage

### For Users
1. **Registration**: Create an account at the signup page
2. **Practice**: Solve problems in the Practice Problems section
3. **Compete**: Register for upcoming contests
4. **Code**: Use the integrated IDE for coding
5. **Track Progress**: Monitor your rankings and achievements

### For Administrators
1. **Problem Management**: Create and manage programming problems
2. **Contest Management**: Schedule and manage contests
3. **User Management**: Monitor user activities and submissions
4. **Announcements**: Post community announcements and updates

## 🔧 Configuration

### Database Configuration
Edit `Include/Connection.php` to modify database settings:
```php
$host = "your_host";
$dbname = "your_database";
$dbuser = "your_username";
$dbpass = "your_password";
```

### Timezone Configuration
The application uses Asia/Dhaka timezone by default. To change:
```php
date_default_timezone_set('Your/Timezone');
```

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PHP PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Test thoroughly before submitting

## 🐛 Known Issues

- Monaco Editor requires internet connection for CDN resources
- Some advanced IDE features may not work in older browsers
- Contest timezone handling may need adjustment for different regions

## 🔮 Future Enhancements

- [ ] Real-time collaboration features
- [ ] Mobile app development
- [ ] Advanced code analysis tools
- [ ] Integration with external judges
- [ ] Social features (comments, likes, sharing)
- [ ] API for third-party integrations
- [ ] Advanced analytics and reporting

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Authors

- **Md Musfiqur Rahman** - *Core Development* - [@musfiqurR661](https://github.com/musfiqurR661)
- **Mahbubur Rahman** - *Core Development* - [@mahbub623a](https://github.com/mahbub623a)  
- **Noman Ahmed** - *Core Development* - [@Nomanrifat05](https://github.com/Nomanrifat05)

## 🙏 Acknowledgments

- **Monaco Editor** - For the excellent web-based code editor
- **XAMPP** - For the local development environment
- **PHP Community** - For the robust backend framework
- **MySQL** - For the reliable database system

## 📞 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/yourusername/ExeCode/issues) page
2. Create a new issue with detailed information
3. Contact the development team

---

**Happy Coding! 🚀**

*ExeCode - Where Code Meets Challenge*
