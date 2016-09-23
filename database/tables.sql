-- information about the user submitting images --
create table profile (
  id serial,
  firstname varchar(256),
  lastname  varchar(256),
  email varchar(256),
  password varchar(256)
);

-- information about which remote archive the image is coming from --
create table archive (
  id serial,
  name varchar(256),
  url varchar(256)
 );

-- original image from the archive --
create table image (
  id serial,
  artist varchar(256),
  location varchar(256),
  year  integer,
  genre varchar(256),
  archive_id integer,
  url  varchar(256), -- url to access image on remote archive
  FOREIGN KEY(archive_id) REFERENCES(archive)
);

create table user_image (
  id serial,
  profile_id integer,
  image_id integer,  -- original url
  url  varchar(256), -- url to access image on local server
  created datetime,
  FOREIGN KEY(user_id) references profile(id),
  FOREIGN KEY(image_id) references image(id)
);

-- tag to apply to an image or user image --
create table tag (
  id serial,
  name varchar(256)
);

-- tags applied to an image --
create table image_tag (
  id serial,
  image_id integer,
  tag_id integer,
  FOREIGN KEY(image_id) REFERENCES image(id)
);

-- tags applied to a user image --
create table user_image_tag (
  id serial,
  image_id integer,
  user_image_id integer,
  FOREIGN KEY(user_image_id) REFERENCES user_image(id),
  FOREIGN KEY(tag_id) REFERENCES tag(id)
);
