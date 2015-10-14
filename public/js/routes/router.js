Esol.Router.map(function(){
    this.route('organization');
    this.route('editOrganization',{path: '/editOrganization/:organization_id'});
    this.route('deleteOrganization',{path: '/deleteOrganization/:organization_id'});
    this.route('map', {path: '/'});
    this.route('about');
    this.route('help');
    this.route('course');
    this.route('editCourse',{path: '/editCourse/:course_id'});
    this.route('deleteCourse',{path: '/deleteCourse/:course_id'});
    this.route('centre');
    this.route('editCentre',{path: '/editCentre/:centre_id'});
    this.route('deleteCentre',{path: '/deleteCentre/:centre_id'});
    this.route('centre');
    this.route('searchResult',{path: '/result/:course_id'});
    this.route('administration');
    this.route('whatLevel',{path: 'Which_level_is_right_for_me'});
});

Esol.OrganizationRoute = Ember.Route.extend({
   model: function(){
       return this.store.find('organization');
   }
});

Esol.EditOrganizationRoute = Ember.Route.extend({
    model: function(params){
        //TODO en las otra.
        var organization;
        if(params.organization_id == 0){
            organization = this.store.createRecord('organization');
        } else {
            organization = this.store.findRecord("organization", params.organization_id);
        }
        return organization;
    },
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
        //TODO en las otra.
        var course;
        if(params.course_id == 0){
            course = this.store.createRecord('course');
        } else {
            course = this.store.findRecord("course", params.course_id);
        }
        return course;
    },

    setupController: function(controller,course){
        this._super(controller,course);
        if(course.get("isNew")){
            return;
        }
        var levels = course.get("levels");
        if(levels != null){
            var levelsArray = levels.split(",");
            controller.set("selectedLevels", levelsArray);
        }

        course.get("organization").then(function(org){
            controller.set("selectedOrganization",org);
        });

        course.reload().then(function(c){
            c.get("centres").then(function(centres){
                //controller.set("selectedCentres",centres);
            });
        });
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
        var centre;
        if(params.centre_id == 0){
            centre = this.store.createRecord('centre');
        } else {
            centre = this.store.findRecord("centre", params.centre_id);
        }
        return centre;
    }
});

Esol.DeleteCentreRoute = Ember.Route.extend({
    model: function(params){
        return this.store.findRecord("centre",params.centre_id);
    }
});

Esol.SearchResultRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.findRecord('course', params.course_id);
    }
});

Esol.AdministrationRoute = Ember.Route.extend({

});

Esol.WhatLevelRoute = Ember.Route.extend({

});

Esol.MapRoute = Ember.Route.extend({

    setupController: function(controller){
        controller.executeSearch({all: true});
    }
});