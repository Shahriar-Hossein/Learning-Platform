# Learning Platform

## Overview
This is a feature-rich Learning Platform developed using raw PHP, HTML, TailwindCSS, JavaScript, and MySQL. The platform provides role-based access for admins, teachers, and students, allowing seamless course creation, management, and learning experiences.

## Technologies Used
- **Backend:** PHP (Raw, No Framework)
- **Frontend:** HTML, TailwindCSS, JavaScript
- **Database:** MySQL
- **Server Environment:** Laragon (Windows Development)
- **Payment Gateway:** SSLCommerz

## Features
### User Roles
1. **Admin:**
   - Oversees all users, courses, and lessons.
   - Can delete any entity (users, courses, lessons, quizzes, feedbacks).
   - Cannot edit any content.

2. **Teacher:**
   - Can create and manage courses.
   - Can create lessons and quizzes for courses.
   - Can review and assess quiz submissions from students.

3. **Student:**
   - Can browse and enroll in courses after purchasing.
   - Payments are handled securely via SSLCommerz.
   - Can view course lessons after purchase.
   - Can submit quizzes for evaluation.
   - Can give feedback on individual courses and the overall platform.

## Installation and Setup
### Prerequisites
- Laragon installed on Windows
- PHP and MySQL configured in Laragon
- SSLCommerz account for payment integration

### Steps to Install
1. Clone the repository or download the project files.
2. Place the project folder inside `www` directory of Laragon.
3. Start Laragon and navigate to the project URL.
4. Import the provided database file into MySQL.
5. Update database credentials in the `config.php` file.
6. Set up SSLCommerz API credentials for payment integration.
7. Access the platform and log in as Admin, Teacher, or Student.

## Usage
- **Admin Panel:** Manage users, courses, and lessons.
- **Teacher Dashboard:** Create and manage courses, lessons, and quizzes.
- **Student Dashboard:** Enroll in courses, access lessons, submit quizzes, and provide feedback.

## Future Enhancements
- Implementing role-based editing permissions.
- Adding more functionalities to the admin role.
- Enhancing quiz evaluation with automatic grading.
- Adding live class functionality.
- Improving UI/UX with more interactive elements.

## License
This project is licensed under the MIT License.

## Contact
For any queries, please contact the developer.

