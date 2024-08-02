
## The British College | Rabi Gorkhali Assignment | ReadMe

## Deliverables:
- Github link: https://github.com/rabigorkhali/thebritishcollege
- Deployment Url: https://thebritishcollege.rabigorkhali.com.np/
- Reference Doc: https://docs.google.com/document/d/1kbS7M38pnRoiEGD-sxRjSR6cVcvLjNqJoKyKDVOB3cg/edit

# How to install
- Step 1: git clone https://github.com/rabigorkhali/thebritishcollege.git
- Step 2: set database configuration and other required configurations in .env file 
- Step 3: composer install 
- Step 4: npm install 
- Step 5: npm run dev 
- Step 6: php artisan migrate 
- Step 7: php artisan db:seed 

# Api Documentation
- Swagger is used for api documentation.
- Go to url: https://thebritishcollege.rabigorkhali.com.np/public/api/documentation

- Note: hit api Auth>> api/login to authenticate and access other apis. When login api is hit, bearer token are set automatically in background so that we dont have to worry about bearer token to be manually feed in.

# Contact
- Email: rabigorkhaly@gmail.com
- Website: www.rabigorkhali.com.np