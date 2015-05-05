'use strict';

/**
 * @ngdoc directive
 * @name rollApp.directive:categories
 * @description
 * # categories
 */
angular.module('rollApp')
  .directive('categories', function ($rootScope) {
    return {
      templateUrl: 'views/partials/categories.html',
      restrict: 'E',
      link: function postLink(scope, element, attrs) {

      }
    };
  });
