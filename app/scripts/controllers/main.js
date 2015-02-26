'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    //$scope.model = { myMap: undefined };
    //    $scope.mapOptions = {
    //        center: new google.maps.LatLng(19.121, 72.85),
    //        zoom: 15,
    //        mapTypeId: google.maps.MapTypeId.ROADMAP
    //    };
    //    //var map = new google.maps.Map(document.getElementById('myMap'), $scope.mapOptions);
    //
    //    $scope.codeAddress = function(){
    //        var geocoder = new google.maps.Geocoder();
    //        var address = $scope.address;
    //        geocoder.geocode( { 'address': address}, function(results, status) {
    //            if (status == google.maps.GeocoderStatus.OK) {
    //                $scope.myMap.setCenter(results[0].geometry.location);
    //                var marker = new google.maps.Marker({
    //                    map: $scope.myMap,
    //                    position: results[0].geometry.location
    //                });
    //            } else {
    //                alert("Geocode was not successful for the following reason: " + status);
    //            }
    //        });
    //    }
  });
