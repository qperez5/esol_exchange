drop table if exists course_centre;
drop table if exists course;
drop table if exists organization;
drop table if exists centre;

create table organization (
id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(100) NOT NULL,
address  varchar(200) NOT NULL,
post_code varchar(9) NOT NULL,
contact_number varchar(60) NOT NULL,
contact_email varchar(100) NOT NULL,
contact_person varchar(100),
contact_web varchar(100),
esol_assesment text,
tutors_qualified varchar(1),
tutors_qualified_condition text,
courses_acreditated varchar(1),
courses_acreditation_condition text,
how_acreditated text,
core_curriculum varchar(1),
core_curriculum_condition text,
referral_system text,
classes_outside_newham text,
other_information text
) engine = 'INNODB';

create table centre (
id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(100) NOT NULL,
location POINT NOT NULL,
post_code varchar (7) NOT NULL,
address  text NOT NULL,
buses text,
tube text,
accebility varchar(1),
accebility_condition text,
other_information text,
FULLTEXT centre_search (address, post_code)
) engine = 'INNODB';

create table course (
id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(100) NOT NULL,
class_type varchar(300),
levels varchar(200),
who_join text,
how_join text, 
when_join text,
how_long text,
cost_free varchar(1),
cost_condition text,
times text NOT NULL,
documentation_required text,
contact_phone varchar(200),
contact_email varchar(200),
contact_person varchar(200),
child_care varchar(1),
child_care_condition text,
organization_id bigint NOT NULL,
other_information text,
FULLTEXT course_search (name, levels),
FOREIGN KEY fk_organization (organization_id) REFERENCES organization(id)
) engine = 'INNODB';

create table course_centre (
course_id bigint NOT NULL,
centre_id bigint NOT NULL,
PRIMARY KEY (course_id,centre_id),
FOREIGN KEY fk_course (course_id) REFERENCES course(id),
FOREIGN KEY fk_centre (centre_id) REFERENCES centre(id)
) engine = 'INNODB';
