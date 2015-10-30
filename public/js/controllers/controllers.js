Esol.OrganizationController = Ember.ArrayController.extend({
    sortProperties: ['name'],
    sortAscending: true,
    actions:    {
        add:function(){
            console.log("adding a new organization");
            this.transitionToRoute('editOrganization',0);
        }
    }
});

Esol.DeleteOrganizationController = Ember.ObjectController.extend({

    actions: {

        courses: function(){
            return this.store.find("course");
        }.property(),

        delete:function(){

            var organization = this.get("model");
            var controller = this;
            organization.deleteRecord();
            organization.save().then(function(){
                controller.transitionToRoute('organization');
            });
        },
        cancel:function(){
            this.transitionToRoute('organization');
        }
    }
});

Esol.EditOrganizationController = Ember.ObjectController.extend(Ember.Validations.Mixin, {

    validations: {
        "name": {
            presence: true,
            presence:{ message: "  Name is required" }
        },
        "contact_number": {
            presence: true,
            presence:{ message: "  Contact number is required" }
        },
        "post_code": {
            presence: true,
            presence:{ message: ", Postcode is required" }

        },
        "address": {
            presence: true,
            presence:{ message: ", Address is required" }

        },
        "contact_email": {
            presence: true,
            presence:{ message: ", Email is required" }

        }
    },

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
            var organization = this.get("model");
            if(this.get("isValid")){
                organization.save();
                this.transitionToRoute('organization');
            }
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
            this.transitionToRoute('editCourse',0);
        }
    }
});

Esol.DeleteCourseController = Ember.ObjectController.extend({
    actions: {

        delete:function(){
            console.debug("deleting the course...");
            console.dir(this.get("model"));
            var controller = this;
            var course = this.get("model");
            course.deleteRecord();
            course.save().then(function(){
                controller.transitionToRoute('course');
            });
        },
        cancel:function(){
            console.debug("canceling delete the course...");
            this.transitionToRoute('course');
        }
    }
});

Esol.EditCourseController = Ember.ObjectController.extend(Ember.Validations.Mixin, {

    //selectedOrganization: null,

    validations: {
        "name": {
            presence: true,
            presence:{ message: "  Name is required" }
        },
        "times": {
            presence: true,
            presence:{ message: "  Time is required" }
        }
    },

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
        var result = this.get("model.cost_free") != "c" && this.get("model.cost_free") != "n";
        return result;
    }.property("model.cost_free"),

    clearCostCondition: function(){
        if(this.get("model.cost_free") == "y"){
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
            'Beginners pre-literate', 'Pre-entry', 'Entry level 1', 'Entry level 2', 'Entry level 3', 'Level  1', 'Level  2',
            'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Mixed', 'Non-literate', 'Any'
        ];
    }.property(),

    yesNotConditionList: function(){
        return [
            'Yes', 'No', 'Any'
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
            //var newCentre = this.store.createRecord('centre');
            this.transitionToRoute('editCentre',0);
        }
    }
});

Esol.DeleteCentreController = Ember.ObjectController.extend({
    actions: {
        delete:function(){
            console.debug("deleting the centre...");
            console.dir(this.get("model"));
            var controller = this;
            var centre = this.get("model");
            centre.deleteRecord();
            centre.save().then(function(){
                controller.transitionToRoute('centre');
            });
        },
        cancel:function(){
            console.debug("canceling delete the centre...");
            this.transitionToRoute('centre');
        }
    }
});

Esol.EditCentreController = Ember.ObjectController.extend(Ember.Validations.Mixin, {

    map: null,

    yesNoConditionedOptions: function(){
        return [
            {"value": "y", "label": "Yes"},
            {"value": "n", "label": "No"},
            {"value": "c", "label": "Conditioned"}
        ];
    }.property(),


    validations: {

        "name": {
            presence: true,
            presence:{ message:" Name is required"},

        },
        "post_code": {
            presence: true,
            presence:{ message: ", Postcode is required" },

        },

        "address": {
            presence: true,
            presence:{ message: ", Address is required" }

        }

    },

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
            this.transitionToRoute('centre');
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
    geocoder.geocode({'address': address, 'componentRestrictions': {"country":"GB", 'administrativeArea':'Newham', 'locality':"London"} }, function(results,status){
        if(status == google.maps.GeocoderStatus.OK){
            geocodeCallback.call(callbackContext,results);
        }
    });
}

Esol.SearchParameterExtractor = Ember.Object.extend({
    extractParameter: function(mapController){
        //TODO all extractors must extend this class
    }
});

$(function() {
    $('#nav li a').click(function() {
        $('#nav li').removeClass('active');
        $($(this).tagName('a')).addClass('active');
    });
});

Esol.AddressExtractor = Esol.SearchParameterExtractor.extend({

    extractParameter: function(mapController){
        var addressRegex = /(.+)|at (.+)/g ;
        var results = addressRegex.exec(mapController.get("generalSearch"));
        if(results!=null && results[1]!=null){
            mapController.set("postCode",results[1]);
        }else if(results!=null && results[2]!=null){
            mapController.set("postCode",results[2]);
        } else {
            mapController.set("postCode","");
        }
    }
});

Esol.MapController = Ember.Controller.extend({
    generalSearch: '',
    free: 'Any',
    childCare: 'Any',
    disability: 'Any',

    postCode: null,
    map: null,
    foundCourses: Ember.A([]),
    mapMarkers: Ember.A([]),
    parameterExtractors: Ember.A([
        Esol.AddressExtractor.create()
    ]),

    freeYesSelected: function(){
        if(this.get("free") == "Yes"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("free"),

    freeNoSelected: function(){
        if(this.get("free") == "No"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("free"),

    freeAnySelected: function(){
        if(this.get("free") == "Any"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("free"),


    disabilityYesSelected: function(){
        if(this.get("disability") == "Yes"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("disability"),

    disabilityNoSelected: function(){
        if(this.get("disability") == "No"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("disability"),

    disabilityAnySelected: function(){
        if(this.get("disability") == "Any"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("disability"),

    childcareYesSelected: function(){
        if(this.get("childCare") == "Yes"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("childCare"),

    childcareNoSelected: function(){
        if(this.get("childCare") == "No"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("childCare"),

    childcareAnySelected: function(){
        if(this.get("childCare") == "Any"){
            return "btn btn-default active";
        } else {
            return "btn btn-default";
        }
    }.property("childCare"),

    templateToString:function  (center,courses) {
        var markerDiv = $("#markerContent").clone(true);
        markerDiv.find(".centerName").html(center.get("name"));
        //otras cosas podrian setearse aqui ...
        var list = markerDiv.find(".list");
        courses.forEach(function(course){
            list.append("<li class=''><a href='#/result/" + course.get("id") + "/" + center.get("id") +"'  data-placement='left' data-toggle='popover'>" + course.get("name") +  "</a>" + "</li>");
        });
        return markerDiv.html();
    },

    executeSearch: function (queryParams) {
        var controller = this;
        this.clearMarkers();
        this.store.find("course", queryParams).then(function (results) {
            controller.set("foundCourses", results);
            var centres = Ember.Set.create(); //aqui guardaremos los centros encontrados, en un Set se guardan sin repeticiones ...
            var coursesMap = Ember.Map.create();//aqui en este mapa pondremos para cada centro la lista de cursos ...

            controller.get("foundCourses").forEach(function (foundCourse) {
                foundCourse.get("centres").forEach(function (centre) {
                    centres.add(centre);
                    if(coursesMap[centre.get("id")] == undefined){
                        coursesMap[centre.get("id")] = Ember.Set.create();
                    }
                    coursesMap[centre.get("id")].add(foundCourse);
                });
            });

            var mapVar = controller.get("map");

            centres.forEach(function(centre){
                var courses = coursesMap[centre.get("id")];
                var infoWindow = new google.maps.InfoWindow({
                    content: controller.templateToString(centre,courses)
                });

                var marker = new google.maps.Marker({
                    map: mapVar,
                    position: centre.get("latLng"),
                    label: courses.length.toString(),
                    title: centre.get("name")
                });

                marker.addListener('click', function() {
                    infoWindow.open(mapVar, marker);
                });

                controller.get("mapMarkers").pushObject(marker);
            })

        });
    },

    extractGeoParams: function(results){
        var geoParams = {
           lat:0,
           lng:0
        };

        var geoLocation = null;
        var controller = this;

        results.forEach(function(result){
            //if(controller.isValidResult(result)){
                geoLocation = result.geometry.location;
            //}
        });

        if(geoLocation != null){
            geoParams.lat = geoLocation.lat();
            geoParams.lng = geoLocation.lng();
            return geoParams;
        } else {
            return null;
        }
    },
    /*
    isValidResult: function(result){
        var isValid = false;
        result.address_components.forEach(function(component){
            if(component.short_name == "GB"){
                component.types.forEach(function(comp_type){
                    if(comp_type == "country"){
                        isValid = true;
                        return ;
                    }
                });

                if (isValid){
                    return;
                }
            }
        });

        return isValid;
    }, */


    clearMarkers: function(){
        this.get("mapMarkers").forEach(function(marker){
            marker.setMap(null);
        });
        this.get("mapMarkers").clear();
    },

    levelList: function(){
        return [
            ' ','Beginners pre-literate','Pre-entry','Entry level 1','Entry level 2','Entry level 3','Level  1', 'Level  2',
            'A1', 'A2', 'B1', 'B2','C1', 'C2', 'Mixed', 'Non-literate', 'Any'
        ];
    }.property(),

    yesNotConditionList: function(){
        return [
            'Yes', 'No', 'Any'
        ];
    }.property(),

    townList: function(){
        return [
            ' ','Canning Town','Plaistow','East Ham','Stratford','Forest Gate','Beckton', 'Custom House',
            'Manor Park', 'West Ham', 'Upton Park', 'North Woolwich','Silvertown'
        ];
    }.property(),

    classTypeList: function(){
        return [
            ' ','Formal course','Informal classes','Conversation / speaking only','ESOL with IT','ESOL with sewing',
            'Women only', 'ESOL for Citizenship','ESOL for Employment'
        ];
    }.property(),


    actions: {
        detailedSearchEnabled: false,

        freeActivateYes: function(){
            this.set("free","Yes");
        },

        freeActivateNo: function(){
            this.set("free","No");
        },

        freeActivateAny: function(){
            this.set("free","Any");
        },

        disabilityActivateYes: function(){
            this.set("disability","Yes");
        },

        disabilityActivateNo: function(){
            this.set("disability","No");
        },

        disabilityActivateAny: function(){
            this.set("disability","Any");
        },

        childcareActivateYes: function(){
            this.set("childCare","Yes");
        },

        childcareActivateNo: function(){
            this.set("childCare","No");
        },

        childcareActivateAny: function(){
            this.set("childCare","Any");
        },

        enableAdvancedSearch: function() {
            var currentlyEnabled = this.get("detailedSearchEnabled");
            this.set("detailedSearchEnabled", !currentlyEnabled);
        },

        generalSearchChanged: function(){
          /*  var controller = this;
            this.get("parameterExtractors").forEach(function(paramExtractor){
                paramExtractor.extractParameter(controller);
            });*/
        },



        search: function(){
            var postCodeSearch = this.get("postCode");
            var controller = this;

            var queryParams = {
                free: this.get("free"),
                childCare: this.get("childCare"),
                disability: this.get("disability")
                //level: this.get("selectedLevel"),
                //classType: this.get("selectedClassType")
                //postcode: this.get("post_code")
            };

            if(postCodeSearch!=null && postCodeSearch!=""){
                geocode(postCodeSearch,function(results){
                        var geoParams = this.extractGeoParams(results);
                        if (geoParams!=null) {
                            queryParams.lat = geoParams.lat;
                            queryParams.lng = geoParams.lng;
                            this.executeSearch(queryParams);
                        } else {
                           //TODO alertNoResults
                        }


                },controller);
            }
             /* else {
                if(selectedTown!=null && selectedTown!=""){
                    geocode(selectedTown,function(results){
                        var geoLocation = results[0].geometry.location;
                        queryParams.lat = geoLocation.lat();
                        queryParams.lng = geoLocation.lng();
                        this.executeSearch(queryParams);
                    },controller);
                } else {
                    this.executeSearch(queryParams);
                }
            }

              this.executeSearch(queryParams);*/

        }
    }
});

Esol.SearchResultController = Ember.Controller.extend({

    centreId: 0,
    map: null,

    actions: {

    },

    isFree: function(){
        return this.get('model.cost_free') == "y";
    }.property('model.cost_free'),

    hasAccessibility: function(){
        return this.get('centre.accessibility') == "y";
    }.property('centre.accessibility'),

    hasChildCare: function(){
    return this.get('model.child_care') == "y";
    }.property('model.child_care'),

    centre: function(){
        var centreId = this.get("centreId");
        if(this.get("model")!=null){
            return this.get("model.centres").find(function(centre){
                return centre.get("id") == centreId;
            });
        }
        return null;
    }.property("centreId","model"),

    actions: {
        search: function () {
            geocode(this.get("centre.fullAddress"),this.addressFound, this);
        }

    },

    addressFound: function(results){
        var mapVar = this.get("map");
        var geoLocation = results[0].geometry.location;
        var lat = geoLocation.lat();
        var lng = geoLocation.lng();
        mapVar.setZoom(14);
        mapVar.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({

            map: mapVar,
            position: results[0].geometry.location

        });
        this.get("model").set("location","POINT(" + lat + " " + lng+")");
    }

});

Esol.ApplicationController = Ember.ObjectController.extend({

    actions: {
        activeOption: function() {
            var currentlyEnabled = this.get("detailedSearchEnabled");
            this.set("detailedSearchEnabled", !currentlyEnabled);
        }

    }

});