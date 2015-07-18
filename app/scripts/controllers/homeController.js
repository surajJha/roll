'use strict';

/**
 * @ngdoc function
 * @name rollApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the rollApp
 */
angular.module('rollApp')
    .controller('homeController', function ($scope, $state, $location, $rootScope, $http, userTaskFactory,$sce) {

      //  $sce.trustAsResourceUrl('http://www.rollingscenes.com');
        $scope.city = "Mumbai";

        $scope.goToHome = function(){
            $state.go("home");
        }

        $scope.submit = function() {
            if($scope.testObj){
                $state.go("events", {type: $scope.testObj.description, query: $scope.testObj.title, event_detail_id: $scope.testObj.originalObject.event_detail_id, event_name: $scope.testObj.originalObject.event_name});
                //$state.go("event", {formData: $scope.testObj.originalObject.event_detail_id});
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
