'use strict';

describe('Controller: EventDetailsController', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var EventDetailsController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    EventDetailsController = $controller('EventDetailsController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
