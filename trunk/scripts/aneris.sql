/*
Aneris - A Web-based Issue Tracker
Copyright (C) 2010 Benjamin Hale

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Contact Information
email: webmaster.arasaia@gmail.com

physical address: 2151 Highway 16
                  Searcy, AR 72143
*/

/* create main Aneris database */
create database aneris;

/* issues table */
create table aneris.issues (
       id    	   int unsigned not null auto_increment primary key,
       initializer varchar(15)  not null,
       owner	   varchar(15)  not null,
       title	   text		not null,
       description text		not null,
       status	   varchar(15)  not null default 'incomplete',
       updated	   timestamp	on update current_timestamp not null default current_timestamp
);

/* users table */
create table aneris.users (
       username varchar(15) not null primary key,
       password text not null,
       admin boolean not null default false
);

create table aneris.statuses (
       status varchar(15) not null primary key
);

insert into aneris.statuses values ('complete');
insert into aneris.statuses values ('deleted');
insert into aneris.statuses values ('incomplete');
insert into aneris.statuses values ('pending');

/* uncomment next line and replace bracketed values to generate first admin user, if wanted */
/*insert into aneris.users values ([[ADMINUSER]],md5('[[ADMINPASSWORD]]'),true);*/