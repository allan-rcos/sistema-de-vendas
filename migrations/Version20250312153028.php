<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312153028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria as tabelas de Produto e Pedido com createdAt';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, total DOUBLE PRECISION NOT NULL, forma_de_pagamento VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido_produto (pedido_id INT NOT NULL, produto_id INT NOT NULL, INDEX IDX_3ED5C1B94854653A (pedido_id), INDEX IDX_3ED5C1B9105CFD56 (produto_id), PRIMARY KEY(pedido_id, produto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, tipo_produto_id INT NOT NULL, description VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, INDEX IDX_5CAC49D781DAFF7E (tipo_produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B94854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B9105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D781DAFF7E FOREIGN KEY (tipo_produto_id) REFERENCES tipo_produto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_produto DROP FOREIGN KEY FK_3ED5C1B94854653A');
        $this->addSql('ALTER TABLE pedido_produto DROP FOREIGN KEY FK_3ED5C1B9105CFD56');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D781DAFF7E');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_produto');
        $this->addSql('DROP TABLE produto');
    }
}
