<?php
include_once './../files/apikey.php';
include_once './../files/datafile.php';
include_once './../files/rootDirectory.php';
?>

<link rel="stylesheet" href="../css/main.css">

<body class="m-0">
    <h1 class="bg-dark vh-100 vw-100 d-flex align-items-center justify-content-center text-white">
        Today Entries By Ahmed: (<span id="todayEntries"> 0 </span>)
    </h1>
</body>

<script>
    (async function() {
        try {
            const response = await fetch('<?php echo $root_directory ?>/extras/getTodayEntries.php');

            if (!response.ok) {
                throw new Error('Error: ' + response.status);
            }

            const todayEntriesRes = await response.json();
            if (todayEntriesRes.success) {
                console.log(todayEntriesRes);
                todayEntries.innerText = todayEntriesRes.data;
            }
        } catch (error) {
            console.error('Fetch error:', error);
            vt.error(error.message, {
                position: "top-center",
                duration: 3000
            });
        }
    })();
</script>