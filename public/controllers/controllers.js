Esol.OrganizationController = Ember.Controller.extend({

    actions: {
        edit:function(){

        },

        add:function(){
            console.log("adding a new organization");
            var newOrg = this.store.createRecord('organization');
            this.transitionToRoute('editOrganization',newOrg);
        },


        delete:function(organization){
            console.debug("deleting organization...");
            console.dir(organization);
            organization.deleteRecord();
            organization.save();
        }
    }

});

Esol.EditOrganizationController = Ember.ObjectController.extend({

    actions: {
        save: function(){
            this.get("model").save();
        }
    }

});

Esol.MapController = Ember.Controller.extend({



});

Esol.CourseController = Ember.Controller.extend({
    actions: {

        delete: function (course) {
            console.debug("deleting course...");
            console.dir(course);
            course.deleteRecord();
            course.save();

        }
    }
});

Esol.EditCourseController = Ember.ObjectController.extend({

    actions: {
        save: function(){
            this.get("model").save();
        }
    }

});


Esol.CentreController = Ember.Controller.extend({
    actions:{
        delete:function(centre){
            console.debug("deleting centre...");
            console.dir(centre);
            centre.deleteRecord();
            centre.save();

        }
    }

});

Esol.EditCentreController = Ember.ObjectController.extend({

    actions: {
        save: function(){
            this.get("model").save();
        }
    }

});