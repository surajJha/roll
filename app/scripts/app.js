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
        'ngAnimate',
        'ngCookies',
        'ngResource',
        'ngRoute',
        'ngSanitize',
        'ngTouch',
        'ui.router',
        'ui.utils',
        'ui.map',
        'ui.bootstrap',
        'angucomplete-alt'
  ])
  .config(function ($stateProvider, $urlRouterProvider) {
        // For any unmatched url, send to /route1
        $urlRouterProvider.otherwise("/home")
        $stateProvider .state('home', {
            url:'/home',
            templateUrl:'views/home.html',
            controller : 'homeController'
        }).state('categories', {
            url:'/categories',
            templateUrl:'views/searchResultByCategory.html',
            controller : 'categorySearchController'
        }).state('area', {
            url:'/area',
            templateUrl:'views/searchResultByArea.html',
            controller : 'areaSearchController'
        }).state('venue', {
            url:'/venue',
            templateUrl:'views/searchResultByVenue.html',
            controller : 'venueSearchController'
        }).state('events', {
            url:'/events',
            templateUrl:'views/searchResultByEventName.html',
            controller : 'eventSearchController'
        }).state('event', {
            url:'/event',
            templateUrl:'views/event_details.html',
            controller : 'EventDetailsController'
        })


  }).run(function($rootScope){
        /**
         * base URL  points to the server where PHP interpreter
         * is present. PORT 80 used by apache has the interpreter
         * port 9000 used by the grunt server cannot run PHP
         * @type {string}
         */
        $rootScope.baseUrl = 'http://localhost:80/roll'
    })
