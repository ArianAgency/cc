SET foreign_key_checks = 0;

DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS businesses;
DROP TABLE IF EXISTS costumers;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS invoices;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS survey_questions;
DROP TABLE IF EXISTS survey_answers;
DROP TABLE IF EXISTS survey_results;
DROP TABLE IF EXISTS lotteries;
DROP TABLE IF EXISTS conditions;
DROP TABLE IF EXISTS lotteries_conditions_junction;
DROP TABLE IF EXISTS coupons;
# ------------------------------Roles--------------------------------------
DROP TABLE IF EXISTS roles;
create table roles
(
    id_roles     bigint unsigned auto_increment primary key,
    name_en      nvarchar(25)                        not null,
    name_fa      nvarchar(25)                        not null,
    access_level nvarchar(25) UNIQUE                 not null,
    created_at   timestamp DEFAULT CURRENT_TIMESTAMP not null,
    is_active    Boolean   DEFAULT TRUE              not null,
    is_deleted   Boolean   DEFAULT FALSE             not null
);
# ------------------------------Business--------------------------------------
DROP TABLE IF EXISTS businesses;
create table businesses
(
    id_businesses       bigint unsigned auto_increment primary key,
    brand_name          nvarchar(25) UNIQUE                               not null,
    company_name        nvarchar(25)                                      not null,
    company_type        nvarchar(25)                                      not null,
    foundation_date     DATE                                              not null,
    register_code       nvarchar(25)                                      not null,
    national_code       nvarchar(25)                                      not null,
    financial_code      nvarchar(25)                                      not null,
    company_field       nvarchar(25)                                      not null,
    address             nvarchar(25)                                      not null,
    phone               nvarchar(25)                                      not null,
    support_phone       nvarchar(25)                                      not null,
    mobile              nvarchar(25) UNIQUE                               not null,
    mobile_verified_at  timestamp                                         null,
    email               nvarchar(255)                                     null,
    email_verified_at   timestamp                                         null,
    work_time           nvarchar(25)                                      not null,
    logo_address        nvarchar(255)                                     null,
    have_social         Boolean                 DEFAULT FALSE             not null,
    company_size        int(255)                DEFAULT 0                 not null,
    is_parent           TINYINT(255) unsigned   DEFAULT 0                 not null,
    bank_account        int(255)                                          null,
    card_pre_number     nvarchar(25) UNIQUE                               not null,
    registration_origin nvarchar(25)                                      null,
    website             nvarchar(60)                                      null,
    finding_way         nvarchar(25)                                      null,
    have_hashtag        Boolean                 DEFAULT TRUE              not null,
    wallet              decimal(15, 2) unsigned DEFAULT 0.00              not null,
    score               int(28) unsigned        DEFAULT 0                 not null,
    password            nvarchar(255)                                     not null,
    remember_token      nvarchar(100)                                     null,
    created_at          timestamp               DEFAULT CURRENT_TIMESTAMP not null,
    updated_at          timestamp                                         null,
    is_active           Boolean                 DEFAULT TRUE              not null,
    is_deleted          Boolean                 DEFAULT FALSE             not null,

    constraint businesses_mobile_unique unique (mobile),
    constraint businesses_card_pre_number unique (card_pre_number),
    constraint businesses_email_unique unique (email)
);
# ------------------------------Costumers--------------------------------------
DROP TABLE IF EXISTS costumers;
create table costumers
(
    id_costumers        bigint unsigned auto_increment primary key,
    name                nvarchar(25)                                      not null,
    family              nvarchar(25)                                      not null,
    father_name         nvarchar(25)                                      not null,
    gender              nvarchar(25)                                      not null,
    mobile              nvarchar(25)                                      not null,
    mobile_verified_at  timestamp                                         null,
    phone               nvarchar(25)                                      null,
    email               nvarchar(255)                                     null,
    email_verified_at   timestamp                                         null,
    have_social         Boolean                 DEFAULT FALSE             not null,
    birthday            date                                              not null,
    marriage_status     nvarchar(25)                                      null,
    wedding_anniversary date                                              null,
    education           nvarchar(25)                                      null,
    field               nvarchar(25)                                      null,
    address             nvarchar(255)                                     null,
    registration_origin bigint unsigned                                   not null,
    website             nvarchar(60)                                      null,
    finding_way         nvarchar(25)                                      null,
    job                 nvarchar(25)                                      null,
    card_number         nvarchar(25)                                      null,
    wallet              decimal(15, 2) unsigned DEFAULT 0.00              not null,
    score               int(28) unsigned        DEFAULT 0                 not null,
    costumer_ip         varchar(15)                                       not null,
    password            nvarchar(255)                                     not null,
    remember_token      nvarchar(100)                                     null,
    created_at          timestamp               DEFAULT CURRENT_TIMESTAMP not null,
    updated_at          timestamp                                         null,
    is_active           Boolean                 DEFAULT TRUE              not null,
    is_deleted          Boolean                 DEFAULT FALSE             not null,

    constraint costumers_mobile_unique unique (mobile),
    constraint costumers_card_number unique (card_number),
    constraint costumers_email_unique unique (email),
    FOREIGN KEY (registration_origin) REFERENCES businesses (id_businesses)
);
# ------------------------------Users--------------------------------------
DROP TABLE IF EXISTS users;
create table users
(
    id_users            bigint unsigned auto_increment primary key,
    name                nvarchar(25)                                      not null,
    family              nvarchar(25)                                      not null,
    father_name         nvarchar(25)                                      not null,
    national_code       nvarchar(25)                                      not null,
    gender              nvarchar(25)                                      not null,
    mobile              nvarchar(25)                                      not null,
    mobile_verified_at  timestamp                                         null,
    phone               nvarchar(25)                                      null,
    email               nvarchar(255)                                     null,
    email_verified_at   timestamp                                         null,
    have_social         Boolean                 DEFAULT FALSE             not null,
    birthday            date                                              not null,
    marriage_status     nvarchar(25)                                      null,
    wedding_anniversary date                                              null,
    education           nvarchar(25)                                      null,
    field               nvarchar(25)                                      null,
    address             nvarchar(255)                                     null,
    registration_origin nvarchar(25)                                      null,
    website             nvarchar(60)                                      null,
    skill               nvarchar(25)                                      null,
    card_number         nvarchar(25)                                      null,
    wallet              decimal(15, 2) unsigned DEFAULT 0.00              not null,
    score               int(28) unsigned        DEFAULT 0                 not null,
    businesse_id        bigint unsigned                                   not null,
    role_id             bigint unsigned                                   not null,
    user_ip             varchar(15)                                       not null,
    password            nvarchar(255)                                     not null,
    remember_token      nvarchar(100)                                     null,
    created_at          timestamp               DEFAULT CURRENT_TIMESTAMP not null,
    updated_at          timestamp                                         null,
    is_active           Boolean                 DEFAULT TRUE              not null,
    is_deleted          Boolean                 DEFAULT FALSE             not null,

    constraint users_mobile_unique unique (mobile),
    constraint users_card_number unique (card_number),
    constraint users_email_unique unique (email),
    FOREIGN KEY (businesse_id) REFERENCES businesses (id_businesses),
    FOREIGN KEY (role_id) REFERENCES roles (id_roles)
);
# ------------------------------Invoices--------------------------------------
DROP TABLE IF EXISTS invoice_items;
create table invoice_items
(
    id_invoice_items bigint unsigned auto_increment primary key,
    id_costumer      bigint unsigned                     not null,
    invoice_no       bigint unsigned                     not null CHECK ( invoice_no > 0 ),
    id_service       bigint unsigned                     not null,
    count            int unsigned                        not null CHECK ( count > 0 ),
    sale_user_id     bigint unsigned                     not null,
    sale_user_ip     varchar(15)                         not null,
    is_edited        Boolean   DEFAULT FALSE             not null,
    created_at       timestamp DEFAULT CURRENT_TIMESTAMP not null,
    updated_at       timestamp                           null,

    FOREIGN KEY (id_costumer) REFERENCES costumers (id_costumers),
    FOREIGN KEY (id_service) REFERENCES services (id_services),
    FOREIGN KEY (sale_user_id) REFERENCES users (id_users)

);
# ------------------------------Product/Service---------------------------------
DROP TABLE IF EXISTS services;
create table services
(
    id_services     bigint unsigned auto_increment primary key,
    id_business     bigint unsigned                     not null,
    name            nvarchar(100)                       not null,
    price           decimal(15, 2) unsigned             not null CHECK ( price > 0.00 ),
    from_cash       decimal(15, 2) unsigned             not null,
    frome_wallet    decimal(15, 2) unsigned             not null,
    off_percent     int                                 not null CHECK ( off_percent > 0 ),
    creator_user_id bigint unsigned                     not null,
    creator_user_ip varchar(15)                         not null,
    is_edited       Boolean   DEFAULT FALSE             not null,
    created_at      timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at       timestamp                           null,
    updated_at      timestamp                           null,

    FOREIGN KEY (id_business) REFERENCES businesses (id_businesses)
);
# ------------------------------Survey Questions---------------------------------
DROP TABLE IF EXISTS survey_questions;
CREATE TABLE survey_questions
(
    id_survey_questions bigint unsigned auto_increment primary key,
    id_business         bigint unsigned                     not null,
    id_creator_user     bigint unsigned                     not null,
    creator_user_ip     varchar(15)                         not null,
    question            nvarchar(100)                       not null,
    media_link          nvarchar(100)                       null,
    is_edited           Boolean   DEFAULT FALSE             not null,
    created_at          timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at           timestamp                           null,
    updated_at          timestamp                           null,

    FOREIGN KEY (id_business) REFERENCES businesses (id_businesses),
    FOREIGN KEY (id_creator_user) REFERENCES users (id_users)

);
# ------------------------------Survey Answers---------------------------------
DROP TABLE IF EXISTS survey_answers;
CREATE TABLE survey_answers
(
    id_survey_answers  bigint unsigned auto_increment primary key,
    id_business        bigint unsigned                     not null,
    id_creator_user    bigint unsigned                     not null,
    creator_user_ip    varchar(15)                         not null,
    id_survey_question bigint unsigned                     not null,
    media_link         nvarchar(100)                       null,
    answer             nvarchar(100)                       not null,
    is_edited          Boolean   DEFAULT FALSE             not null,
    created_at         timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at          timestamp                           null,
    updated_at         timestamp                           null,

    FOREIGN KEY (id_business) REFERENCES businesses (id_businesses),
    FOREIGN KEY (id_creator_user) REFERENCES users (id_users),
    FOREIGN KEY (id_survey_question) REFERENCES survey_questions (id_survey_questions)

);
# ------------------------------Survey Result---------------------------------
DROP TABLE IF EXISTS survey_results;
CREATE TABLE survey_results
(
    id_survey_results  bigint unsigned auto_increment primary key,
    id_survey_question bigint unsigned                     not null,
    id_survey_answer   bigint unsigned                     not null,
    id_customer        bigint unsigned                     not null,
    is_edited          Boolean   DEFAULT FALSE             not null,
    created_at         timestamp DEFAULT CURRENT_TIMESTAMP not null,
    updated_at         timestamp                           null,

    FOREIGN KEY (id_survey_question) REFERENCES survey_questions (id_survey_questions),
    FOREIGN KEY (id_survey_answer) REFERENCES survey_answers (id_survey_answers),
    FOREIGN KEY (id_customer) REFERENCES costumers (id_costumers)
);
# ------------------------------Lottery---------------------------------
DROP TABLE IF EXISTS lotteries;
create table lotteries
(
    id_lotteries    bigint unsigned auto_increment primary key,
    id_business     bigint unsigned                     not null,
    name            nvarchar(100)                       not null,
    media_link      nvarchar(100)                       null,
    prize           nvarchar(100)                       null,
    value           int(100)                            null,
    creator_user_id bigint unsigned                     not null,
    creator_user_ip varchar(15)                         not null,
    is_edited       Boolean   DEFAULT FALSE             not null,
    created_at      timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at       timestamp                           null,
    updated_at      timestamp                           null,

    FOREIGN KEY (id_business) REFERENCES businesses (id_businesses)
);
# ------------------------------Condition---------------------------------
DROP TABLE IF EXISTS conditions;
create table conditions
(
    id_conditions   bigint unsigned auto_increment primary key,
    id_lottery      bigint unsigned                     not null,
    condition_name  nvarchar(100)                       not null,
    conditions      nvarchar(100)                       not null,
    creator_user_id bigint unsigned                     not null,
    creator_user_ip varchar(15)                         not null,
    is_edited       Boolean   DEFAULT FALSE             not null,
    created_at      timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at       timestamp                           null,
    updated_at      timestamp                           null,

    FOREIGN KEY (id_lottery) REFERENCES lotteries (id_lotteries)
);# ------------------------------lotteries_conditions_junction---------------------------------
DROP TABLE IF EXISTS lotteries_conditions_junction;
create table lotteries_conditions_junction
(
    id_lotteries_conditions_junction bigint unsigned auto_increment primary key,
    id_lottery                       bigint unsigned                     not null,
    id_condition                     bigint unsigned                     not null,
    creator_user_id                  bigint unsigned                     not null,
    creator_user_ip                  varchar(15)                         not null,
    is_edited                        Boolean   DEFAULT FALSE             not null,
    created_at                       timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at                        timestamp                           null,
    updated_at                       timestamp                           null,

    FOREIGN KEY (id_lottery) REFERENCES lotteries (id_lotteries),
    FOREIGN KEY (id_condition) REFERENCES conditions (id_conditions)
);
# ------------------------------Coupon---------------------------------
DROP TABLE IF EXISTS coupons;
create table coupons
# TODO coupons
(
    id_coupons      bigint unsigned auto_increment primary key,
    id_business     bigint unsigned                     not null,
    name            nvarchar(100)                       not null,
    off_percent     int                                 not null CHECK ( off_percent > 0 ),
    id_costumer     bigint unsigned                     null,
    id_user         bigint unsigned                     null,
    id_service      bigint unsigned                     null,
    id_conditions   bigint unsigned                     null,
    creator_user_id bigint unsigned                     not null,
    creator_user_ip varchar(15)                         not null,
    is_edited       Boolean   DEFAULT FALSE             not null,
    created_at      timestamp DEFAULT CURRENT_TIMESTAMP not null,
    expire_at       timestamp                           null,
    updated_at      timestamp                           null,

    FOREIGN KEY (id_business) REFERENCES businesses (id_businesses),
    FOREIGN KEY (id_costumer) REFERENCES costumers (id_costumers),
    FOREIGN KEY (id_user) REFERENCES users (id_users),
    FOREIGN KEY (id_service) REFERENCES services (id_services),
    FOREIGN KEY (id_conditions) REFERENCES conditions (id_conditions)
);

SET foreign_key_checks = 1;