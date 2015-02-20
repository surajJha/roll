'use strict';

describe('Controller: VenuesearchcontrollerCtrl', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var VenuesearchcontrollerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    VenuesearchcontrollerCtrl = $controller('VenuesearchcontrollerCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
