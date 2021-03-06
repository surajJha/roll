'use strict';

/**
 * @ngdoc overview
 * @name rollApp
 * @description
 * # rollApp
 *
 * Main module of the application.
 */
angular
  .module('rollApp', [
        //'ngAnimate',
        'ngCookies',
        'ngResource',
        'ngRoute',
        'ngSanitize',
        'ngTouch',
        'ui.router',
        'ui.utils',
        'ui.map',
        'ui.bootstrap',
        'angucomplete-alt',
        'infinite-scroll'
  ])
  .config(function ($stateProvider, $urlRouterProvider, $sceDelegateProvider) {
       // $sceDelegateProvider.resourceUrlWhitelist(['http://www.rollingscenes.com', 'self']);
        // For any unmatched url, send to /route1
        $urlRouterProvider.otherwise("/home")
        $stateProvider .state('home', {
            url:'/home',
            templateUrl:'views/home.html',
            controller : 'homeController'
        }).state('events', {
            url: '/events',
            //url:'/events?type?query',
            params:{'type': null, 'query':null, 'event_detail_id':null, 'event_name': null},
            templateUrl:'views/searchResultByEventName.html',
            controller : 'eventSearchController'
        }).state('event', {
            url:'/event?event_name',
            params: {formData: null, id: null},
            templateUrl:'views/event_details.html',
            controller : 'EventDetailsController'
        }).state('category', {
            url:'/category?category',
            //url:'/events?type?query',
           // params:{'category': null},
            templateUrl:'views/searchResultByCategory.html',
            controller : 'categorySearchController'
        })


  }).run(function($rootScope){
        /**
         * base URL  points to the server where PHP interpreter
         * is present. PORT 80 used by apache has the interpreter
         * port 9000 used by the grunt server cannot run PHP
         * @type {string}
         */
     //   $rootScope.baseUrl = 'http://localhost:80/roll'
       $rootScope.baseUrl = 'http://www.rollingscenes.com';

    })
