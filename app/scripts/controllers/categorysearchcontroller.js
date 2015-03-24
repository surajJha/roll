'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:categorySearchController
 * @description
 * # categorySearchController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('categorySearchController', function ($scope, $state, $stateParams, userTaskFactory, $cookieStore) {

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
      $scope.isBusy = false;
      $scope.selectedCategory = $stateParams.category;
      $scope.NoResultFound = true;

      $scope.loadMoreCategoryEvent = function() {

          if($stateParams.category == '' || $stateParams.category ==null){
              $state.go("home");
              return;
          }

        $scope.last_fetched_index+=3;

        userTaskFactory.getEventByCategory($stateParams.category, $scope.last_fetched_index, $scope.which_day).then(function(result)
        {
            if($scope.do_not_scroll) return;

            if(result == ''){
                $scope.do_not_scroll = true;
            }
            else{
                //console.log(result);
                $scope.isBusy = false;
                $scope.NoResultFound = false;

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


                    for(var j = 0;j<$scope.formData.image[i].length;j++){

                        if($scope.formData.image[i][j].primary == 1) {

                            $scope.formData.image[i] = $scope.formData.image[i][j].image_path;

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
                  temp_arr.push(i);
                }
                for (var i=0; i<temp_arr.length; i+=3) {
                  $scope.array_repeat_event.push(temp_arr.slice(i, i+3));
                }
          }
        })

      };

      $scope.getTodaysEventsByCategory = function(){
        $scope.NoResultFound = true;
        $scope.which_day = "today";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }

      $scope.getTomorrowsEventsByCategory = function(){
        $scope.NoResultFound = true;
        $scope.which_day = "tomorrow";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }

      $scope.getLatersEventsByCategory = function(){
        $scope.NoResultFound = true;
        $scope.which_day = "later";
        $scope.last_fetched_index = -3;
        $scope.do_not_scroll = false;
        $scope.array_repeat_event = [];
        $scope.loop_counter = 0;
        $scope.loadMoreCategoryEvent();

      }


      $scope.init = function () {
        $scope.getTodaysEventsByCategory();
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
