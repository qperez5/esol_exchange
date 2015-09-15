CREATE
    TABLE course_centre
    (
        course_id bigint NOT NULL,
        centre_id bigint NOT NULL,
        PRIMARY KEY (course_id, centre_id),
        FOREIGN KEY (course_id) REFERENCES course (id) ,
        FOREIGN KEY (centre_id) REFERENCES centre (id),
        INDEX fk_centre (centre_id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1