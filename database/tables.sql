create table profile (
  id 				   serial,
  firstname 			   varchar(256) not null,
  lastname  			   varchar(256),
  email     			   varchar(256) not null,
  password  			   varchar(256) not null,
  PRIMARY KEY(id)
);

create table archive (
  id        			   serial,
  name      			   varchar(256) not null,
  homepage     			   varchar(256) not null,
  contactemail			   varchar(256) not null,
  PRIMARY KEY(id)
 );

create table user_image (
  id				   serial,
  profile_id			   integer,
  title				   TEXT not null, 
  created  		  	   timestamp default now(),
  url 		 		   varchar(256),
  PRIMARY KEY(id)
);

create table original_image (
  id 	     			   serial,
  archive_id			   integer NOT null,
  title				   TEXT not null, 
  artist			   varchar not null,
  year				   integer,
  source_image_url		   varchar(256) NOT null,
  FOREIGN KEY(archive_id) 	   REFERENCES archive(id),
  PRIMARY KEY(id)
);

create table adaptation (
  id 				   serial,
  user_image_id			   integer,
  original_image_id		   integer,
  FOREIGN KEY (original_image_id)  REFERENCES original_image(id),
  FOREIGN KEY (user_image_id)      REFERENCES user_image(id),
  PRIMARY KEY(id)
);
