/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     12/10/2017 10:27:37                          */
/*==============================================================*/


drop table if exists account;

drop table if exists transaction;

drop table if exists tree;

/*==============================================================*/
/* Table: account                                               */
/*==============================================================*/
create table account
(
   id_account           int not null auto_increment,
   pseudo               varchar(50),
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

/*==============================================================*/
/* Table: tree                                                  */
/*==============================================================*/
create table tree
(
   id_tree              int not null auto_increment,
   id_account           int not null,
   father               int,
   primary key (id_tree)
);

alter table transaction add constraint fk_recipient foreign key (recipient)
      references account (id_account) on delete restrict on update restrict;

alter table transaction add constraint fk_sender foreign key (sender)
      references account (id_account) on delete restrict on update restrict;

alter table tree add constraint fk_account foreign key (id_account)
      references account (id_account) on delete restrict on update restrict;

alter table tree add constraint fk_pere foreign key (father)
      references account (id_account) on delete restrict on update restrict;

