'use strict';

/**
 * @ngdoc directive
 * @name rollApp.directive:fullmedia
 * @description
 * # fullmedia
 */
angular.module('rollApp')
  .directive('fullmedia', function ($rootScope) {
    return {
      templateUrl: 'views/partials/fullmedia.html',
      restrict: 'E',
      link: function postLink(scope, element, attrs) {

      }
    };
  });
