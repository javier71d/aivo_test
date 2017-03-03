aivo_test

Configuration:

Provide youre credentials for Facebook Graph API: 
File: /public/index.php 
$FB_APP_ID = "YOUR APP ID";
$FB_APP_SECRET = 'YOUR APP SECRET';
$FB_TOKEN = "VALID ACCESS TOKEN";

Server Configuration:

PHP Built-in web server: 
In the teminal go to public directory of the API. 
(Example: cd /path/to/the/api/public) 
Run the command php -S localhost:8000 
Now in the browser type http://localhost:8000/profile/facebook/[Facebook ID]

For Apache or NGINX just configure you host and type the url in the browser (http;//YOUR_HOST/profile/facebook/[Facebook ID])