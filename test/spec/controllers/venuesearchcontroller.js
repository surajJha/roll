'use strict';

describe('Controller: venueSearchController', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var venueSearchController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
      venueSearchController = $controller('venueSearchController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
