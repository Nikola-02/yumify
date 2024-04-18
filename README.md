# Yumify

# HOW TO RUN APP
1. Make database yumify in your local
2. Start MySQL service
3. Run this command in terminal of project: composer install
4. Delete public/storage folder and than run this command: php artisan storage:link
5. Run migration for creating and populating tables in database with this command: php artisan migrate:fresh --seed
6. Run project in your local with command: # php artisan serve

# APP DESCRIPTION

Laravel application for ordering food.

Focus on this application is on working with database and Eloquent, with models, controllers and views (blades). Here can be found filtering, sorting and pagination for data on many places in the app.

You can register and login after that, so everything in the app will be saved for you in database.

You can search restaurants, in every restaurant you can search, filter, sort meals. 

When you pick some meals, you can add it to cart and order it, after that, your order will go to order history.
