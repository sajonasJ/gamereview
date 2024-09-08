drop table if exists game;
drop table if exists user;
drop table if exists publisher;
drop table if exists review;


-- Create user table
create table user (
    id integer not null primary key autoincrement,
    username text not null
);

-- Create publishers table
create table publisher (
    id integer not null primary key autoincrement,
    name text not null
);

-- Create games table
create table game (
    id integer not null primary key autoincrement,
    name text not null,
    publisher_id integer not null,
    foreign key (publisher_id) references publisher(id)
);

-- Create reviews table
create table review (
    id integer not null primary key autoincrement,
    game_id integer not null,
    user_id integer not null,
    rating integer not null,
    review text not null,
    foreign key (game_id) references game(id),
    foreign key (user_id) references user(id)
);

-- Insert data into users
insert into user (id, username) values (1, 'sajonasj');
insert into user (id, username) values (2, 'jonasj');

-- Insert data into publishers
insert into publisher (id, name) values (1, 'Ubisoft');
insert into publisher (id, name) values (2, 'Activision Blizzard');
insert into publisher (id, name) values (3, 'Riot Games');

-- Insert data into games
insert into game (id, name, publisher_id)
values (1, 'Assassins Creed Valhalla', 1);
insert into game (id, name, publisher_id)
values (2, 'Assassins Creed Mirage', 1);
insert into game (id, name, publisher_id)
values (3, 'Star Wars Outlaws', 1);
insert into game (id, name, publisher_id)
values (4, 'Skull and Bones', 1);
insert into game (id, name, publisher_id)
values (5, 'Far Cry 6', 1);
insert into game (id, name, publisher_id )
values (6, 'The Crew Motorfest', 1);

-- Insert data into reviews
insert into review (id, game_id, user_id, rating, review)
values (1, 1, 1, 5, 'Amazing game!');
insert into review (id, game_id, user_id, rating, review)
values (2, 2, 2, 4, 'Good game, but could be better.');
insert into review (id, game_id, user_id, rating, review)
values (3, 3, 1, 2, 'Not really what I expected.');
insert into review (id, game_id, user_id, rating, review)
values (4, 4, 2, 3, 'Decent game, some issues though.');


-- Insert data into items for Activision Blizzard
insert into game (id, name, publisher_id )
values (7, 'World of Warcraft', 2);
insert into game (id, name, publisher_id )
values (8, 'Diablo III', 2);
insert into game (id, name, publisher_id )
values (9, 'StarCraft', 2);
insert into game (id, name, publisher_id )
values (10, 'Diablo', 2);
insert into game (id, name, publisher_id )
values (11, 'Diablo II', 2);
insert into game (id, name, publisher_id )
values (12, 'Warcraft III', 2);

-- Insert data into items for Riot Games
insert into game (id, name, publisher_id)
values (13, 'League of Legends', 3 );
insert into game (id, name, publisher_id)
values (14, 'Teamfight Tactics', 3);
insert into game (id, name, publisher_id)
values (15, 'Valorant', 3 );
insert into game (id, name, publisher_id)
values (16, 'League of Legends Wild Rift', 3);

-- Insert random reviews for Activision Blizzard games
insert into review (id, game_id, user_id, rating, review)
values (5, 7, 1, 5, 'A classic, can never go wrong with WoW!');
insert into review (id, game_id, user_id, rating, review)
values (6, 8, 2, 4, 'Diablo III was great, but I miss the darker tones.');
insert into review (id, game_id, user_id, rating, review)
values (7, 9, 1, 5, 'StarCraft is legendary, best strategy game ever!');
insert into review (id, game_id, user_id, rating, review)
values (8, 10, 2, 4, 'Diablo is fun, but a bit outdated now.');
insert into review (id, game_id, user_id, rating, review)
values (9, 11, 1, 4, 'Diablo II is a timeless classic, love it!');
insert into review (id, game_id, user_id, rating, review)
values (10, 12, 2, 5, 'Warcraft III is still a top-tier RTS!');

-- Insert random reviews for Riot Games games
insert into review (id, game_id, user_id, rating, review)
values (11, 13, 1, 5, 'League of Legends is addictive, so much fun.');
insert into review (id, game_id, user_id, rating, review)
values (12, 14, 2, 4, 'Teamfight Tactics is a great game to relax and strategize.');
insert into review (id, game_id, user_id, rating, review)
values (13, 15, 1, 5, 'Valorant is so intense, love the tactical gameplay.');
insert into review (id, game_id, user_id, rating, review)
values (14, 16, 2, 4, 'Wild Rift is a nice mobile version, but not as deep as the main game.');