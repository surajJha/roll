'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
