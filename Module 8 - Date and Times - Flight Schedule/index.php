<!--Flight Schedule Dashboard-->
<!--Catanghal, Justine Chollo | CYB 201-->
<?php

// Setup Time and Data
$systemTZ = new DateTimeZone('Asia/Manila');
$now = new DateTime('now', $systemTZ);

// International Data - 5 Flights Total
$intl_flights = [
    ["no" => "JL 742", "airline" => "Japan Airlines", "from" => "MNL", "to" => "NRT", "city" => "Tokyo", "dep" => "2026-01-23 09:30", "dur" => 260, "img" => "https://media.cntraveller.com/photos/6343df288d5d266e2e66f082/16:9/w_2560%2Cc_limit/tokyoGettyImages-1031467664.jpeg", "tz" => "Asia/Tokyo"],
    ["no" => "SQ 915", "airline" => "Singapore Air", "from" => "MNL", "to" => "SIN", "city" => "Singapore", "dep" => "2026-01-23 01:15", "dur" => 225, "img" => "https://i.natgeofe.com/k/95d61645-a0c7-470f-b198-74a399dd5dfb/singapore-city.jpg", "tz" => "Asia/Singapore"],
    ["no" => "EK 335", "airline" => "Emirates", "from" => "MNL", "to" => "DXB", "city" => "Dubai", "dep" => "2026-01-23 15:20", "dur" => 550, "img" => "https://www.dubai.it/en/wp-content/uploads/sites/142/dubai-marina-hd.jpg", "tz" => "Asia/Dubai"],
    ["no" => "PR 720", "airline" => "PH Airlines", "from" => "MNL", "to" => "LHR", "city" => "London", "dep" => "2026-01-23 20:00", "dur" => 870, "img" => "https://cms.inspirato.com/ImageGen.ashx?image=%2Fmedia%2F5682444%2FLondon_Dest_16531610X.jpg&width=1081.5", "tz" => "Europe/London"],
    ["no" => "CX 906", "airline" => "Cathay Pacific", "from" => "MNL", "to" => "HKG", "city" => "Hong Kong", "dep" => "2026-01-23 10:55", "dur" => 135, "img" => "https://www.business.hsbc.com/-/media/media/global/images/business-guides/hk/doing-business-hongkong.jpg?h=961&iar=0&w=1440&hash=718FDF4029A64755C068E8C8B8668B37", "tz" => "Asia/Hong_Kong"]
];

// Domestic Data - 5 Flights Total
$domestic_flights = [
    ["no" => "PR 2831", "airline" => "PH Airlines", "from" => "MNL", "to" => "CEB", "city" => "Cebu", "dep" => "2026-01-22 07:30", "dur" => 85, "img" => "https://www.qatarairways.com/content/dam/images/renditions/horizontal-hd/destinations/philippines/cebu/hd-cebu.jpg", "tz" => "Asia/Manila"],
    ["no" => "5J 603", "airline" => "Cebu Pacific", "from" => "CRK", "to" => "PPS", "city" => "Palawan", "dep" => "2026-01-23 10:10", "dur" => 95, "img" => "https://upload.wikimedia.org/wikipedia/commons/1/13/Kayangan_Lake%2C_Coron_-_Palawan.jpg", "tz" => "Asia/Manila"],
    ["no" => "Z2 611", "airline" => "AirAsia", "from" => "MNL", "to" => "DVO", "city" => "Davao", "dep" => "2026-01-23 01:40", "dur" => 110, "img" => "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/12/37/e8/6e/eden-nature-park.jpg?w=1400&h=1400&s=1", "tz" => "Asia/Manila"],
    ["no" => "DG 6245", "airline" => "Cebgo", "from" => "MNL", "to" => "MPH", "city" => "Boracay", "dep" => "2026-01-23 16:45", "dur" => 70, "img" => "https://cdn.sanity.io/images/nxpteyfv/goguides/e795448cde308c144b5f8eead81b52a5b9a5f4e7-1600x1066.jpg", "tz" => "Asia/Manila"],
    ["no" => "5J 485", "airline" => "Cebu Pacific", "from" => "MNL", "to" => "BCD", "city" => "Bacolod", "dep" => "2026-01-23 18:20", "dur" => 75, "img" => "https://mediaim.expedia.com/destination/1/786072a371d3433948cf4efc4b9f6b0b.jpg", "tz" => "Asia/Manila"]
];

function renderFlightCard($f, $now) {
    $originTZ = new DateTimeZone('Asia/Manila');
    $destTZ = new DateTimeZone($f['tz']);

    // Create Departure object
    $departure = new DateTime($f['dep'], $originTZ);

    // Calculate Arrival
    $arrival = clone $departure;
    $arrival->add(new DateInterval("PT" . $f['dur'] . "M"));
    $arrival->setTimezone($destTZ);

    // Calculate Duration
    $diff = $departure->diff($arrival);
    $durationText = $diff->format('%h h %i m');
    
    // Status Logic: On Time / Boarding / Departed
    $timeUntilDep = $now->diff($departure);
    $minutesRemaining = ($timeUntilDep->days * 1440) + ($timeUntilDep->h * 60) + $timeUntilDep->i;
    $isPast = $now > $departure;

    if ($isPast) {
        $status = "Departed";
        $statusClass = "status-other"; // Gray
    } elseif ($minutesRemaining <= 60) {
        $status = "Boarding";
        $statusClass = "status-long";  // Red/Urgent
    } else {
        $status = "On Time";
        $statusClass = "status-short"; // Green/Safe
    }
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

include('includes/header.php'); 
?>

<main>
    <h2 class="section-title">International Departures</h2>
    <div class="grid">
        <?php foreach ($intl_flights as $flight) renderFlightCard($flight, $now); ?>
    </div>

    <h2 class="section-title">Domestic Departures</h2>
    <div class="grid">
        <?php foreach ($domestic_flights as $flight) renderFlightCard($flight, $now); ?>
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

<?php include('includes/footer.php'); ?>