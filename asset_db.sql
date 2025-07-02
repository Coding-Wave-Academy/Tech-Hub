-- Create the assets table
CREATE TABLE assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add the download_url column to the assets table
ALTER TABLE assets
ADD COLUMN download_url VARCHAR(255) NOT NULL AFTER image_url;

-- Drop the existing stored procedure if it exists
DROP PROCEDURE IF EXISTS UploadAsset;

-- Create the updated stored procedure to include the download_url
DELIMITER $$

CREATE PROCEDURE UploadAsset(
    IN asset_title VARCHAR(255),
    IN asset_description TEXT,
    IN asset_type VARCHAR(50),
    IN asset_price DECIMAL(10, 2),
    IN asset_image_url VARCHAR(255),
    IN asset_download_url VARCHAR(255)
)
BEGIN
    INSERT INTO assets (title, description, type, price, image_url, download_url)
    VALUES (asset_title, asset_description, asset_type, asset_price, asset_image_url, asset_download_url);
END $$

DELIMITER ;