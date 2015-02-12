'use strict';

describe('Controller: homeController', function () {

    // load the controller's module
    beforeEach(module('rollApp'));

    var homeController,
        scope;

    // Initialize the controller and a mock scope
    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();
        homeController = $controller('homeController', {
            $scope: scope
        });
    }));

    it('should attach a list of awesomeThings to the scope', function () {
        expect(scope.awesomeThings.length).toBe(3);
    });
});
