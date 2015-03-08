'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:eventSearchController
 * @description
 * # eventSearchController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('eventSearchController', function ($scope, $state, $stateParams, userTaskFactory){

        $scope.formData = {};
        $scope.formData.event_detail_id = [];
        $scope.formData.event_name = [];
        $scope.formData.event_category = [];
        $scope.formData.event_cost = [];
        $scope.formData.event_overview = [];
        $scope.formData.event_hashtags = [];
        $scope.formData.venue_name = [];
        $scope.formData.event_area = [];
        $scope.formData.event_city = [];
        $scope.formData.event_location = [];
        $scope.formData.image = [];
        $scope.formData.datetime = [];
        $scope.formData.result_length = [];
        $scope.formData.no_of_days = [];
        $scope.formData.event_organizer_id = [];
        $scope.encoded_image_path_array = [];

        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.which_day = "today";

        $scope.loadMore = function() {
            $scope.last_fetched_index+=3;
            userTaskFactory.getEventBySearch($stateParams.query, $stateParams.type, $scope.last_fetched_index, $scope.which_day).then(function(result)
            {
               // console.log(result[0].event_name);

                if(result == ''){
                    $scope.do_not_scroll = true;
                }
                else{
                    for(var i=0; i< result.length; i++){
                        $scope.formData.event_detail_id[i] = result[i].event_detail_id;
                        $scope.formData.event_name[i] = result[i].event_name;
                        $scope.formData.event_category[i] = result[i].category_name;
                        $scope.formData.event_cost[i] = result[i].event_cost;
                        $scope.formData.event_overview[i] = result[i].event_overview;
                        $scope.formData.event_hashtags[i] = result[i].event_hashtags;
                        $scope.formData.venue_name[i] = result[i].venue_name;
                        $scope.formData.event_area[i] = result[i].event_area;
                        $scope.formData.event_city[i] = result[i].event_city;
                        $scope.formData.event_location[i] = result[i].event_location;
                        $scope.formData.event_organizer_id = result[i].event_organizer_id;
                        $scope.formData.image[i] = result[i].image;
                        $scope.formData.datetime[i] = result[i].datetime;
                        $scope.formData.event_cost[i] = parseInt($scope.formData.event_cost[i]);

                    }
                    console.log($scope.formData);
                    //$scope.formData.event_name[0] = result[0].event_name;
                    //$scope.formData.event_detail_id[0] = result[0].event_detail_id;
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
            if($stateParams.type == '' || $stateParams.type ==null){
                $state.go("home");
                return;
            }
            $scope.getTodaysEventsBySearch();
        }

        $scope.init();

        $scope.getEventDetail = function(event_detail_id){
            console.log(event_detail_id);
            if(event_detail_id){
                $state.go("event", {event_detail_id: event_detail_id});
            }
        }

        $scope.loadAnotherCategory = function(category){
            if(category){
                $state.go("category", {category: category});
            }
        }
  });
