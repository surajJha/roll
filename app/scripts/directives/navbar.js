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
       //     //console.log($("angucomplete-alt"))
       //   var input = $("angucomplete-alt");
       ////   input.on("keydown", handler);
       //
       //   function handler(event){
       //       console.log(event.target);
       //       //var active_row = event.target;
       //       if(event.which == 40){
       //           // keyup, make the lower sibling ka class as selected row
       //           event.target.nextElementSibling.classList.add("currently_hovered_search_result");
       //       }
       //       else if(event.which == 38){
       //           // keyup, make the upper sibling ka class as selected row
       //           event.target.previousElementSibling.classList.add("currently_hovered_search_result");
       //       }
       //       //active_row.classList.add("currently_hovered_search_result");
       //   }
      }
    };
  });
