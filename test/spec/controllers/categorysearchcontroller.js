'use strict';

describe('Controller: categorySearchController', function () {

  // load the controller's module
  beforeEach(module('rollApp'));

  var categorySearchController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    categorySearchController = $controller('categorySearchController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
