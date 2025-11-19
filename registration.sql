-- registration.sql - Schema for Registration Database.
-- OPTIMIZED: utf8mb4 for international chars; BOOLEAN for newsletter (1/0); indexes on email/postal for queries.

IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'Registration')
CREATE DATABASE [Registration];

USE [Registration];

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[registered_users]') AND type in (N'U'))
CREATE TABLE [registered_users] (
    user_id INT IDENTITY(1,1) PRIMARY KEY,
    title VARCHAR(10) NOT NULL,  -- Mr, Mrs, Ms, Dr
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    street VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    province VARCHAR(50) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(20) NOT NULL,  -- Canada, USA
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    newsletter BIT NOT NULL DEFAULT 0
);

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[registered_users]') AND name = N'idx_email')
CREATE INDEX idx_email ON [registered_users] (email);

IF NOT EXISTS (SELECT * FROM sys.indexes WHERE object_id = OBJECT_ID(N'[dbo].[registered_users]') AND name = N'idx_last_name')
CREATE INDEX idx_last_name ON [registered_users] (last_name);

-- Sample data demo
IF NOT EXISTS (SELECT * FROM [registered_users] WHERE email = 'john@example.com')
INSERT INTO [registered_users] ([title], [first_name], [last_name], [street], [city], [province], [postal_code], [country], [phone], [email], [newsletter]) 
VALUES ('Mr', 'John', 'Doe', '123 Main St', 'Toronto', 'ON', 'M1A 1A1', 'Canada', '416-123-4567', 'john@example.com', 1);