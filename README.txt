SCHOOL LOST AND FOUND MANAGEMENT SYSTEM
README
1. Project Overview
The School Lost and Found Management System is a web-based application developed to help students and school administrators manage lost and found items efficiently. Students can report items, upload images, browse and filter records, and submit claims with supporting proof. Administrators can manage users, review claims, approve or reject requests, update item statuses, delete records, and monitor activities through audit logs.
2. Main Features
• Student and administrator login
• Role-based access control
• Report lost or found items
• Image upload with validation, drag-and-drop, and preview
• Browse, search, and filter items by category, status, location, and date
• Claim submission with security question and proof upload
• Admin claim approval or rejection
• Lost, Found, Claimed, and Returned status tracking
• Admin-only deletion and return-status updates
• User management
• Audit logging
• QR code generation
• Email notification functionality
3. Technology Stack
Frontend: HTML5, CSS3, JavaScript, Bootstrap
Backend: PHP
Database: MySQL
Local development: Laragon
Hosting: InfinityFree
File storage: local upload folders
QR code: JavaScript QR code library
4. Database
The system uses MySQL. The main tables are users for accounts and roles, items for lost and found records, claims for claim requests, and logs for important system activities.
5. User Roles
Student: Can log in, report items, upload images, browse and search records, filter items, and submit claims with supporting information and proof.

Administrator: Can manage users, review claims, approve or reject claims, mark items as returned, delete item records, and view audit logs.
6. Important Project Files
config/ - database connection
uploads/ - uploaded item images
proofs/ - claim proof files
login.php - login
register.php - registration
dashboard.php - dashboard
browse.php - browsing and filtering
claim_item.php - claim submission
admin.php - administrator panel
admin_claims.php - claim management
approve_claim.php - claim approval
reject_claim.php - claim rejection
mark_returned.php - return status
 delete_item.php - administrator item deletion
7. Local Setup
Install Laragon with PHP and MySQL. Place the project in the Laragon www directory, create the school_lost_found database, import the required tables, and update config/db.php with the local database credentials. Start Apache and MySQL and open the application through the local server.
8. Online Deployment
The application was deployed to InfinityFree. The hosting database uses the MySQL hostname, username, password, and database name provided by the hosting account. Project files are uploaded to htdocs and the database is imported through phpMyAdmin.
9. Security
The system uses session-based authentication and role-based access control. Image uploads are validated to accept image files, while administrative operations such as deleting items, approving claims, and marking items as returned are restricted to administrators. Audit logs provide accountability for important activities.
10. Testing
The system was tested during local development and after deployment. Functions tested include registration, login, role access, item reporting, image upload and preview, search and filtering, claim submission, proof upload, claim approval and rejection, status updates, user management, audit logging, and QR code generation.
11. Future Improvements
Future improvements may include integrating a dedicated image-recognition API for automatic similarity matching, improving production email delivery, and expanding QR-code workflows for item collection and verification.
