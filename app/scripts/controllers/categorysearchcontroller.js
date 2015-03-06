'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:categorySearchController
 * @description
 * # categorySearchController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('categorySearchController', function ($scope, $stateParams, userTaskFactory) {

      $scope.last_fetched_index = -3;
      $scope.do_not_scroll = false;
      $scope.array_repeat_event = [];
      $scope.loop_counter = 0;
      $scope.which_day = "today";
      $scope.isBusy = false;

      $scope.formData={};
      $scope.formData.event_name = [];

      $scope.loadMoreCategoryEvent = function() {

        if($scope.isBusy) return; // request in progress, return

        $scope.isBusy = true;
        $scope.last_fetched_index+=3;

        userTaskFactory.getEventByCategory($stateParams.category, $scope.last_fetched_index, $scope.which_day).then(function(result)
        {
          console.log(result);
          if(result == 'No Search Results Found'){
            $scope.do_not_scroll = true;
          }
          else{
            $scope.isBusy = false;
            $scope.formData.event_name[0] = result[0].event_name;
            var temp_arr= [];
            for(var i=0; i<result.length; i++){
              temp_arr.push(i);
            }
            for (var i=0; i<temp_arr.length; i+=3) {
              $scope.array_repeat_event.push(temp_arr.slice(i, i+3));
            }
          }
        })

      };

      $scope.getTodaysEventsByCategory = function(){
        $scope.which_day = "today";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }

      $scope.getTomorrowsEventsByCategory = function(){
        $scope.which_day = "tomorrow";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }

      $scope.getLatersEventsByCategory = function(){
        $scope.which_day = "later";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }


      //$scope.init = function () {
      //  $scope.getTodaysEventsByCategory();
      //}
      //
      //$scope.init();

  });
