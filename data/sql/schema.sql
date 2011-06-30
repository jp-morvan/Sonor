CREATE TABLE album (id BIGINT AUTO_INCREMENT, titre VARCHAR(255), id_artiste BIGINT, slug VARCHAR(255), UNIQUE INDEX album_sluggable_idx (slug), INDEX id_artiste_idx (id_artiste), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE albums_users (id BIGINT AUTO_INCREMENT, id_album BIGINT NOT NULL, id_user BIGINT NOT NULL, INDEX id_album_idx (id_album), INDEX id_user_idx (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE artiste (id BIGINT AUTO_INCREMENT, nom VARCHAR(255), slug VARCHAR(255), UNIQUE INDEX artiste_sluggable_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE chanson (id BIGINT AUTO_INCREMENT, titre VARCHAR(255), duree TIME, audio_file VARCHAR(255), id_album BIGINT, slug VARCHAR(255), UNIQUE INDEX chanson_sluggable_idx (slug), INDEX id_album_idx (id_album), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE chansons_playlists (id BIGINT AUTO_INCREMENT, id_playlist BIGINT NOT NULL, id_chanson BIGINT NOT NULL, INDEX id_playlist_idx (id_playlist), INDEX id_chanson_idx (id_chanson), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE playlist (id BIGINT AUTO_INCREMENT, titre VARCHAR(255), id_user BIGINT, slug VARCHAR(255), UNIQUE INDEX playlist_sluggable_idx (slug), INDEX id_user_idx (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE album ADD CONSTRAINT album_id_artiste_artiste_id FOREIGN KEY (id_artiste) REFERENCES artiste(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE albums_users ADD CONSTRAINT albums_users_id_user_sf_guard_user_id FOREIGN KEY (id_user) REFERENCES sf_guard_user(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE albums_users ADD CONSTRAINT albums_users_id_album_album_id FOREIGN KEY (id_album) REFERENCES album(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE chanson ADD CONSTRAINT chanson_id_album_album_id FOREIGN KEY (id_album) REFERENCES album(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE chansons_playlists ADD CONSTRAINT chansons_playlists_id_playlist_playlist_id FOREIGN KEY (id_playlist) REFERENCES playlist(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE chansons_playlists ADD CONSTRAINT chansons_playlists_id_chanson_chanson_id FOREIGN KEY (id_chanson) REFERENCES chanson(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE playlist ADD CONSTRAINT playlist_id_user_sf_guard_user_id FOREIGN KEY (id_user) REFERENCES sf_guard_user(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
