CREATE
    TABLE course
    (
        id bigint NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        class_type VARCHAR(300),
        levels VARCHAR(200),
        who_join text,
        how_join text,
        when_join text,
        how_long text,
        cost_free VARCHAR(1),
        cost_condition text,
        times text NOT NULL,
        documentation_required text,
        contact_phone VARCHAR(200),
        contact_email VARCHAR(200),
        contact_person VARCHAR(200),
        child_care VARCHAR(1),
        child_condition text,
        organization_id bigint NOT NULL,
        other_information text,
        PRIMARY KEY (id),
        FOREIGN KEY (organization_id) REFERENCES organization (id),
        INDEX fk_organization (organization_id),
        INDEX course_search USING FULLTEXT (name, levels)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1