-- Drop tables if they exist
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
    description text not null,
    publisher_id integer not null,
    foreign key (publisher_id) references publisher(id)
);

-- Create reviews table with unique constraint on (game_id, user_id)
create table review (
    id integer not null primary key autoincrement,
    game_id integer not null,
    user_id integer not null,
    rating integer not null,
    review text not null,
    foreign key (game_id) references game(id),
    foreign key (user_id) references user(id),
    unique (game_id, user_id) -- Ensure a user can only review a game once
);

-- Insert data into users (adding more users)
insert into user (id, username) values (1, 'sajonasj');
insert into user (id, username) values (2, 'jonasj');
insert into user (id, username) values (3, 'alexg');
insert into user (id, username) values (4, 'markm');
insert into user (id, username) values (5, 'johndoe');
insert into user (id, username) values (6, 'janedoe');

-- Insert data into publishers
insert into publisher (id, name) values (1, 'Ubisoft');
insert into publisher (id, name) values (2, 'Activision Blizzard');
insert into publisher (id, name) values (3, 'Riot Games');

-- Insert data into games with descriptions
insert into game (id, name, description, publisher_id)
values (1, 'Assassins Creed Valhalla', 'An open-world action-adventure game set in the Viking era.', 1);
insert into game (id, name, description, publisher_id)
values (2, 'Assassins Creed Mirage', 'A stealth-focused Assassins Creed adventure.', 1);
insert into game (id, name, description, publisher_id)
values (3, 'Star Wars Outlaws', 'An open-world game set in the Star Wars universe.', 1);
insert into game (id, name, description, publisher_id)
values (4, 'Skull and Bones', 'A pirate-themed naval combat game.', 1);
insert into game (id, name, description, publisher_id)
values (5, 'Far Cry 6', 'A first-person shooter set in a fictional Caribbean country.', 1);
insert into game (id, name, description, publisher_id)
values (6, 'The Crew Motorfest', 'An open-world racing game.', 1);

insert into game (id, name, description, publisher_id)
values (7, 'World of Warcraft', 'An MMORPG set in the world of Azeroth.', 2);
insert into game (id, name, description, publisher_id)
values (8, 'Diablo III', 'An action role-playing game set in a dark fantasy world.', 2);
insert into game (id, name, description, publisher_id)
values (9, 'StarCraft', 'A real-time strategy game set in a sci-fi universe.', 2);
insert into game (id, name, description, publisher_id)
values (10, 'Diablo', 'The original action RPG set in a dark dungeon world.', 2);
insert into game (id, name, description, publisher_id)
values (11, 'Diablo II', 'A dark fantasy action RPG.', 2);
insert into game (id, name, description, publisher_id)
values (12, 'Warcraft III', 'A real-time strategy game with base-building.', 2);

insert into game (id, name, description, publisher_id)
values (13, 'League of Legends', 'A multiplayer online battle arena game (MOBA).', 3);
insert into game (id, name, description, publisher_id)
values (14, 'Teamfight Tactics', 'An auto-battler strategy game.', 3);
insert into game (id, name, description, publisher_id)
values (15, 'Valorant', 'A tactical first-person shooter.', 3);
insert into game (id, name, description, publisher_id)
values (16, 'League of Legends Wild Rift', 'A mobile version of League of Legends.', 3);


insert into review (id, game_id, user_id, rating, review)
values (1, 2, 1, 4, 'Great stealth gameplay, loved it!');
insert into review (id, game_id, user_id, rating, review)
values (2, 3, 2, 3, 'Interesting concept, but not quite what I expected.');
insert into review (id, game_id, user_id, rating, review)
values (3, 13, 1, 5, 'Addictive, best MOBA out there!');


insert into review (id, game_id, user_id, rating, review)
values (4, 1, 1, 5, 'Amazing Viking experience, thoroughly enjoyed it!');
insert into review (id, game_id, user_id, rating, review)
values (5, 1, 2, 4, 'Beautiful world, some minor glitches.');
insert into review (id, game_id, user_id, rating, review)
values (6, 7, 3, 5, 'Best MMORPG, still going strong.');
insert into review (id, game_id, user_id, rating, review)
values (7, 7, 2, 4, 'Great world, but too grindy at times.');
insert into review (id, game_id, user_id, rating, review)
values (8, 9, 1, 5, 'The best RTS ever made!');
insert into review (id, game_id, user_id, rating, review)
values (9, 9, 2, 5, 'StarCraft is a timeless classic!');
insert into review (id, game_id, user_id, rating, review)
values (10, 15, 1, 5, 'Fantastic tactical gameplay.');
insert into review (id, game_id, user_id, rating, review)
values (11, 15, 3, 4, 'Great shooter, but needs more maps.');
