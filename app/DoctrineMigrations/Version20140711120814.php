<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20140711120814 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE gamejam_challenges_challenge (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, user_id INT DEFAULT NULL, temp TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, nameSlug VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, completed TINYINT(1) NOT NULL, completions SMALLINT NOT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_5C584F3EE48FD905 (game_id), INDEX IDX_5C584F3EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE gamejam_challenges_challenge ADD CONSTRAINT FK_5C584F3EE48FD905 FOREIGN KEY (game_id) REFERENCES gamejam_games (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE gamejam_challenges_challenge ADD CONSTRAINT FK_5C584F3EA76ED395 FOREIGN KEY (user_id) REFERENCES gamejam_users (id)");
        $this->addSql("ALTER TABLE gamejam_compos_activity DROP FOREIGN KEY FK_FE213525E48FD905");
        $this->addSql("ALTER TABLE gamejam_compos_activity ADD CONSTRAINT FK_FE213525E48FD905 FOREIGN KEY (game_id) REFERENCES gamejam_games (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE gamejam_compos_applications ADD assisted TINYINT(1) NOT NULL, ADD dni VARCHAR(255) NOT NULL, ADD additionalData VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE gamejam_games ADD image_id INT DEFAULT NULL, DROP image");
        $this->addSql("ALTER TABLE gamejam_games ADD CONSTRAINT FK_98394EDC3DA5256D FOREIGN KEY (image_id) REFERENCES gamejam_games_media (id) ON DELETE SET NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_98394EDC3DA5256D ON gamejam_games (image_id)");
        $this->addSql("ALTER TABLE gamejam_games_media DROP FOREIGN KEY FK_1C08298FE48FD905");
        $this->addSql("ALTER TABLE gamejam_games_media ADD name VARCHAR(255) NOT NULL, ADD original_name VARCHAR(255) DEFAULT NULL, ADD size INT DEFAULT NULL, ADD metadata LONGTEXT DEFAULT NULL COMMENT '(DC2Type:array)', ADD copywrite VARCHAR(255) DEFAULT NULL, ADD author VARCHAR(255) DEFAULT NULL, ADD title VARCHAR(255) DEFAULT NULL, ADD caption VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD hash VARCHAR(255) NOT NULL, ADD version INT DEFAULT 1 NOT NULL, ADD enabled TINYINT(1) NOT NULL, CHANGE url url VARCHAR(255) DEFAULT NULL");
        $this->addSql("ALTER TABLE gamejam_games_media ADD CONSTRAINT FK_1C08298FE48FD905 FOREIGN KEY (game_id) REFERENCES gamejam_games (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE gamejam_users ADD lastIp VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("DROP TABLE gamejam_challenges_challenge");
        $this->addSql("ALTER TABLE gamejam_compos_activity DROP FOREIGN KEY FK_FE213525E48FD905");
        $this->addSql("ALTER TABLE gamejam_compos_activity ADD CONSTRAINT FK_FE213525E48FD905 FOREIGN KEY (game_id) REFERENCES gamejam_games (id)");
        $this->addSql("ALTER TABLE gamejam_compos_applications DROP assisted, DROP dni, DROP additionalData");
        $this->addSql("ALTER TABLE gamejam_games DROP FOREIGN KEY FK_98394EDC3DA5256D");
        $this->addSql("DROP INDEX UNIQ_98394EDC3DA5256D ON gamejam_games");
        $this->addSql("ALTER TABLE gamejam_games ADD image VARCHAR(255) DEFAULT NULL, DROP image_id");
        $this->addSql("ALTER TABLE gamejam_games_media DROP FOREIGN KEY FK_1C08298FE48FD905");
        $this->addSql("ALTER TABLE gamejam_games_media DROP name, DROP original_name, DROP size, DROP metadata, DROP copywrite, DROP author, DROP title, DROP caption, DROP description, DROP hash, DROP version, DROP enabled, CHANGE url url VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE gamejam_games_media ADD CONSTRAINT FK_1C08298FE48FD905 FOREIGN KEY (game_id) REFERENCES gamejam_games (id)");
        $this->addSql("ALTER TABLE gamejam_users DROP lastIp");
    }
}