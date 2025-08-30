INSERT INTO member(full_name,email,dept,member_type) VALUES
('Ayesha Rahman','ayesha@ewubd.edu','CSE','Student'),
('Tanvir Hasan','tanvir@ewubd.edu','EEE','Student');

INSERT INTO staff(full_name,role_title) VALUES ('Md. Shafiq','Chief Librarian');

INSERT INTO category(name) VALUES ('Computer Science'),('Economics'),('Literature');

INSERT INTO author(name) VALUES ('Thomas H. Cormen'),('Robert Sedgewick'),('Hal R. Varian');

INSERT INTO book(isbn,title,publisher,publish_year,category_id,total_copies,available_copies) VALUES
('9780262033848','Introduction to Algorithms','MIT Press',2009,1,5,5),
('9780321573513','Algorithms','Addison-Wesley',2011,1,3,3),
('9780393971652','Intermediate Microeconomics','W. W. Norton',2014,2,4,4);

INSERT INTO book_author VALUES (1,1);
INSERT INTO book_author VALUES (2,2);
INSERT INTO book_author VALUES (3,3);

COMMIT;
