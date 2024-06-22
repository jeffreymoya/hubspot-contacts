# Hubspot Contacts

### Installing


#### Backend

Navigate to the backend directory:

```bash
cd backend
```

Install the PHP dependencies:

```bash
composer install
```

Start the PHP server:

```bash
php -S localhost:8000 -t public
```

#### Frontend

Navigate to the frontend directory:

```bash
cd ../frontend
```

Install the Node.js dependencies:

```bash
npm install
```

Start the React development server:

```bash
npm run dev
```

## Running hubspot_sync.php

### Adding hubspot_sync.php to Cron

1. Open the crontab file:

```bash
crontab -e
```

2. Add a new line to the crontab file to run `hubspot_sync.php` every hour. Replace `/path/to/php` and `/path/to/hubspot_sync.php` with the actual paths to your PHP executable and `hubspot_sync.php` file:

```bash
0 * * * * /path/to/php /path/to/hubspot_sync.php
```

3. Save and close the crontab file. The new cron job will start running at the specified frequency.

### Running hubspot_sync.php Manually

To run `hubspot_sync.php` manually, you can use the PHP CLI (Command Line Interface). Here's how you can do it:

1. Open a terminal.

2. Navigate to the directory containing `hubspot_sync.php`:

```bash
cd backend/common
```

3. Run `hubspot_sync.php` with the PHP CLI:

```bash
php hubspot_sync.php
```

