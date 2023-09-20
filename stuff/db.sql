create database `blog`;

use `blog`;

create table `msgs`(
    `id` int auto_increment,
    `title` varchar(255) not null default '',
    `msg` text,
    `created` timestamp default current_timestamp,
    primary key (`id`)
);

create procedure spReadData()
begin
    select `id`, `title`, `msg`, unix_timestamp(`created`) as `created`
        from `msgs`
        order by `id` desc;
end

create procedure spCreateData(in title varchar(255), in msg text)
begin
    insert into `msgs`(`title`, `msg`)
        values(title, msg);
end

-- call spCreateData('First post', 'This is a my first post');
-- call spCreateData('Second post', 'This is a my second post');

-- select * from `msgs`;
-- call spReadData();

create procedure spReadDataById(in idx int)
begin
    select `id`, `title`, `msg`, unix_timestamp(`created`) as `created`
        from `msgs`
        where `id` = idx;
end

-- call spReadDataById(2);

create procedure spUpdateData(in idx int, in title varchar(255), in msg text)
begin
    update `msgs` set
        `title` = title,
        `msg` = msg
    where `id` = idx;
end

-- call spUpdateData(2, 'Second post', 'This is a new text for second post');

create procedure spDeleteData(in idx int)
begin
    delete from `msgs`
        where `id` = idx;
end;

-- call spDeleteData(2);