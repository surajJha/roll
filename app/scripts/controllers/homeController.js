'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
    .controller('homeController', function ($scope, $rootScope, $http, userTaskFactory) {
        $scope.submit = function() {

            userTaskFactory.getEventBySearch($scope.testObj.title, $scope.testObj.description).then(function(result)
            {

                console.log(result);
            })
            //
            //alert('About to submit ' + $scope.testObj.title +' '+$scope.testObj.description);
            //console.log($scope.testObj);
        }

    });
