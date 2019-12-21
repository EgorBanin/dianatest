use `dianatest`;

drop table if exists `customers`;
create table `customers` (
	`id` int unsigned not null auto_increment,
	`name` varchar(255) not null,
	`isActive` boolean not null,
	`ct` int unsigned not null comment 'timestamp',
	primary key (`id`)
)
engine InnoDB;