'use strict';

/**
 * @ngdoc directive
 * @name rollApp.directive:navbar
 * @description
 * # navbar
 */
angular.module('rollApp')
    .directive('footer', function ($rootScope) {
        return {
            templateUrl: 'views/partials/footer.html',
            restrict: 'E',
            link: function postLink(scope, element, attrs) {

            }
        };
    });