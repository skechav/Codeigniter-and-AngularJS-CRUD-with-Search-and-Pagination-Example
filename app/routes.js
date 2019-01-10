var app =  angular.module('main-App',['ngRoute','angularUtils.directives.dirPagination']);
app.config( ['$routeProvider', '$locationProvider', function( $routeProvider, $locationProvider ) 
                                                    {
                                                        $routeProvider.
                                                            when('/', { 
                                                                templateUrl: 'templates/home.html', 
                                                                controller: 'AdminController' } ).
                                                            when('/items', { 
                                                                templateUrl: 'templates/items.html', 
                                                                controller: 'ItemController'           } );
                                                        
                                                        // use the HTML5 History API - remove # from url
                                                        $locationProvider.html5mode({ enabled: true, requireBase: false });
                                                    }
            ]

);
