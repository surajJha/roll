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
                $state.go("events", {type: $scope.testObj.description, query: $scope.testObj.title});
            }
        }

        $scope.submitCategory = function(category) {
            if(category){
                $state.go("category", {category: category});
            }
        }

        $scope.getEventDetailById = function(event_id){
            if(event_id){
                $state.go("event", {formData: event_id});
            }
        }

    });
