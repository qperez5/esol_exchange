Esol.Router.map(function(){
    this.route('organization');
    this.route('editOrganization',{path: '/editOrganization/:organization_id'});
    this.route('deleteOrganization',{path: '/deleteOrganization/:organization_id'});
    this.route('map');
    this.route('course');
    this.route('editCourse',{path: '/editCourse/:course_id'});
    this.route('deleteCourse',{path: '/deleteCourse/:course_id'});
    this.route('centre');
    this.route('editCentre',{path: '/editCentre/:centre_id'});
    this.route('deleteCentre',{path: '/deleteCentre/:centre_id'});
    this.route('searchResult');
});

Esol.OrganizationRoute = Ember.Route.extend({
   setupController: function(controller){
      controller.set('orgs',this.store.find('organization'));
   }
});

Esol.EditOrganizationRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("organization",params.organization_id);
    }
});

Esol.DeleteOrganizationRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("organization",params.organization_id);
    }
});

Esol.CourseRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('courses',this.store.find('course'));
    }
});

Esol.EditCourseRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("course",params.course_id);
    }

});

Esol.DeleteCourseRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("course",params.course_id);
    }
});

Esol.CentreRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('centres',this.store.find('centre'));
    }
});

Esol.EditCentreRoute = Ember.Route.extend({

    model: function(params){
        return this.store.findRecord("centre",params.centre_id);
    }

});

Esol.DeleteCentreRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("centre",params.centre_id);
    }
});

Esol.SearchResultRoute = Ember.Route.extend({
    setupController: function(controller){
        controller.set('courses',this.store.find('course'));
    }

});