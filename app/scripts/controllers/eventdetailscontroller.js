'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:EventDetailsController
 * @description
 * # EventDetailsController
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('EventDetailsController', function ($scope, $stateParams,userTaskFactory) {

        $scope.event_detail_id = '';

        $scope.init = function(){
            $scope.event_detail_id = $stateParams.event_detail_id;
            console.log();
            userTaskFactory.getEventDetail($scope.event_detail_id).then(function(result)
            {
                console.log(result);
            })
        }

        $scope.init();

        $scope.myInterval = 3000;
        $scope.slides = [
            {
                image: 'http://lorempixel.com/1000/400/'
            },
            {
                image: 'http://lorempixel.com/1000/400/food'
            },
            {
                image: 'http://lorempixel.com/1000/400/sports'
            },
            {
                image: 'http://lorempixel.com/1000/400/people'
            }
        ];

        $scope.mapOptions = {
            center: new google.maps.LatLng(19.121, 72.85),
            zoom:16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        //var map = new google.maps.Map(document.getElementById('myMap'), $scope.mapOptions);

        $scope.codeAddress = (function(){
            var geocoder = new google.maps.Geocoder();
            //var address = $scope.address;
            var address = "andheri";
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
        })();

  });
