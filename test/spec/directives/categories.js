'use strict';

describe('Directive: categories', function () {

  // load the directive's module
  beforeEach(module('rollApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<categories></categories>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the categories directive');
  }));
});
