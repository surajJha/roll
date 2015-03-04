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
        var factory = {};

        /**
         Public API here
         Add all the public functions to the factory object
         and then return the factory object which
         will be then available to the controller
         which is using this factory
         **/


        /**
         * Takes as input the search query and search type,
         * such as a place name and type as area|venue|event name
         * and returns a list of all results .
         * @param searchParam
         * @param tablename
         * @param index
         * @returns {jQuery.promise|promise.promise|d.promise|promise|.ready.promise|jQuery.ready.promise}
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


