Social-network is my ongoing project that aims to create a social networking platform where users can connect, share updates, and interact with each other. While the project is still under development, several features have been implemented to provide insight into its functionality.

Key features:
Create a profile:
Users can create their profiles by providing personal information and uploading profile pictures.

Friends:
Friend management allows users to add and manage their friends list.

Publishing updates:
Users can create and share posts with their friends.

Comments and likes:
Users can comment on posts, like comments, and like posts.
It is possible to reply to individual comments.

Notifications:
A notification system for notifying users of friend requests (sent, accepted, or rejected). Also notifications for incoming new messages

Message:
Users can send messages to their friends, delete and update. Also, we can see if the message has been read or not.

Technologies used:

Backend:
Laravel PHP framework

Front end:
HTML, CSS, Bootstrap 5, JavaScript, jQuery

Database:
MySQL

Directory Structure

1.Interfaces
Directory: app/Interfaces

This directory contains PHP interfaces that define which methods should be implemented.

2. Repositories
Directory: app/Repositories

This is where the repository implementations reside. Repositories are used to communicate with the database and execute queries. Each repository has its own interface.

3. Services
Directory: app/Services

Services contain the business logic of the application. They use repositories to access data and interact with controllers.

4. Controllers
Directory: app/Http/Controllers

Controllers handle HTTP requests, using services and repositories to retrieve and store data. Controllers are responsible for communicating with the user interface.


How to Run:
Clone the repository:  git clone https://github.com/nikolajelicic/Social-network

Install dependencies: composer install

Migrate the database: php artisan migrate

Run the development server: php artisan serve

Visit http://localhost:8000 in your web browser.

Author
Nikola Jelicic
