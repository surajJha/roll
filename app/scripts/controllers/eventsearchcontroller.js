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

        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.which_day = "today";

        $scope.formData={};
        $scope.formData.event_name = [];




        $scope.loadMore = function() {
            $scope.last_fetched_index+=3;
            userTaskFactory.getEventBySearch($stateParams.query, $stateParams.type, $scope.last_fetched_index, $scope.which_day).then(function(result)
            {
               // console.log(result[0].event_name);

                if(result == 'No Search Results Found'){
                    $scope.do_not_scroll = true;
                }
                else{
                    $scope.formData.event_name[0] = result[0].event_name;
                    console.log($scope.formData.event_name[0]);
                    var temp_arr= [];
                    for(var i=0; i<result.length; i++){
                        temp_arr.push(i);
                    }
                    for (var i=0; i<temp_arr.length; i+=3) {
                        $scope.array_repeat_event.push(temp_arr.slice(i, i+3));
                    }
                    //for(var i = 1; i <= 1; i++) {
                    //    //var last = $scope.array_repeat_event[$scope.array_repeat_event.length - 1];
                    //    $scope.array_repeat_event.push($scope.loop_counter++);
                    //}
                }
            })
        };

        $scope.getTodaysEventsBySearch = function(){
            $scope.which_day = "today";
            $scope.last_fetched_index = -3;
            $scope.do_not_scroll = false;
            $scope.array_repeat_event = [];
            $scope.loop_counter = 0;
            $scope.loadMore();

        }

        $scope.getTomorrowsEventsBySearch = function(){
            $scope.which_day = "tomorrow";
            $scope.last_fetched_index = -3;
            $scope.do_not_scroll = false;
            $scope.array_repeat_event = [];
            $scope.loop_counter = 0;
            $scope.loadMore();

        }

        $scope.getLatersEventsBySearch = function(){
            $scope.which_day = "later";
            $scope.last_fetched_index = -3;
            $scope.do_not_scroll = false;
            $scope.array_repeat_event = [];
            $scope.loop_counter = 0;
            $scope.loadMore();

        }


        $scope.init = function () {
            $scope.getTodaysEventsBySearch();
        }

        $scope.init();
  });
