var app =  angular.module( 'main-App', ['ngRoute'] );

app.config(['$routeProvider',
    function($routeProvider) 
    {
        $routeProvider
            when('/', {
                templateUrl: 'templates/home.html',
                controller: 'HomeController'
            }).
            when('/users', {
                templateUrl: 'templates/users.html',
                controller: 'UserController'
            }).
              otherwise({
                redirectTo: '/'
            });

	    // use the HTML5 History API
	    //$locationProvider.html5mode({ enabled: true, requireBase: false });
	}

]);
