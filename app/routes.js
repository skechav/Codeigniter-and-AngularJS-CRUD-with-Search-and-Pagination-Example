var app =  angular.module('main-App',['ngRoute']);

app.config(['$routeProvider','$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider.
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
    $locationProvider.html5Mode(true);
}]);
