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
            $scope.formData.no_of_days = [];

            $scope.encoded_image_path_array = '';

            $scope.map = '';


            /* All the function body goes first
            * that is before the call otherwise
            * it causes error
            */

            $scope.initialize = function(){
                $scope.mapOptions = {
                    center: new google.maps.LatLng(19.121, 72.85),
                    zoom:15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                $scope.map = new google.maps.Map(document.getElementById('map'), $scope.mapOptions);
                $scope.codeAddress();
            }

           // google.maps.event.addDomListener(window, 'load', $scope.initialize);

            $scope.codeAddress = function(){
                var geocoder = new google.maps.Geocoder();
                var address = $scope.formData.event_location == ''? 'Andheri' : String($scope.formData.event_location);
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $scope.map.setCenter(new google.maps.LatLng(parseFloat(results[0].geometry.location.A), parseFloat(results[0].geometry.location.F)));
                        var marker = new google.maps.Marker({
                            map: $scope.map,
                            position: results[0].geometry.location
                        });
                    } else {
                        // alert("Sorry, we could not locate the place on the map. Please try again");
                    }
                });
            };



            $scope.eventDetailTemplating = function(formData){
                for(var i=0; i<$scope.formData.datetime.length; i++){
                    $scope.formData.datetime[i].start_time = formData.datetime[i].start_time.slice(0, 5);
                    $scope.formData.datetime[i].end_time = formData.datetime[i].end_time.slice(0, 5);
                }
            }

            //send the length to this function, for eg: 2, 3 etc.
            $scope.makeArray = function(result){
                var items = [];
                for(var i =0;i<result;i++){
                    items.push(i);
                }
                return items;
            }



            if(angular.isNumber($scope.eventdata)){
                // user coming from the home page via featured events
                //user coming from searching the event directly in search box
                userTaskFactory.getEventDetail($scope.eventdata).then(function(result)
                {
                    if(result.length > 0) {
                        $scope.formData.event_location = result[0].event_location;
                        $scope.formData.event_name = result[0].event_name;
                        $scope.formData.event_category = result[0].category_name;
                        $scope.formData.event_cost = result[0].event_cost;
                        $scope.formData.event_overview = result[0].event_overview;
                        $scope.formData.event_hashtags = result[0].event_hashtags;
                        $scope.formData.venue_name = result[0].venue_name;
                        $scope.formData.event_area = result[0].event_area;
                        $scope.formData.event_city = result[0].event_city;
                        $scope.formData.image = result[0].image[0].image_path;
                        $scope.formData.datetime = result[0].datetime;
                        $scope.formData.no_of_days = $scope.makeArray($scope.formData.datetime.length);
                        $scope.formData.event_cost = $scope.formData.event_cost[0];
                        if($scope.formData.event_cost == 0 || $scope.formData.event_cost == null || $scope.formData.event_cost == undefined){
                            $scope.formData.event_cost = "Free Entry";
                        }
                        $scope.eventDetailTemplating($scope.formData);
                    }
                   else {
                        // TODO : will have to do something better if data was not fetched properly
                        $state.go("home");
                        return;
                    }

                })
            }
            else{
                // user coming from the search results page
               // TODO: have to make a common function for both if and else only the parameter is different. we can set that also. just have to pass id now. and no formdata
                userTaskFactory.getEventDetail($scope.eventdata.event_detail_id[$scope.id]).then(function(result)
                {
                    if(result.length > 0) {
                        $scope.formData.event_location = result[0].event_location;
                        $scope.formData.event_name = result[0].event_name;
                        $scope.formData.event_category = result[0].category_name;
                        $scope.formData.event_cost = result[0].event_cost;
                        $scope.formData.event_overview = result[0].event_overview;
                        $scope.formData.event_hashtags = result[0].event_hashtags;
                        $scope.formData.venue_name = result[0].venue_name;
                        $scope.formData.event_area = result[0].event_area;
                        $scope.formData.event_city = result[0].event_city;
                        $scope.formData.image = result[0].image[0].image_path;
                        $scope.formData.datetime = result[0].datetime;
                        $scope.formData.no_of_days = $scope.makeArray($scope.formData.datetime.length);
                        $scope.formData.event_cost = $scope.formData.event_cost[0];
                        if($scope.formData.event_cost == 0 || $scope.formData.event_cost == null || $scope.formData.event_cost == undefined){
                            $scope.formData.event_cost = "Free Entry";
                        }
                        $scope.eventDetailTemplating($scope.formData);
                    }
                    else {
                        // TODO : will have to do something better if data was not fetched properly
                        $state.go("home");
                        return;
                    }

                })

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
