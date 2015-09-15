CREATE
    TABLE centre
    (
        id bigint NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        location point NOT NULL,
        post_code VARCHAR(7) NOT NULL,
        address text NOT NULL,
        buses text,
        tube text,
        accebility VARCHAR(1),
        accebility_condition text,
        other_information text,
        PRIMARY KEY (id),
        INDEX centre_search USING FULLTEXT (address, post_code)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1