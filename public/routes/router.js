Esol.Router.map(function(){
    this.route('organization');
    this.route('editOrganization',{path: '/editOrganization/:organization_id'});
    this.route('map');
    this.route('course');
    this.route('editCourse',{path: '/editCourse/:course_id'});
    this.route('centre');
    this.route('editCentre',{path: '/editCentre/:centre_id'});
});


Esol.OrganizationRoute = Ember.Route.extend({
   setupController: function(controller){
      controller.set('orgs',this.store.find('organization'));
   }
});

Esol.EditOrganizationRoute = Ember.Route.extend({

});

Esol.CourseRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('courses',this.store.find('course'));
    }
});

Esol.EditCourseRoute = Ember.Route.extend({

});


Esol.CentreRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('centres',this.store.find('centre'));
    }
});

Esol.EditCentreRoute = Ember.Route.extend({

});

