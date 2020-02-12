# Ethic printingbot
An Ethic web project for printers using Laravel and Vue.js
#
## Installing

### Clone repository
**Clone with HTTPS**
- `git clone https://github.com/MediaEthic/printingbot.git`

**Clone with SSH**
- `git clone git@github.com:MediaEthic/printingbot.git`


### Use develop branch
- `git branch develop`


### Add dependencies
- `composer install`
- `npm i`


### Setup environment configuration
Copy .env.example file, rename it into .env and enter database connection datas


### Database drop all tables and running migrations
- `php artisan migrate:fresh --seed`


### Serve the application
- `php -S localhost:8000 -t ./public`

#
## Using
### Front-end packages
- `tailwindcss` a low-level CSS framework
- `axios` for promise based HTTP client for the browser
- `vuex` for state management pattern and centralize store
- `vuex-map-fields` to enable two-way data binding (getters, mutations) for form fields saved in a Vuex store
- `vee-validate` to validate HTML inputs and generate errors
- `moment` to parse, validate, manipulate, and display dates and times
- `vue-sweetalert2` for popups, alerts and toasts (responsive, customizable and accessible)
- `vue-animate-number` for nice animation number
- `vue-js-modal` for displaying modal (customizable, mobile-friendly)
- `vue2-datepicker` for displaying datepicker/datetimepicker

### Back-end packages
- `laravel-dompdf` for PDF creation
- `intervention/image` for image manipulation
