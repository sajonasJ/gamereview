-- Drop tables if they exist
drop table if exists reviews;
drop table if exists items;
drop table if exists users;
drop table if exists manufacturers;

-- Create users table
create table users (
    id integer not null primary key autoincrement,
    username text not null
);

-- Create manufacturers table
create table manufacturers (
    id integer not null primary key autoincrement,
    name text not null
);

-- Create items table
create table items (
    id integer not null primary key autoincrement,
    name text not null,
    manufacturer integer not null,
    ave_rating integer not null,
    review_count integer not null,
    foreign key (manufacturer) references manufacturers(id)
);

-- Create reviews table
create table reviews (
    id integer not null primary key autoincrement,
    item_id integer not null,
    user_id integer not null,
    rating integer not null,
    review text not null,
    foreign key (item_id) references items(id),
    foreign key (user_id) references users(id)
);

-- Insert data into users
insert into users (id, username) values (1, 'sajonasj');
insert into users (id, username) values (2, 'jonasj');

-- Insert data into manufacturers
insert into manufacturers (id, name) values (1, 'Ubisoft');
insert into manufacturers (id, name) values (2, 'Activision Blizzard');
insert into manufacturers (id, name) values (3, 'Riot Games');

-- Insert data into items
insert into items (id, name, manufacturer, ave_rating, review_count)
values (1, 'Assassins Creed Valhalla', 1, 5, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (2, 'Assassins Creed Mirage', 1, 4, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (3, 'Star Wars Outlaws', 1, 2, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (4, 'Skull and Bones', 1, 3, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (5, 'Far Cry 6', 1, 3, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (6, 'The Crew Motorfest', 1, 2, 1);

-- Insert data into reviews
insert into reviews (id, item_id, user_id, rating, review)
values (1, 1, 1, 5, 'Amazing game!');
insert into reviews (id, item_id, user_id, rating, review)
values (2, 2, 2, 4, 'Good game, but could be better.');
insert into reviews (id, item_id, user_id, rating, review)
values (3, 3, 1, 2, 'Not really what I expected.');
insert into reviews (id, item_id, user_id, rating, review)
values (4, 4, 2, 3, 'Decent game, some issues though.');


-- Insert data into items for Activision Blizzard
insert into items (id, name, manufacturer, ave_rating, review_count)
values (7, 'World of Warcraft', 2, 5, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (8, 'Diablo III', 2, 4, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (9, 'StarCraft', 2, 5, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (10, 'Diablo', 2, 4, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (11, 'Diablo II', 2, 4, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (12, 'Warcraft III', 2, 5, 1);

-- Insert data into items for Riot Games
insert into items (id, name, manufacturer, ave_rating, review_count)
values (13, 'League of Legends', 3, 5, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (14, 'Teamfight Tactics', 3, 4, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (15, 'Valorant', 3, 5, 1);
insert into items (id, name, manufacturer, ave_rating, review_count)
values (16, 'League of Legends Wild Rift', 3, 4, 1);

-- Insert random reviews for Activision Blizzard games
insert into reviews (id, item_id, user_id, rating, review)
values (5, 7, 1, 5, 'A classic, can never go wrong with WoW!');
insert into reviews (id, item_id, user_id, rating, review)
values (6, 8, 2, 4, 'Diablo III was great, but I miss the darker tones.');
insert into reviews (id, item_id, user_id, rating, review)
values (7, 9, 1, 5, 'StarCraft is legendary, best strategy game ever!');
insert into reviews (id, item_id, user_id, rating, review)
values (8, 10, 2, 4, 'Diablo is fun, but a bit outdated now.');
insert into reviews (id, item_id, user_id, rating, review)
values (9, 11, 1, 4, 'Diablo II is a timeless classic, love it!');
insert into reviews (id, item_id, user_id, rating, review)
values (10, 12, 2, 5, 'Warcraft III is still a top-tier RTS!');

-- Insert random reviews for Riot Games games
insert into reviews (id, item_id, user_id, rating, review)
values (11, 13, 1, 5, 'League of Legends is addictive, so much fun.');
insert into reviews (id, item_id, user_id, rating, review)
values (12, 14, 2, 4, 'Teamfight Tactics is a great game to relax and strategize.');
insert into reviews (id, item_id, user_id, rating, review)
values (13, 15, 1, 5, 'Valorant is so intense, love the tactical gameplay.');
insert into reviews (id, item_id, user_id, rating, review)
values (14, 16, 2, 4, 'Wild Rift is a nice mobile version, but not as deep as the main game.');