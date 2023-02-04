# Instagram Scrapper Test

## Getting started
Copy .env.example to .env and configure to your need 

Don't forget to put your instagram `INSTAGRAM_ACCOUNT` and `INSTAGRAM_PASSWORD` on env variable (you need to have two factor login disable)

Run `./vendor/bin/sail up` if you have docker and docker-compose installed on your device

Build assets with `./vendor/bin/sail npm install` then `./vendor/bin/sail npm run build`

Go to `http://localhost`, default account loaded is youtube account, but you can select the one you want.
(need to be a public or a private followed account)

## Usage
You have a command to scrap profile or directly on your browser

## How it works
It scrap instagram profile, latest posts, image and push them to local DB/storage. I use a lib to login and get some data, you can't retrieve 
user information and posts from new Instagram Api.

I try a way without login but your ip could get blocked if not logged after 10/20 try. 

## Troubleshooting
You may have some problems while you get data for first time (instagram detect a new device, just confirm it on your phone)
