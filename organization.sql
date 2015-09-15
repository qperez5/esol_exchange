CREATE
    TABLE organization
    (
        id bigint NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        address VARCHAR(200) NOT NULL,
        post_code VARCHAR(9) NOT NULL,
        contact_number VARCHAR(60) NOT NULL,
        contact_email VARCHAR(100) NOT NULL,
        contact_person VARCHAR(100),
        contact_web VARCHAR(100),
        esol_assesment text,
        tutors_qualified VARCHAR(1),
        tutors_qualified_condition text,
        courses_acreditated VARCHAR(1),
        courses_acreditation_condition text,
        how_acreditated text,
        core_curriculum VARCHAR(1),
        core_curriculum_condition text,
        referral_system text,
        classes_outside_newham text,
        other_information text,
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1