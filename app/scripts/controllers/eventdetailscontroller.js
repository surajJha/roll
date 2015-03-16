'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:EventDetailsController
 * @description
 * # EventDetailsController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('EventDetailsController', function ($scope, $stateParams,userTaskFactory, $state) {

        if($stateParams.formData == '' || $stateParams.formData == null){
            $state.go('home');
        }
        else{
            $scope.formData = $stateParams.formData;

            console.log($scope.formData);

            var date = $scope.formData.datetime[0][0].date;
            $scope.formData.datetime[0][0].start_time = $scope.formData.datetime[0][0].start_time.slice(0, 5);
            $scope.formData.datetime[0][0].end_time = $scope.formData.datetime[0][0].end_time.slice(0, 5);
            console.log($scope.formData.datetime[0][0].start_time.slice(0, 5));


            $scope.mapOptions = {
                center: new google.maps.LatLng(19.121, 72.85),
                zoom:16,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            //var map = new google.maps.Map(document.getElementById('myMap'), $scope.mapOptions);

            $scope.codeAddress = function(){
                var geocoder = new google.maps.Geocoder();
                //var address = $scope.address;
                var address = String($scope.formData.event_area);
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $scope.myMap.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: $scope.myMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            };

            $scope.init = function(){
                $scope.codeAddress();
            }
            $scope.init();
        }

        $scope.myInterval = 3000;
        $scope.slides = [
            {
                image: 'http://lorempixel.com/1000/400/'
            }
            //,
            //{
            //    image: 'http://lorempixel.com/1000/400/food'
            //},
            //{
            //    image: 'http://lorempixel.com/1000/400/sports'
            //}
        ];


  });
