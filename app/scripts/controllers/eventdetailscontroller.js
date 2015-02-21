'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:EventDetailsController
 * @description
 * # EventDetailsController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('EventDetailsController', function ($scope) {

        $scope.myInterval = 3000;
        $scope.slides = [
            {
                image: 'http://lorempixel.com/400/200/'
            },
            {
                image: 'http://lorempixel.com/400/200/food'
            },
            {
                image: 'http://lorempixel.com/400/200/sports'
            },
            {
                image: 'http://lorempixel.com/400/200/people'
            }
        ];

  });

//{
//    image: $rootScope.baseUrl+'/app/images/Irish.jpg'
//},
//{
//    image: $rootScope.baseUrl+'/app/images/House.jpg'
//}
//
