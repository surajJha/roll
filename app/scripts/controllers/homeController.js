'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
    .controller('homeController', function ($scope, $state, $location, $rootScope, $http, userTaskFactory) {
        $scope.submit = function() {
            if($scope.testObj){
                console.log($scope.testObj.description);
                $state.go("events", {type: $scope.testObj.description, query: $scope.testObj.title});
            }
        }

    });
