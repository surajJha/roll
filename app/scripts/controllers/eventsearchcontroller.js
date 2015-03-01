'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:eventSearchController
 * @description
 * # eventSearchController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('eventSearchController', function ($scope, $stateParams, userTaskFactory){

        $scope.index = -2;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        var k = 0;
        $scope.loadMore = function() {
            $scope.index+=2;
            userTaskFactory.getEventBySearch($stateParams.query, $stateParams.type, $scope.index).then(function(result)
            {
                console.log(result);
                if(result == 'No Search Results Found'){
                    $scope.do_not_scroll = true;
                }
                else{
                    for(var i = 1; i <= 1; i++) {
                        //var last = $scope.array_repeat_event[$scope.array_repeat_event.length - 1];
                        $scope.array_repeat_event.push(k++);
                    }
                }

                console.log($scope.array_repeat_event);
            })
        };


    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
