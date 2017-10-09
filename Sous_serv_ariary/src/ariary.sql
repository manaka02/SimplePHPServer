/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     09/10/2017 14:21:42                          */
/*==============================================================*/


drop table if exists account;

drop table if exists transaction;

/*==============================================================*/
/* Table: account                                               */
/*==============================================================*/
create table account
(
   id_account           int not null auto_increment,
   pseudo               varchar(50),
   father               varchar(50),
   idmobile             varchar(100),
   exptoken             varchar(100),
   connected            smallint,
   primary key (id_account)
);

/*==============================================================*/
/* Table: transaction                                           */
/*==============================================================*/
create table transaction
(
   id_transaction       int not null auto_increment,
   sender               int not null,
   recipient            int not null,
   currency             varchar(10),
   amount               double,
   date_transaction     datetime,
   type                 varchar(50),
   comment              varchar(150),
   primary key (id_transaction)
);

alter table transaction add constraint fk_recipient foreign key (recipient)
      references account (id_account) on delete restrict on update restrict;

alter table transaction add constraint fk_sender foreign key (sender)
      references account (id_account) on delete restrict on update restrict;

ALTER TABLE  `account` ADD UNIQUE (
`exptoken`
);

select * from transaction where 
sender in (select id_account from account where id_account = 3 or  father = 3)
 or recipient in (select id_account from account where id_account = 3 or  father = 3)


