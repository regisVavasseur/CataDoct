-- Adminer 4.8.1 PostgreSQL 13.1 (Debian 13.1-1.pgdg100+1) dump

DROP TABLE IF EXISTS "categorie";
DROP SEQUENCE IF EXISTS categorie_id_seq;
CREATE SEQUENCE categorie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."categorie" (
    "id" integer DEFAULT nextval('categorie_id_seq') NOT NULL,
    "libelle" character varying NOT NULL,
    CONSTRAINT "categorie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "produit";
DROP SEQUENCE IF EXISTS produit_id_seq;
CREATE SEQUENCE produit_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."produit" (
    "id" integer DEFAULT nextval('produit_id_seq') NOT NULL,
    "numero" integer NOT NULL,
    "libelle" character varying NOT NULL,
    "description" text,
    "image" character varying,
    "categorie_id" integer,
    CONSTRAINT "produit_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "taille";
DROP SEQUENCE IF EXISTS taille_id_seq;
CREATE SEQUENCE taille_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."taille" (
    "id" integer DEFAULT nextval('taille_id_seq') NOT NULL,
    "libelle" character varying NOT NULL,
    CONSTRAINT "taille_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "tarif";
DROP SEQUENCE IF EXISTS tarif_id_seq;
CREATE SEQUENCE tarif_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."tarif" (
    "produit_id" integer NOT NULL,
    "taille_id" integer NOT NULL,
    "tarif" numeric NOT NULL,
    "id" integer DEFAULT nextval('tarif_id_seq') NOT NULL,
    CONSTRAINT "tarif_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2023-10-30 08:35:21.313699+00
