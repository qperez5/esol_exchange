var attr = DS.attr;
var belongsTo = DS.belongsTo;
var hasMany = DS.hasMany;

Esol.Organization = DS.Model.extend({
    name: attr("string"),
    address: attr("string"),
    post_code: attr("string"),
    contact_number: attr("string"),
    contact_email: attr("string"),
    contact_person: attr("string"),
    contact_web: attr("string"),
    esol_assesment: attr("string"),
    tutors_qualified: attr("string"),
    tutors_qualified_condition: attr("string"),
    courses_acreditated: attr("string"),
    courses_acreditation_condition: attr("string"),
    how_acreditated: attr("string"),
    core_curriculum: attr("string"),
    core_curriculum_condition: attr("string"),
    referral_system: attr("string"),
    classes_outside_newham: attr("string"),
    other_information: attr("string")
});

Esol.Course = DS.Model.extend({
    name: attr("string"),
    class_type: attr("string"),
    levels: attr("string"),
    who_join: attr("string"),
    how_join: attr("string"),
    when_join: attr("string"),
    how_long: attr("string"),
    cost_free: attr("string"),
    cost_condition: attr("string"),
    times: attr("string"),
    documentation_required: attr("string"),
    contact_phone: attr("string"),
    contact_email: attr("string"),
    contact_person: attr("string"),
    child_care: attr("string"),
    child_condition: attr("string"),
    other_information: attr("string"),
    organization: belongsTo("organization",{async: true}),
    centres: hasMany("centre",{async: true})
});

Esol.Centre = DS.Model.extend({
    name: attr("string"),
    location: attr("string"),
    post_code: attr("string"),
    address: attr("string"),
    buses: attr("string"),
    tube: attr("string"),
    accebility: attr("string"),
    accebility_condition: attr("string"),
    other_information: attr("string"),
    fullAddress: function(){
        return this.get("address") + " " + this.get("post_code");
    }.property("post_code","address"),

    latLng: function(){
        var location = this.get("location");
        if (location!=null) {
            var wktPattern = /POINT\((\-*\d*\.\d*) (\-*\d*\.\d*)\)/g;
            var results = wktPattern.exec(location);
            return {lat: Number(results[1]), lng: Number(results[2])};
        }
        return 0;
    }.property("location")

});