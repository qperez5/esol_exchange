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

        courses: function(){
            return this.store.find("course");
        }.property(),

        delete:function(){
            console.debug("deleting the organization...");
            console.dir(this.get("model"));
            var organization = this.get("model");
            //if(organization.)
            organization.deleteRecord();
            organization.save();
            this.transitionToRoute('organization');
        },
        cancel:function(){
            console.debug("canceling delete the org...");
            this.transitionToRoute('organization');
        }
    }
});

Esol.EditOrganizationController = Ember.ObjectController.extend({

    yesNoConditionedOptions: function(){
    return [
        {"value": "y", "label": "Yes"},
        {"value": "n", "label": "No"},
        {"value": "c", "label": "Conditioned"}
        ];
    }.property(),

    coreCurriculumNotConditioned: function(){
        return this.get("model.core_curriculum") != "c";
    }.property("model.core_curriculum"),

    clearCoreCurriculumCondition: function(){
        if(this.get("model.core_curriculum")!= "c"){
            this.set("model.core_curriculum_condition","");
        }
    }.observes("model.core_curriculum"),

    tutorsQualifiedNotConditioned: function(){
        return this.get("model.tutors_qualified") != "c";
    }.property("model.tutors_qualified"),

    clearTutorsQualifiedCondition: function(){
        if(this.get("model.tutors_qualified")!= "c"){
            this.set("model.tutors_qualified_condition","");
        }
    }.observes("model.tutors_qualified"),

    coursesAcreditationNotConditioned: function(){
    return this.get("model.courses_acreditated") != "c";
    }.property("model.courses_acreditated"),

    clearCoursesAcreditationCondition: function(){
    if(this.get("model.courses_acreditated")!= "c"){
        this.set("model.courses_acreditation_condition","");
    }
    }.observes("model.courses_acreditated"),

    actions: {
        save: function(){
            this.get("model").save();
            this.transitionToRoute('organization');
        },
        cancel: function(){
            this.transitionToRoute('organization');
        }
    }
});

Esol.CourseController = Ember.Controller.extend({
    actions: {
        add:function(){
            console.log("adding a new course");
            var newCourse = this.store.createRecord('course');
            this.transitionToRoute('editCourse',newCourse);
        }
    }
});

Esol.DeleteCourseController = Ember.ObjectController.extend({
    actions: {

        delete:function(){
            console.debug("deleting the course...");
            console.dir(this.get("model"));
            var course = this.get("model");
            course.deleteRecord();
            course.save();
            this.transitionToRoute('centre');
        },
        cancel:function(){
            console.debug("canceling delete the course...");
            this.transitionToRoute('course');
        }
    }
});

Esol.EditCourseController = Ember.ObjectController.extend({

    //selectedOrganization: null,

    organizations: function(){
        return this.store.find("organization");
    }.property(),

    centres: function(){
        return this.store.find("centre");
    }.property(),

    yesNoConditionedOptions: function(){
        return [
            {"value": "y", "label": "Yes"},
            {"value": "n", "label": "No"},
            {"value": "c", "label": "Conditioned"}
        ];

    }.property(),

    costNotConditioned: function(){
        return this.get("model.cost_free") != "c";
    }.property("model.cost_free"),

    clearCostCondition: function(){
        if(this.get("model.cost_free")!= "c"){
            this.set("model.cost_condition","");
        }
    }.observes("model.cost_free"),

    childNotConditioned: function(){
        return this.get("model.child_care") != "c";
    }.property("model.child_care"),

    childCostCondition: function(){
        if(this.get("model.child_care")!= "c"){
            this.set("model.child_condition","");
        }
    }.observes("model.child_care"),

    levelList: function(){
        return [
            'Entry 1','Entry 2','Entry 3','Formal course','Informal classes','Conversation speaking only',
            'ESOL with IT','ESOL with sewing','Women only','ESOL for Citizenship','ESOL for Employment',
            'Beginners pre-literate','Pre-entry'
        ];
    }.property(),

    actions: {
        save: function(){
            var selectedOrganization = this.get("selectedOrganization");
            var selectedCentres = this.get("selectedCentres");
            var selectedLevels = this.get("selectedLevels");

            if(selectedOrganization!=null){
               this.get("model").set("organization",selectedOrganization);
            }

            if(selectedLevels!=null){
                this.get("model").set("levels",selectedLevels);
            }

            this.get("model").save();
            this.transitionToRoute('course');
        },
        cancel: function(){
            this.transitionToRoute('course');
        }
    }

});

Esol.CentreController = Ember.Controller.extend({

    actions: {
        add:function(){
            console.log("adding a new centre");
            var newCentre = this.store.createRecord('centre');
            this.transitionToRoute('editCentre',newCentre);
        }
    }
});

Esol.DeleteCentreController = Ember.ObjectController.extend({
    actions: {
        delete:function(){
            console.debug("deleting the centre...");
            console.dir(this.get("model"));
            var centre = this.get("model");
            centre.deleteRecord();
            centre.save();
            this.transitionToRoute('centre');
        },
        cancel:function(){
            console.debug("canceling delete the centre...");
            this.transitionToRoute('centre');
        }
    }
});

Esol.EditCentreController = Ember.ObjectController.extend({

    map: null,

    yesNoConditionedOptions: function(){
        return [
            {"value": "y", "label": "Yes"},
            {"value": "n", "label": "No"},
            {"value": "c", "label": "Conditioned"}
        ];
    }.property(),

    accecibilityNotConditioned: function(){
        return this.get("model.accebility") != "c";
    }.property("model.accebility"),

    clearAccecibilityCondition: function(){
        if(this.get("model.accebility")!= "c"){
            this.set("model.accebility_condition","");
        }
    }.observes("model.accebility"),

    actions: {
        save: function(){
            this.get("model").save();
        },
        cancel:function(){
            console.debug("canceling editing the centre...");
            this.transitionToRoute('centre');
        },

        search: function () {
            geocode(this.get("fullAddress"),this.addressFound, this);
        }
    },

    addressFound: function(results){
            var mapVar = this.get("map");
            var geoLocation = results[0].geometry.location;
            var lat = geoLocation.lat();
            var lng = geoLocation.lng();
            mapVar.setZoom(16);
            mapVar.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: mapVar,
                position: results[0].geometry.location
            });
            this.get("model").set("location","POINT(" + lat + " " + lng+")");
    }
});

function geocode(address, geocodeCallback, callbackContext){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': address }, function(results,status){
        if(status == google.maps.GeocoderStatus.OK){
            geocodeCallback.call(callbackContext,results);
        }
    });
}

Esol.MapController = Ember.Controller.extend({
    isFree: false,
    childCare: false,
    disability: false,
    postCode: null,
    map: null,
    foundCourses: Ember.A([]),

    mapMarkers: Ember.A([]),

    executeSearch: function (queryParams) {
        var controller = this;
        this.clearMarkers();

        this.store.find("course", queryParams).then(function (results) {
            controller.set("foundCourses", results);
            controller.get("foundCourses").forEach(function (foundCourse) {
                //logica para dibujar el punto
                foundCourse.get("centres").forEach(function (centre) {
                    var mapVar = controller.get("map");
                    var contentWindow = "<span class='windowInfo'>" + centre.get("name") + "<br/>" + foundCourse.get("contact_phone") + "</span>";
                    var infowindow = new google.maps.InfoWindow({
                        content: contentWindow
                    });

                    var marker = new google.maps.Marker({
                        map: mapVar,
                        position: centre.get("latLng"),
                        title: foundCourse.get("name")

                    });

                    marker.addListener('click', function() {
                        infowindow.open(mapVar, marker);
                    });

                    controller.get("mapMarkers").pushObject(marker);
                });
            });

        });
    },

    clearMarkers: function(){
        this.get("mapMarkers").forEach(function(marker){
            marker.setMap(null);
        });
        this.get("mapMarkers").clear();
    },

    actions: {
        detailedSearchEnabled: false,
        enableAdvancedSearch: function() {
            var currentlyEnabled = this.get("detailedSearchEnabled");
            this.set("detailedSearchEnabled", !currentlyEnabled);
        },

        search: function(){
            var queryParams = {
                free: this.get("isFree"),
                child_care: this.get("childCare"),
                disability: this.get("disability")
            };

            var postCodeSearch = this.get("postCode");
            var controller = this;

            if(postCodeSearch!=null && postCodeSearch!=""){
                geocode(postCodeSearch,function(results){
                    var geoLocation = results[0].geometry.location;
                    queryParams.lat = geoLocation.lat();
                    queryParams.lng = geoLocation.lng();

                    this.executeSearch(queryParams);
                },controller);
            } else {
                this.executeSearch(queryParams);
            }
        }
    }
});

Esol.SearchResultController = Ember.ObjectController.extend({

    actions: {

    }

});