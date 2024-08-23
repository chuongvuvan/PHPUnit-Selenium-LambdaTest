# Sử dụng một hình ảnh PHP cơ sở có sẵn (ví dụ: PHP 7.4)
FROM php:8.3-fpm

# Cài đặt các gói và phần mềm cần thiết
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip

# Cài đặt Composer (một trình quản lý gói PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Sao chép các tệp dự án vào thư mục làm việc
COPY . .

# Cài đặt các phụ thuộc PHP bằng Composer
RUN composer install

# Thiết lập quyền truy cập cho thư mục runtime và web/assets
RUN chmod -R 777 runtime web/assets

# Expose cổng mặc định của PHP-FPM
EXPOSE 9000

# Lệnh chạy khi container được khởi động
CMD ["php-fpm"]
