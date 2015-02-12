'use strict';

/**
 * @ngdoc directive
 * @name rollApp.directive:navbar
 * @description
 * # navbar
 */
angular.module('rollApp')
  .directive('navbar', function ($rootScope) {
    return {
      templateUrl: $rootScope.baseUrl+'/app/views/partials/navbar.html',
      restrict: 'E',
      link: function postLink(scope, element, attrs) {

      }
    };
  });
