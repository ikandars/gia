## Gia Blog App

Extremely simple markdown base blog application

## Run

Go to your project dir then run this command:

```php -S localhost:8080 -t public/```

## Nginx Config

```
server {
    listen 8181;
    server_name localhost;
    root /PATH/DOCUMENT/gia/public;

    location / {
         index index.php;
         try_files $uri $uri/ /index.php$uri;
    }

    location ~ \.php(/|$) {
        index index.php;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```