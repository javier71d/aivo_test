<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';


// Define app routes
$app->get('/profile/facebook/{id}', function ($request, $response, $args) {

	if(is_numeric($args['id'])){

		$FB_APP_ID = "YOUR APP ID";
		$FB_APP_SECRET = 'YOUR APP SECRET';
		$FB_TOKEN = "VALID ACCESS TOKEN";

		define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__.'/vendor/facebook/graph-sdk/src/Facebook');
		require_once(__DIR__.'/vendor/autoload.php');

		$fb = new Facebook\Facebook([
				'app_id' => $FB_APP_ID,
				'app_secret' => $FB_APP_SECRET,
				'default_graph_version' => 'v2.8',
			]);

		try {
	  		
	  		$fbresponse = $fb->get('/' . $args['id'] .'?fields=name,first_name,last_name,picture,email,link,location,age_range', $FB_TOKEN);

		} catch(\Facebook\Exceptions\FacebookResponseException $e) {

	  		$result['errors'][] = $e->getMessage();

		} catch(\Facebook\Exceptions\FacebookSDKException $e) {

	  		$result['errors'][] = $e->getMessage();

		}

		if(!$result['errors']){

			$user = $fbresponse->getGraphUser();

			$result = array(
				'id' => $user->getId(),
				'firstName' => $user->getFirstName(),
				'lastName' => $user->getLastName(),
				'name' => $user->getName(),
				'email' => $user->getEmail()
			);

		}

	} else {

		$result['errors'][] = "Facebook ID must be a number";

	}

    return $response->write(json_encode($result));

});

// Run app
$app->run();
