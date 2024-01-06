
CREATE DATABASE TestDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE TestTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    password_reset_token VARCHAR(100),
    password_reset_expiration DATETIME,
    registration_status INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    deleted_at DATETIME
    );

CREATE TABLE user_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    privacy_policy_agreed DATETIME,
    terms_of_service_agreed DATETIME,
    birthdate DATE,
    residence_prefecture VARCHAR(255),
    nick_name VARCHAR(255),
    twitter_url VARCHAR(255),
    instagram_url VARCHAR(255),
    youtube_channel_url VARCHAR(255),
    blog_url VARCHAR(255),
    icon_url VARCHAR(255),
    profile_image_url VARCHAR(255),
    self_introduction TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME
);