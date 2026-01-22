<!--Flight Schedule Dashboard-->
<!--Catanghal, Justine Chollo | CYB 201-->

<?php
$systemTZ = new DateTimeZone('Asia/Manila');
$now = new DateTime('now', $systemTZ);

// International Data - 5 Flights Total
$intl_flights = [
    ["no" => "JL 742", "airline" => "Japan Airlines", "from" => "MNL", "to" => "NRT", "city" => "Tokyo", "dep" => "2026-01-22 09:30", "dur" => 260, "img" => "https://media.cntraveller.com/photos/6343df288d5d266e2e66f082/16:9/w_2560%2Cc_limit/tokyoGettyImages-1031467664.jpeg", "tz" => "Asia/Tokyo"],
    ["no" => "SQ 915", "airline" => "Singapore Air", "from" => "MNL", "to" => "SIN", "city" => "Singapore", "dep" => "2026-01-22 11:15", "dur" => 225, "img" => "https://i.natgeofe.com/k/95d61645-a0c7-470f-b198-74a399dd5dfb/singapore-city.jpg", "tz" => "Asia/Singapore"],
    ["no" => "EK 335", "airline" => "Emirates", "from" => "MNL", "to" => "DXB", "city" => "Dubai", "dep" => "2026-01-22 15:20", "dur" => 550, "img" => "https://www.dubai.it/en/wp-content/uploads/sites/142/dubai-marina-hd.jpg", "tz" => "Asia/Dubai"],
    ["no" => "PR 720", "airline" => "PH Airlines", "from" => "MNL", "to" => "LHR", "city" => "London", "dep" => "2026-01-22 20:00", "dur" => 870, "img" => "https://cms.inspirato.com/ImageGen.ashx?image=%2Fmedia%2F5682444%2FLondon_Dest_16531610X.jpg&width=1081.5", "tz" => "Europe/London"],
    ["no" => "CX 906", "airline" => "Cathay Pacific", "from" => "MNL", "to" => "HKG", "city" => "Hong Kong", "dep" => "2026-01-22 10:55", "dur" => 135, "img" => "https://www.business.hsbc.com/-/media/media/global/images/business-guides/hk/doing-business-hongkong.jpg?h=961&iar=0&w=1440&hash=718FDF4029A64755C068E8C8B8668B37", "tz" => "Asia/Hong_Kong"]
];

// Domestic Data - 5 Flights Total
$domestic_flights = [
    ["no" => "PR 2831", "airline" => "PH Airlines", "from" => "MNL", "to" => "CEB", "city" => "Cebu", "dep" => "2026-01-22 07:30", "dur" => 85, "img" => "https://www.qatarairways.com/content/dam/images/renditions/horizontal-hd/destinations/philippines/cebu/hd-cebu.jpg", "tz" => "Asia/Manila"],
    ["no" => "5J 603", "airline" => "Cebu Pacific", "from" => "CRK", "to" => "PPS", "city" => "Palawan", "dep" => "2026-01-22 10:10", "dur" => 95, "img" => "https://upload.wikimedia.org/wikipedia/commons/1/13/Kayangan_Lake%2C_Coron_-_Palawan.jpg", "tz" => "Asia/Manila"],
    ["no" => "Z2 611", "airline" => "AirAsia", "from" => "MNL", "to" => "DVO", "city" => "Davao", "dep" => "2026-01-22 14:00", "dur" => 110, "img" => "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/12/37/e8/6e/eden-nature-park.jpg?w=1400&h=1400&s=1", "tz" => "Asia/Manila"],
    ["no" => "DG 6245", "airline" => "Cebgo", "from" => "MNL", "to" => "MPH", "city" => "Boracay", "dep" => "2026-01-22 16:45", "dur" => 70, "img" => "https://cdn.sanity.io/images/nxpteyfv/goguides/e795448cde308c144b5f8eead81b52a5b9a5f4e7-1600x1066.jpg", "tz" => "Asia/Manila"],
    ["no" => "5J 485", "airline" => "Cebu Pacific", "from" => "MNL", "to" => "BCD", "city" => "Bacolod", "dep" => "2026-01-22 18:20", "dur" => 75, "img" => "https://mediaim.expedia.com/destination/1/786072a371d3433948cf4efc4b9f6b0b.jpg", "tz" => "Asia/Manila"]
];

function renderFlightCard($f) {
    // DateTime & DateTimeZone usage
    $originTZ = new DateTimeZone('Asia/Manila');
    $destTZ = new DateTimeZone($f['tz']);
    
    // Create Departure object
    $departure = new DateTime($f['dep'], $originTZ);
    
    // Calculate Arrival using add() and DateInterval
    $arrival = clone $departure;
    $arrival->add(new DateInterval("PT" . $f['dur'] . "M"));
    $arrival->setTimezone($destTZ); // Convert to destination local time
    
    // Calculate Duration using diff()
    $diff = $departure->diff($arrival);
    $durationText = $diff->format('%h h %i m');
    
    // Logic for Status Badge (Bonus)
    $status = "Scheduled";
    $statusClass = "status-other";
    if ($f['dur'] > 300) { $status = "Long Haul"; }
    elseif ($f['dur'] < 90) { $status = "Short Trip"; }
    ?>
    <div class="card">
        <div class="card-img" style="background-image: url('<?php echo $f['img']; ?>')">
            <div class="overlay"></div>
            <div class="flight-no"><?php echo $f['no']; ?></div>
        </div>
        <div class="card-body">
            <span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span>
            <h3><?php echo $f['from']; ?> &rarr; <?php echo $f['to']; ?></h3>
            <p class="airline"><?php echo $f['airline']; ?> • <?php echo $f['city']; ?></p>
            
            <div class="time-info">
                <div>
                    <label>Departure</label>
                    <strong><?php echo $departure->format('M j, g:i A'); ?></strong>
                </div>
                <div>
                    <label>Arrival</label>
                    <strong><?php echo $arrival->format('M j, g:i A'); ?></strong>
                </div>
            </div>
            
            <div class="card-footer">
                <span>Duration: <b><?php echo $durationText; ?></b></span>
                <span class="tz-label"><?php echo $f['tz']; ?></span>
            </div>
        </div>
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Schedule Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f172a;
            --card: #1e293b;
            --text: #f8fafc;
            --accent: #38bdf8;
            --border: rgba(255,255,255,0.1);
        }
        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        
        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
            margin-bottom: 40px;
        }
        .current-time { text-align: right; color: var(--accent); }

        /* Grid Layout */
        .section-title { margin: 40px 0 20px; font-size: 1.5rem; border-left: 4px solid var(--accent); padding-left: 15px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        /* Card Styling */
        .card {
            background: var(--card);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .card-img { height: 140px; background-size: cover; background-position: center; position: relative; }
        .overlay { position: absolute; inset: 0; background: linear-gradient(to top, var(--card), transparent); }
        .flight-no { position: absolute; bottom: 10px; left: 15px; font-weight: 700; font-size: 1.2rem; }
        
        .card-body { padding: 20px; }
        .badge { font-size: 10px; padding: 4px 8px; border-radius: 6px; background: rgba(255,255,255,0.1); text-transform: uppercase; }
        h3 { margin: 10px 0 5px; color: var(--accent); }
        .airline { font-size: 13px; opacity: 0.7; margin-bottom: 20px; }
        
        .time-info { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .time-info label { display: block; font-size: 10px; text-transform: uppercase; opacity: 0.5; }
        .time-info strong { font-size: 13px; }

        .card-footer { 
            border-top: 1px solid var(--border); 
            padding-top: 15px; 
            display: flex; 
            justify-content: space-between; 
            font-size: 11px; 
            opacity: 0.8;
        }
        .tz-label { color: var(--accent); font-weight: 600; }

        /* Mini Timezone Section */
        .world-clock {
            background: rgba(255,255,255,0.03);
            padding: 20px;
            border-radius: 12px;
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 60px 20px;
            border-top: 1px solid var(--border);
            margin-top: 60px;
            opacity: 0.6;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <div>
            <h1>Clark International Airport</h1>
        </div>
        <div class="current-time">
            <strong><?php echo $now->format('D, M j, Y'); ?></strong><br>
            <span><?php echo $now->format('g:i:s A'); ?> PST</span>
        </div>
    </header>

    <main>
        <h2 class="section-title">International Departures</h2>
        <div class="grid">
            <?php foreach ($intl_flights as $flight) renderFlightCard($flight); ?>
        </div>

        <h2 class="section-title">Domestic Departures</h2>
        <div class="grid">
            <?php foreach ($domestic_flights as $flight) renderFlightCard($flight); ?>
        </div>

        <section class="world-clock">
            <?php 
            $bonusTZs = ['Asia/Tokyo', 'Asia/Singapore', 'Europe/London'];
            foreach ($bonusTZs as $btz) {
                $t = new DateTime('now', new DateTimeZone($btz));
                echo "<div><small>$btz</small><br><strong>" . $t->format('g:i A') . "</strong></div>";
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Holy Angel University | Justine Chollo Catanghal | CYB 201</p>
        <p>PHP DateTime Hand-on Activity</p>
    </footer>
</div>

</body>
</html>