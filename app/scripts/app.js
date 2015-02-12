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
        $stateProvider .state('main', {
            url:'/main',
            templateUrl:'views/main.html',
            controller : 'MainCtrl'
        }).state('about', {
            url:'/about',
            templateUrl:'views/about.html',
            controller : 'AboutCtrl'

        }).state('home', {
            url:'/home',
            templateUrl:'views/home.html',
            controller : 'homeController'

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
