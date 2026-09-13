School Lost and Found Management System
A web-based Lost and Found Management System developed to help schools efficiently manage lost and found items. The system provides students with a centralized platform to report, search, browse, and claim items, while administrators can manage users, review claims, update item statuses, and monitor activities through audit logs.
Project Overview
The School Lost and Found Management System was developed as a final-year project to address the challenges associated with manually managing lost and found items within a school environment. The system replaces an informal or paper-based process with a centralized web application where users can report items, provide supporting information and images, search available records, and submit claims.
The application also includes administrative controls for managing users and item records, verifying claims, updating item statuses, and maintaining an audit trail of important activities.
Objectives
The main objectives of the system are to:
•	Provide a centralized platform for reporting lost and found items.
•	Allow students to browse and search for reported items.
•	Allow users to upload images of lost or found items.
•	Provide a claim verification process to reduce fraudulent claims.
•	Allow administrators to approve or reject claims.
•	Provide role-based access to protect administrative functions.
•	Track item statuses throughout the recovery process.
•	Maintain audit logs for important system activities.
•	Improve accountability and organization in the school’s lost and found process.
Main Features
Student Features
•	Student registration and login
•	Role-based access
•	Report lost items
•	Report found items
•	Upload item photographs
•	Drag-and-drop image upload
•	Image preview before submission
•	Image file-type validation
•	Browse reported items
•	Search by item name and category
•	Filter by status
•	Filter by location
•	Filter by date
•	Submit item claims
•	Provide a security question and answer
•	Upload supporting proof
•	View item status
Administrator Features
•	Administrator login
•	Role-based administrator access
•	View system dashboard
•	Manage users
•	View reported items
•	Delete item records
•	Mark items as returned
•	Review claim requests
•	Approve claims
•	Reject claims
•	Prevent multiple approved claims for the same item
•	Update item status after claim approval
•	View audit logs
•	Search and filter audit logs
•	View QR codes associated with items
Claim Verification
The system includes a claim verification process designed to provide additional evidence before an item is released.
When submitting a claim, a student provides:
1.	A description or proof that the item belongs to them.
2.	A security question.
3.	A security answer.
4.	A supporting proof document or image.
The claim is then submitted to the administrator for review.
The administrator can:
•	Approve the claim.
•	Reject the claim.
•	Review the submitted information and proof.
•	Prevent another claim from being approved for an already claimed item.
When a claim is approved, the item’s status is updated to Claimed.
Item Status Tracking
Items move through different stages during their lifecycle.
The system supports the following statuses:
•	Lost — an item has been reported as lost.
•	Found — an item has been reported as found.
•	Claimed — an administrator has approved a claim for the item.
•	Returned — the item has been marked as returned.
Only administrators can perform restricted operations such as marking an item as returned or deleting an item.
Search and Filtering
The system provides search and filtering functionality to make it easier to locate records.
Users can search using:
•	Item name
•	Category
Additional filters include:
•	Status
•	Location
•	Date reported
A reset option is also available to return to the complete item list.
Image Upload
The system supports image uploads when reporting items.
The upload system includes:
•	Image file selection
•	Drag-and-drop upload
•	Image preview
•	Client-side image checking
•	Server-side MIME-type validation
•	Separate storage for uploaded item images
Item images are stored in the uploads/ directory.
Claim proof files are stored in the proofs/ directory.
QR Code Functionality
The system generates a QR code for each item record.
The QR code contains a URL associated with the item’s ID and can be used as part of the system’s item verification workflow.
The QR functionality provides a foundation for future improvements such as:
•	Item collection verification
•	QR scanning during item pickup
•	Linking physical items to their digital records
Audit Logging
The system includes an audit logging mechanism for recording important activities.
The logs table records information such as:
•	User ID
•	Action performed
•	Item ID
•	Date and time
Examples of recorded activities include:
•	Reporting an item
•	Approving a claim
•	Marking an item as returned
•	Deleting an item
The audit log provides accountability and allows administrators to monitor important activities performed within the system.
User Roles
Student
Students can:
•	Register
•	Log in
•	Report items
•	Upload item images
•	Browse items
•	Search and filter items
•	Submit claims
•	Provide claim verification information
Students cannot perform administrator-only operations.
Administrator
Administrators have additional privileges, including:
•	Managing users
•	Reviewing claims
•	Approving claims
•	Rejecting claims
•	Marking items as returned
•	Deleting item records
•	Viewing audit logs
Technology Stack
Technology	Purpose
HTML5	Page structure
CSS3	Interface styling
JavaScript	Client-side interactivity
Bootstrap	Responsive user interface
PHP	Server-side programming
MySQL	Database management
Laragon	Local development environment
InfinityFree	Online hosting
Database Structure
The application uses MySQL as its database management system.
users
Stores registered users and their roles.
Important fields include:
•	id
•	full_name
•	email
•	password
•	role
•	created_at
items
Stores information about reported lost and found items.
Important fields include:
•	id
•	item_name
•	description
•	category
•	location
•	status
•	reported_by
•	image
•	created_at
claims
Stores claim requests submitted by users.
The table contains information relating to:
•	Item
•	Claiming user
•	Proof/description
•	Security question
•	Security answer
•	Proof file
•	Claim status
•	Date and time
logs
Stores audit records.
Important fields include:
•	id
•	user_id
•	action
•	item_id
•	created_at
Project Structure
school-lost-found/
│
├── config/
│   └── db.php
│
├── uploads/
│   └── item images
│
├── proofs/
│   └── claim proof files
│
├── login.php
├── register.php
├── logout.php
├── dashboard.php
├── browse.php
├── claim_item.php
│
├── admin.php
├── admin_claims.php
├── admin_users.php
│
├── approve_claim.php
├── reject_claim.php
├── mark_returned.php
├── delete_item.php
│
├── logs.php
├── qr-related files
└── other system files
Local Installation
Requirements
Before running the project locally, install:
•	Laragon
•	PHP
•	MySQL
•	A modern web browser
Installation Steps
1.	Install Laragon.
2.	Start Apache and MySQL.
3.	Place the project folder inside:
C:\laragon\www\
4.	Create a MySQL database named:
school_lost_found
5.	Import the required database tables.
6.	Open:
config/db.php
7.	Configure the local database connection.
Example:
<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "school_lost_found";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
8.	Start Apache and MySQL through Laragon.
9.	Open the application in the browser:
http://localhost/school-lost-found/
Online Deployment
The application was also deployed using InfinityFree for online accessibility.
For online deployment:
1.	Create an InfinityFree hosting account.
2.	Create the MySQL database.
3.	Import the project database through phpMyAdmin.
4.	Upload the project files to the hosting account’s htdocs directory.
5.	Update config/db.php with the hosting database credentials.
6.	Create the required uploads and proofs directories.
7.	Test the application through the assigned domain.
The local database connection and online database connection use different credentials and host information.
Security Measures
The system implements several security-related measures, including:
•	Session-based authentication
•	Role-based access control
•	Administrator-only operations
•	Server-side image MIME-type validation
•	Restricted claim approval
•	Prevention of multiple approved claims for the same item
•	Audit logging
•	Separate storage directories for images and claim proof files
For production deployment, additional security improvements such as prepared SQL statements, stronger password hashing, CSRF protection, secure file renaming, and stricter upload restrictions are recommended.
Testing
The major system functions were tested during development and deployment.
Tested functionality includes:
•	User registration
•	User login
•	Administrator login
•	Role-based access
•	Item reporting
•	Image upload
•	Image preview
•	Drag-and-drop upload
•	Search
•	Category filtering
•	Status filtering
•	Location filtering
•	Date filtering
•	Claim submission
•	Security question and answer
•	Proof upload
•	Claim approval
•	Claim rejection
•	Item status updates
•	User management
•	Item deletion
•	Audit logging
•	QR code generation
•	Online database connection
Future Improvements
The system can be further enhanced with:
•	AI-based image matching
•	Image similarity detection using an external image-recognition API
•	Fully automated email notification services
•	QR scanning during item collection
•	Mobile application integration
•	More advanced analytics and reporting
•	Stronger file security
•	Password reset functionality
•	More comprehensive notification management
The proposed image-recognition functionality was considered as an optional enhancement but was not included as a completed core feature of the current implementation.
Project Status
Current Status: Completed prototype / final-year project implementation
The core Lost and Found workflow has been implemented, including authentication, item reporting, image handling, searching and filtering, claim verification, administrator management, status tracking, audit logging, QR functionality, and online deployment.
Author
School Lost and Found Management System
Final-Year Project
Developed using PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap.
License
This project was developed as an academic final-year project. The project may be used for educational and demonstration purposes. For production use, additional security hardening and deployment configuration are recommended.
