Esol.Router.map(function(){
    this.route('organization');
    this.route('map');
    this.route('course');
    this.route('centre');
});


Esol.OrganizationRoute = Ember.Route.extend({
   setupController: function(controller){
      controller.set('orgs',this.store.find('organization'));
   }
});

Esol.CourseRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('courses',this.store.find('course'));
    }
});

Esol.CentreRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('centres',this.store.find('centre'));
    }
});

