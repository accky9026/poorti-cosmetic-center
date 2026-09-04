-- ==========================================================
-- Poorti Cosmetic Center - Database Schema + Sample Data
-- Import this file directly in phpMyAdmin / MySQL if you don't
-- want to run `php artisan migrate`.
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `poorti_cosmetic_center`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `poorti_cosmetic_center`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(191) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `brand` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `discount_price` DECIMAL(10,2) DEFAULT NULL,
  `stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample products for Poorti Cosmetic Center
INSERT INTO `products`
(`name`, `category`, `brand`, `price`, `discount_price`, `stock`, `description`, `image`, `is_featured`, `created_at`, `updated_at`)
VALUES
('Radiant Glow Face Cream', 'Skincare', 'Lakme', 349.00, 299.00, 40, 'Lightweight daily moisturizer for a natural glow, suitable for all skin types.', NULL, 1, NOW(), NOW()),
('Matte Finish Liquid Lipstick', 'Makeup', 'Maybelline', 449.00, 399.00, 60, 'Long-lasting, transfer-proof matte lipstick available in 12 shades.', NULL, 1, NOW(), NOW()),
('Herbal Anti-Dandruff Shampoo', 'Haircare', 'Himalaya', 199.00, NULL, 80, 'Gentle herbal shampoo that controls dandruff and nourishes the scalp.', NULL, 0, NOW(), NOW()),
('Rose Water Toner', 'Skincare', 'Biotique', 149.00, 129.00, 100, 'Pure rose water toner that refreshes and tightens pores.', NULL, 0, NOW(), NOW()),
('Eau De Parfum - Blossom', 'Fragrance', 'Nykaa', 899.00, 749.00, 25, 'Floral fruity fragrance with 8-hour long-lasting effect.', NULL, 1, NOW(), NOW()),
('Kajal Waterproof Twin Pack', 'Makeup', 'Lakme', 129.00, NULL, 90, 'Smudge-proof, waterproof kohl kajal, pack of 2.', NULL, 0, NOW(), NOW()),
('Aloe Vera Gel', 'Skincare', 'Patanjali', 99.00, 85.00, 120, '99% pure aloe vera gel for skin & hair care.', NULL, 0, NOW(), NOW()),
('Argan Hair Serum', 'Haircare', 'WOW', 349.00, 299.00, 55, 'Smoothens frizzy hair and adds shine with argan oil.', NULL, 1, NOW(), NOW());
