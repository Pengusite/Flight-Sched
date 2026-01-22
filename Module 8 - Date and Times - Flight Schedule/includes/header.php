<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Schedule Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <header>
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; letter-spacing: -1px;">
            Clark International Airport
        </h1>
    </div>

    <div class="pill-time-container">
        <div class="pill-left">
            <div class="pill-clock">
                <?php echo $now->format('g:i:s A'); ?>
            </div>
            <div class="pst-badge">PST</div>
        </div>

        <div class="pill-divider"></div>

        <div class="pill-right">
            <span class="pill-day"><?php echo $now->format('l'); ?></span>
            <span class="pill-date"><?php echo $now->format('M j, Y'); ?></span>
        </div>
    </div>
</header>