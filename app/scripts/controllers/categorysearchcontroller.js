'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:categorySearchController
 * @description
 * # categorySearchController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('categorySearchController', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
