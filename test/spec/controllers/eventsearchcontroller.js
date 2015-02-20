'use strict';

describe('Controller: EventsearchcontrollerCtrl', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var EventsearchcontrollerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    EventsearchcontrollerCtrl = $controller('EventsearchcontrollerCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
