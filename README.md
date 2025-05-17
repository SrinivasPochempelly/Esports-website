# Esports-website
This is a dynamic web platform built for managing and organizing esports tournaments at Osmania University. 
The system allows both players and organizers to interact seamlessly through dedicated interfaces. 
Players can register, log in, and join tournaments, while organizers can create and manage their own tournaments.

#Website overview
🔧 Tech Stack
Frontend: HTML, CSS, JavaScript, AJAX
Backend: PHP & MySQL
Design Theme: A vibrant palette of purple, blue, pink, and violet to reflect a gaming-centric experience.

🌟 Key Features
Home Page: Displays upcoming tournaments. Registration is restricted to logged-in players.
Player Registration/Login: Secure player authentication and onboarding.
My Tournaments: Personalized dashboard showing a player's registered tournaments, split into:
Upcoming
Ongoing
Completed
Tournament Registration: Collects player’s in-game credentials and fee confirmation.
Organizer Dashboard: Post-login access to add, edit, and view tournaments created by the organizer.

🔐 Access Control
Organizer and player flows are separated via interface logic (no role-based DB field).
Only authenticated users can access respective features.

**IMPORTANT
There will be a sql file in this project. Import that sql file into database server to create a database and tables with 
initail values
and THE ENTRY POINT OF THIS PROJECT WILL BE index.php

Organizer login : 
name : einstein
email : einsteinellandala@gmail.com
password : 89

player login:
name : srinivas
eamil : srinivaspochempelly@gmail.com
password : sri123
