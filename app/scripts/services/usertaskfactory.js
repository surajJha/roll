'use strict';

/**
 * @ngdoc service
 * @name shoutApp.adminTaskFactory
 * @description
 * # adminTaskFactory
 * Factory in the shoutApp.
 */
angular.module('rollApp')
    .factory('userTaskFactory', function ($http, $q, $rootScope) {
        // Service logic
        // ...

        var factory = {};

        // Public API here
        /*
         Add all the public functions to the factory object
         and then return the factory object which
         will be then available to the controller
         which is using this factory
         */


        /**
         * getEventBySearch is to be placed in roll folder
         * this function displays the events based on search param and type
         */
        factory.getEventBySearch = function(searchParam, tablename, index){
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/userController.php?func=getEventBySearch&searchParam='+searchParam+'&tablename='+tablename+'&index='+index)
                .success(function(res){
                    defer.resolve(res);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }


        return factory;
    });


