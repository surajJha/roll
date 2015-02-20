'use strict';

describe('Service: userTaskFactory', function () {

  // load the service's module
  beforeEach(module('rollApp'));

  // instantiate service
  var userTaskFactory;
  beforeEach(inject(function (_userTaskFactory_) {
    userTaskFactory = _userTaskFactory_;
  }));

  it('should do something', function () {
    expect(!!userTaskFactory).toBe(true);
  });

});
