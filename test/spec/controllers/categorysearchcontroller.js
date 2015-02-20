'use strict';

describe('Controller: CategorysearchcontrollerCtrl', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var CategorysearchcontrollerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CategorysearchcontrollerCtrl = $controller('CategorysearchcontrollerCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
