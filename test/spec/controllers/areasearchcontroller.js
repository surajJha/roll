'use strict';

describe('Controller: areaSearchController', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var areaSearchController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    areaSearchController = $controller('areaSearchController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
