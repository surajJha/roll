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
        factory.getEventBySearch = function(searchParam, tablename, index, which_day){
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/userController.php?func=getEventBySearch&searchParam='+searchParam+'&tablename='+tablename+'&index='+index+'&which_day='+which_day)
                .success(function(res){
                    defer.resolve(res);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }

        /**
         * Takes as input the category,
         * such as comedy
         * and returns a list of all results .
         * @param category
         * @param index
         * @param which_day
         * @returns {jQuery.promise|promise.promise|d.promise|promise|.ready.promise|jQuery.ready.promise}
         */
        factory.getEventByCategory = function(category, index, which_day){
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/userController.php?func=getEventByCategory&category='+category+'&index='+index+'&which_day='+which_day)
                .success(function(res){
                    defer.resolve(res);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }

        /**
         * Takes as input the event_detail_id
         * and returns the event detail.
         * @param event_detail_id
         * @returns {jQuery.promise|promise.promise|d.promise|promise|.ready.promise|jQuery.ready.promise}
         */
        factory.getEventDetail = function(event_detail_id){
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/userController.php?func=getEventDetail&event_detail_id='+event_detail_id)
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





