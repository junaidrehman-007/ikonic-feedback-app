1: How to clone github ap on your personal computer.
   Clone project from github to your personal computer.

2: How to install:

   Open project in your visual studio.
   
   Open terminal.
   
   In the terminal run this commands..
   
   cp .env.example .env.
   
   Composer Install. 
   
   php artisan key:generate.
   
   Php artisan migrate. 
   
   php artisan db:seed --class=RoleUserSeeder.
   
   php artisan db:seed --class=CommentsSeeder.
   
   php artisan db:seed --class=FeedbackSeeder.
   
   Php artisan serve.

3: About project:
   
   There are two panels (admin, users).
   
   In index page in the nav bar we have login and register.
   
   Login:
   
   Login page is for both admin and user.
   
   Register:
   
   On migrating the admin credentials are created by default.
   
   You can register the user on registration page.
   
   On the nav bar there are four pages (all feedback, Submit feedback, login, register).
   
   All feedback:
   
   We have all feedback submitted by the users.
   
   Users can vote down, up, comments.
   
   Only the authented users can vote and comment.
   
   Submit feedback:
   
   Only the authenticated users can submit there feedack with attachments.
   
4: Admin:

   Admin can access all the feedback list. He can edit, remove, change the status.
   
   When admin change the feedback status it notifys to that user.
   
