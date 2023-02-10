create table user_details
(
    id        serial
        constraint id
            primary key,
    firstname varchar(50)  not null,
    surname   varchar(100) not null,
    country   varchar(50)  not null,
    city      varchar(50)
);

create table users
(
    login           varchar(50)              not null
        constraint login
            primary key,
    id_user_details integer                  not null
        constraint users_user_details_id_fk
            references user_details
            on update cascade on delete cascade,
    email           varchar(250)             not null,
    password        varchar(255)             not null,
    role            varchar(25) default USER not null
);

create table friendship
(
    "requesterLogin" varchar(50) not null
        constraint friendship_users_login_fk
            references users
            on update cascade on delete cascade,
    "AddresserLogin" varchar(50) not null
        constraint friendship_users_login_fk2
            references users
            on update cascade on delete cascade
);

create table events
(
    id           serial
        constraint events_pk
            primary key,
    name         varchar(255) not null,
    description  text         not null,
    place        varchar(100) not null,
    "eventDate"  date         not null,
    "eventTime"  time         not null,
    type         varchar(100),
    "maxNumber"  integer      not null,
    access       varchar(50)  not null,
    id_organizer varchar(50)  not null
        constraint events_users_login_fk
            references users
            on update cascade on delete cascade
);

create table user_events
(
    login_user varchar(50) not null
        constraint user_events_users_login_fk
            references users
            on update cascade on delete cascade,
    id_event   integer     not null
        constraint user_events_events_id_fk
            references events
            on update cascade on delete cascade
);

create table comments
(
    id         serial
        constraint comments_pk
            primary key,
    id_event   integer     not null
        constraint comments_events_id_fk
            references events
            on update cascade on delete cascade,
    login_user varchar(50) not null
        constraint comments_users_login_fk
            references users
            on update cascade on delete cascade,
    content    text        not null,
    add_date   timestamp   not null
);


create view event_attendees(id, name, number_of_attendees, "maxNumber") as
SELECT e.id,
       e.name,
       COALESCE(count(ue.login_user) + 1, 1::bigint) AS number_of_attendees,
       e."maxNumber"
FROM events e
         LEFT JOIN user_events ue ON e.id = ue.id_event
GROUP BY e.id, e.name, e."maxNumber";

INSERT INTO user_details VALUES (1,'Marek','Kowal','Polska','Kraków');
INSERT INTO user_details VALUES (2,'Adam','Pierogy','Wielka Brytania','Liverpool');
INSERT INTO users VALUES ('marek',1,'marek@wp.pl','$2y$10$flUHa4mW1nKXkbc0eM.S2eQcUiLa2EOPuxCPj3wiQhIDeXjESV68q','USER');
INSERT INTO users VALUES ('adam',2,'adam@wp.pl','$2y$10$flUHa4mW1nKXkbc0eM.S2eQcUiLa2EOPuxCPj3wiQhIDeXjESV68q','ADMIN');
INSERT INTO friendship VALUES ('marek','adam');
INSERT INTO events VALUES (1,'Granie w planszowki','Plan jest taki ze spotykamy sie w barze z planszowkami i gramy w Gre o TRON','Planszuwkarnia Krakow','2023-02-11','18:00','integracja',10,'public','marek');
INSERT INTO events VALUES (2,'Pomoc w remoncie','Potrzebuje pomocy przy remoncie na dzialkach','Gdzies w KRK','2023-02-15','10:00','wolontariat',5,'private','adam');
INSERT INTO user_events VALUES ('adam',1);
INSERT INTO user_events VALUES ('marek',2);
INSERT INTO comments VALUES (1,1,'adam','Bede + postaram sie zoorganizowac kilka osob','2023-02-10 13:00');
INSERT INTO comments VALUES (2,2,'marek','Wpadne pomoc ;)','2023-02-09 21:00');



