create schema majumundur collate utf8mb4_0900_ai_ci;

create table users
(
	username varchar(50) not null
		primary key,
	password varchar(255) null,
	updated_at date null,
	created_at date null,
	role tinyint(1) null,
	point int null
)
charset=latin1;

create table products
(
	id int auto_increment
		primary key,
	merchant varchar(50) not null,
	name varchar(50) not null,
	price int not null,
	stock int not null,
	constraint merchant
		foreign key (merchant) references users (username)
			on update cascade on delete cascade
)
charset=latin1;

create table transactions
(
	id int auto_increment
		primary key,
	product int null,
	customer varchar(50) null,
	amount int null,
	created_at date null,
	updated_at date null,
	constraint customer
		foreign key (customer) references users (username)
			on update cascade on delete cascade,
	constraint product
		foreign key (product) references products (id)
			on update cascade on delete cascade
)
charset=latin1;


