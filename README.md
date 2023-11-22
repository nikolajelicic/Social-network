Project Name
Social-network

Description
This is a social network made in laravel, it is currently under development.

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

Author
Nikola Jelicic