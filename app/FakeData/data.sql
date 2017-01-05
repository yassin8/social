select * from skills;
select * from course;
select * from social_user;


insert INTO  social_user (id,username,username_canonical,email,email_canonical,enabled,password)VALUES (4,'sebsi','sebsi','sebsi@gmail.com','sebsi@gmail.com',true,'sebsi');

INSERT INTO course values(1,'arabe','language');
INSERT INTO course values(2,'allemand','language');
INSERT INTO course values(3,'perse','language');
INSERT INTO course values(4,'anglais','language');
INSERT INTO course values(5,'français','language');
INSERT INTO course values(6,'grecque','language');
INSERT INTO course values(7,'chinois','language');
INSERT INTO course values(8,'perse','language');

INSERT INTO  skills(id,teacher_id_fk,course_id_fk,level) VALUES (1 ,1,1,3);
INSERT INTO  skills(id,teacher_id_fk,course_id_fk,level) VALUES (2 ,2,1,7);
INSERT INTO  skills(id,teacher_id_fk,course_id_fk,level) VALUES (3 ,1,3,9);
INSERT INTO  skills(id,teacher_id_fk,course_id_fk,level) VALUES (4 ,1,5,10);
INSERT INTO  skills(id,teacher_id_fk,course_id_fk,level) VALUES (5 ,3,3,10);

