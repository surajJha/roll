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
        $scope.selectedCategory = $stateParams.category;
        $scope.NoResultFound = true;
        $scope.counter_for_loadmore = 0;
        console.log($stateParams);

        $scope.loadMore = function() {
            $scope.last_fetched_index+=3;
            userTaskFactory.getEventBySearch($stateParams.query, $stateParams.type, $scope.last_fetched_index).then(function(result)
            {
                if($scope.do_not_scroll) return;

                if(result == ''){
                    $scope.do_not_scroll = true;
                }
                else{
                    var k = -1;
                    $scope.NoResultFound = false;
                    for(var i=0; i< result.length; i++){
                        $scope.formData.event_detail_id[$scope.counter_for_loadmore+i] = result[i].event_detail_id;
                        $scope.formData.event_name[$scope.counter_for_loadmore+i] = result[i].event_name;
                        $scope.formData.event_category[$scope.counter_for_loadmore+i] = result[i].category_name;
                        $scope.formData.event_cost[$scope.counter_for_loadmore+i] = result[i].event_cost;
                        $scope.formData.event_overview[$scope.counter_for_loadmore+i] = result[i].event_overview;
                        $scope.formData.event_hashtags[$scope.counter_for_loadmore+i] = result[i].event_hashtags;
                        $scope.formData.venue_name[$scope.counter_for_loadmore+i] = result[i].venue_name;
                        $scope.formData.event_area[$scope.counter_for_loadmore+i] = result[i].event_area;
                        $scope.formData.event_city[$scope.counter_for_loadmore+i] = result[i].event_city;
                        $scope.formData.event_location[$scope.counter_for_loadmore+i] = result[i].event_location;
                        $scope.formData.event_organizer_id = result[i].event_organizer_id;
                        $scope.formData.image[$scope.counter_for_loadmore+i] = result[i].image;
                        $scope.formData.datetime[$scope.counter_for_loadmore+i] = result[i].datetime;
                        $scope.formData.event_cost[$scope.counter_for_loadmore+i] = parseInt($scope.formData.event_cost[i]);


                        for(var j = 0;j<$scope.formData.image[$scope.counter_for_loadmore+i].length;j++){

                            if($scope.formData.image[$scope.counter_for_loadmore+i][j].primary == 1) {

                                $scope.formData.image[$scope.counter_for_loadmore+i] = $scope.formData.image[$scope.counter_for_loadmore+i][j].image_path;

                                //k++;
                                //(function(j_alias,k){
                                //    userTaskFactory.loadImages($scope.formData.image[i][j_alias].image_path).then(function(result){
                                //        $scope.encoded_image_path_array[k] = result;
                                //
                                //    })
                                //}(j,k))
                            }

                        }

                    }
                    var temp_arr= [];
                    for(var i=0; i<result.length; i++){
                        temp_arr.push($scope.counter_for_loadmore+i);
                    }
                    $scope.array_repeat_event.push(temp_arr.slice(0, 3));
                    //for (var i=0; i<temp_arr.length; i+=3) {
                    //  $scope.array_repeat_event.push(temp_arr.slice(i, i+3));
                    //}
                }
                $scope.counter_for_loadmore += 3;
            })
        };

        $scope.getEventsBySearch = function(){
            $scope.NoResultFound = true;
         //   $scope.which_day = "today";
            $scope.last_fetched_index = -3;
            $scope.do_not_scroll = false;
            $scope.array_repeat_event = [];
            $scope.loop_counter = 0;
            $scope.loadMore();

        }

        //$scope.getTomorrowsEventsBySearch = function(){
        //    $scope.NoResultFound = true;
        //    $scope.which_day = "tomorrow";
        //    $scope.last_fetched_index = -3;
        //    $scope.do_not_scroll = false;
        //    $scope.array_repeat_event = [];
        //    $scope.loop_counter = 0;
        //    $scope.loadMore();
        //
        //}
        //
        //$scope.getLatersEventsBySearch = function(){
        //    $scope.NoResultFound = true;
        //    $scope.which_day = "later";
        //    $scope.last_fetched_index = -3;
        //    $scope.do_not_scroll = false;
        //    $scope.array_repeat_event = [];
        //    $scope.loop_counter = 0;
        //    $scope.loadMore();
        //
        //}


        $scope.init = function () {
            if($stateParams.type == '' || $stateParams.type == null){
                $state.go("home");
                return;
            }
            if($stateParams.type != 'Event')
                $scope.getEventsBySearch();
            else{
                $state.go("event",{formData: parseInt($stateParams.event_detail_id), event_name: $stateParams.event_name})
            }
        }

        $scope.init();

        $scope.getEventDetail = function(formData, id){
            if(formData){
                $state.go("event", {formData: formData, id: id});
            }
        }

        $scope.loadAnotherCategory = function(category){
            if(category){
                $state.go("category", {category: category});
            }
        }
  });
