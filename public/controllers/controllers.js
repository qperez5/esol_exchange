Esol.OrganizationController = Ember.Controller.extend({
    actions: {

        add:function(){
            console.log("adding a new organization");
            var newOrg = this.store.createRecord('organization');
            this.transitionToRoute('editOrganization',newOrg);
        }
    }
});

Esol.DeleteOrganizationController = Ember.ObjectController.extend({
    actions: {

        delete:function(){
            console.debug("deleting the organization...");
            console.dir(this.get("model"));
            var organization = this.get("model");
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
        add:function(){
            console.log("adding a new course");
            var newCourse = this.store.createRecord('course');
            this.transitionToRoute('editCourse',newCourse);
        },

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
        add:function(){
            console.log("adding a new centre");
            var newCentre = this.store.createRecord('centre');
            this.transitionToRoute('editCentre',newCentre);
        },

        delete:function(centre){
            console.debug("deleting centre...");
            console.dir(centre);
            centre.deleteRecord();
            centre.save();

        }
    }

});

Esol.EditCentreController = Ember.ObjectController.extend({

    map: null,

    actions: {
        save: function(){
            this.get("model").save();
        },
        search: function () {
            var geocoder = new google.maps.Geocoder();
            var controller = this;
            geocoder.geocode({'address': this.get("fullAddress")}, function(results,status){
                controller.addressFound(results,status);
            });
        }
    },

    addressFound: function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            var mapVar = this.get("map");
            var geoLocation = (results[0].geometry.location);
            var lat = geoLocation.lat();
            var lng = (results[0].geometry.location.lng());
            mapVar.setZoom(16);
            mapVar.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: mapVar,
                position: results[0].geometry.location
            });
            this.get("model").set("location",lat + "," + " " + lng);
        }
    }

});