'use strict';

describe('Controller: eventSearchController', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var eventSearchController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    eventSearchController = $controller('eventSearchController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
