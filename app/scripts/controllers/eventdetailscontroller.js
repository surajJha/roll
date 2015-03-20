'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:EventDetailsController
 * @description
 * # EventDetailsController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('EventDetailsController', function ($scope, $stateParams, userTaskFactory, $state) {

        if($stateParams.formData == '' || $stateParams.formData == null){
            $state.go('home');
        }
        else{

            $scope.eventdata = $stateParams.formData;

            if($stateParams.id != null){
                $scope.id = $stateParams.id;
            }

            $scope.formData = {};
            $scope.formData.event_name = '';
            $scope.formData.event_category = '';
            $scope.formData.event_cost = '';
            $scope.formData.event_overview = '';
            $scope.formData.event_hashtags = '';
            $scope.formData.venue_name = '';
            $scope.formData.event_area = '';
            $scope.formData.event_city = '';
            $scope.formData.event_location = '';
            $scope.formData.image = '';
            $scope.formData.datetime = '';
            $scope.formData.result_length = '';
            $scope.formData.no_of_days = '';

            $scope.encoded_image_path_array = '';



            /* All the function body goes first
            * that is before the call otherwise
            * it causes error
            */

            $scope.mapOptions = {
                center: new google.maps.LatLng(19.121, 72.85),
                zoom:16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //var map = new google.maps.Map(document.getElementById('myMap'), $scope.mapOptions);

            $scope.codeAddress = function(){
                var geocoder = new google.maps.Geocoder();
                var address = String($scope.formData.event_area[0]);
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $scope.myMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: $scope.myMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert("Sorry, we could not locate the place on the map.");
                    }
                });
            };

            $scope.init = function(){
                $scope.codeAddress();
            }

            $scope.eventDetailTemplating = function(formData){
                $scope.codeAddress();
                var date = formData.datetime[0].date;
                $scope.formData.datetime[0].start_time = formData.datetime[0].start_time.slice(0, 5);
                $scope.formData.datetime[0].end_time = formData.datetime[0].end_time.slice(0, 5);
            }



            if(angular.isNumber($scope.eventdata)){
                // user coming from the home page via featured events
                userTaskFactory.getEventDetail($scope.eventdata).then(function(result)
                {
                    $scope.formData.event_name = result[0].event_name;
                    $scope.formData.event_category = result[0].category_name;
                    $scope.formData.event_cost = result[0].event_cost;
                    $scope.formData.event_overview = result[0].event_overview;
                    $scope.formData.event_hashtags = result[0].event_hashtags;
                    $scope.formData.venue_name = result[0].venue_name;
                    $scope.formData.event_area = result[0].event_area;
                    $scope.formData.event_city = result[0].event_city;
                    $scope.formData.event_location = result[0].event_location;
                    $scope.formData.image = result[0].image;
                    $scope.formData.datetime = result[0].datetime;
                    $scope.formData.event_cost = parseInt($scope.formData.event_cost[0]);
                    $scope.eventDetailTemplating($scope.formData);

                })
            }
            else{
                // user coming from the search results page
                $scope.formData.event_name = $scope.eventdata.event_name[$scope.id];
                $scope.formData.event_category = $scope.eventdata.event_category[$scope.id];
                $scope.formData.event_cost = $scope.eventdata.event_cost[$scope.id];
                $scope.formData.event_overview = $scope.eventdata.event_overview[$scope.id];
                $scope.formData.event_hashtags = $scope.eventdata.event_hashtags[$scope.id];
                $scope.formData.venue_name = $scope.eventdata.venue_name[$scope.id];
                $scope.formData.event_area = $scope.eventdata.event_area[$scope.id];
                $scope.formData.event_city = $scope.eventdata.event_city[$scope.id];
                $scope.formData.event_location = $scope.eventdata.event_location[$scope.id];
                $scope.formData.image = $scope.eventdata.image[$scope.id];
                $scope.formData.datetime = $scope.eventdata.datetime[$scope.id];
                $scope.formData.no_of_days = $scope.eventdata.no_of_days[$scope.id];
                $scope.eventDetailTemplating($scope.formData);
            }
        }

        //$scope.myInterval = 3000;
        //$scope.slides = [
        //    {
        //        image: 'http://lorempixel.com/1000/400/'
        //    }
        //    //,
        //    //{
        //    //    image: 'http://lorempixel.com/1000/400/food'
        //    //},
        //    //{
        //    //    image: 'http://lorempixel.com/1000/400/sports'
        //    //}
        //];


  });
