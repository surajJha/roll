'use strict';

describe('Controller: AreasearchcontrollerCtrl', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var AreasearchcontrollerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AreasearchcontrollerCtrl = $controller('AreasearchcontrollerCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
