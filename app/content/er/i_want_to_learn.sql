drop database if exists iwtl;
create database iwtl character set utf8mb4;
use iwtl;
create table `user`(
   id int primary key not null auto_increment,
   username varchar(50) not null,
   `password` varchar(255) not null,
   email varchar(255) not null,
   registrationDate datetime not null default current_timestamp,
   `role` tinyint not null default 0,
   -- 0 - user, 1 - admin
   lastLogin datetime default current_timestamp,
   banned bit not null default 0,
   dateBanned datetime default current_timestamp
);
create table topic(
   id int primary key not null auto_increment,
   `name` varchar(255) not null,
   `description` text not null,
   datePosted datetime not null default current_timestamp,
   user int not null,
   image int
);
create table suggestion(
   id int primary key not null auto_increment,
   `user` int not null,
   title varchar(255) not null,
   topic int not null,
   datePosted datetime not null default current_timestamp,
   shortDescription varchar(255) not null,
   longDescription text
);
create table image(
   id int primary key not null auto_increment,
   `user` int not null,
   filePath varchar(255) not null,
   datePosted datetime not null default current_timestamp,
   altText varchar(255),
   suggestion int
);
create table userTopicSubscription(
   `user` int not null,
   topic int not null,
   subscribedSince datetime not null default current_timestamp
);
create table userSuggestionReview(
   `user` int not null,
   suggestion int not null,
   userScore tinyint not null default 1,
   dateReviewed datetime not null default current_timestamp
);
alter table topic
add foreign key (image) references image(id);
alter table topic
add foreign key (user) references user(id);
alter table suggestion
add foreign key (user) references user(id);
alter table suggestion
add foreign key (topic) references topic(id);
alter table image
add foreign key (user) references user(id);
alter table image
add foreign key (suggestion) references suggestion(id);
alter table userTopicSubscription
add foreign key (user) references user(id);
alter table userTopicSubscription
add foreign key (topic) references topic(id);
alter table userSuggestionReview
add foreign key (user) references user(id);
alter table userSuggestionReview
add foreign key (suggestion) references suggestion(id);