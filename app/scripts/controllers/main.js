'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
