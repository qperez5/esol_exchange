Esol.OrganizationController = Ember.Controller.extend({

    actions: {
        edit:function(){

        },

        delete:function(organization){
            console.debug("deleting organization...");
            console.dir(organization);
            organization.deleteRecord();
            organization.save();
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