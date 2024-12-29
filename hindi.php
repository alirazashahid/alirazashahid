<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.png" type="image/png">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <title>Moviezoon</title>
    <style>
        /* Popup and overlay styling */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            display: none;
            border-radius: 0px;
        }

      

        .button-85 {
            padding: 0.6em 2em;
            border: none;
            outline: none;
            color: rgb(255, 255, 255);
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
        }

        .button-85:before {
            content: "";
            background: linear-gradient(
                45deg,
                #ff0000,
                #ff7300,
                #fffb00,
                #48ff00,
                #00ffd5,
                #002bff,
                #7a00ff,
                #ff00c8,
                #ff0000
            );
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing-button-85 20s linear infinite;
            border-radius: 10px;
        }

     

    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.html" style="text-decoration: none;">
            <div class="logo" title="Moviezoon">M</div>
        </a>

        <div class="search-bar">
    <input id="search-input" type="text" placeholder="Search...">
    <button onclick="searchMovies()">
        <div class="search-icon">
            <i class="fas fa-search"></i>
        </div>
    </button>
</div>

<script>
    function searchMovies() {
        const searchInput = document.getElementById('search-input').value.trim(); // Get the search input value

        if (searchInput) {
            // Redirect to search.php with the query parameter
            window.location.href = `search.html?query=${encodeURIComponent(searchInput)}`;
        } else {
            alert("Please enter a search term!"); // Show an alert if the search is empty
        }
    }

    // Trigger search when Enter key is pressed
    document.getElementById('search-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            searchMovies(); // Call the searchMovies function on Enter
        }
    });
</script>



        <div class="language-dropdown">
            <button class="btn" onclick="window.location.href='urdu.html'">Urdu</button>
            <button class="btn" onclick="window.location.href='punjabi.html'">Punjabi</button>
            <button class="btn" onclick="window.location.href='english.html'">English</button>
            <button class="btn" onclick="window.location.href='hindi.html'">Hindi</button>
            <button class="btn" onclick="window.location.href='h-dubbed.html'">H-Dubbed</button>
        </div>

        <div class="profile" onclick="goToProfile()">
            <img src="Images/pf-pic.jpg" alt="Profile Picture">
        </div>
    </nav>

    <div class="sidebar">
        <a href="playlist.html" title="Playlist" class="playlist-img"></a>
        <a href="Watched.html" title="Just Watched" class="justwatched-img"></a>
        <a href="Liked.html" title="Liked" class="liked-img"></a>
    </div>

    <div id="excel_data" class="gallery">
    </div>

    <div>
        <h5>
            Moviezooooooooooooooon
              </h5>
    </div>
    <script>
// Function to shuffle the array in random order
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Function to load and process the Excel file automatically
function loadExcelFile(filePath) {
    fetch(filePath)
        .then(response => response.arrayBuffer())
        .then(data => {
            const workbook = XLSX.read(data, { type: 'array' });
            const sheet_name = workbook.SheetNames[0];
            const sheet_data = XLSX.utils.sheet_to_json(workbook.Sheets[sheet_name], { defval: '' });

            if (sheet_data.length > 0) {
                // Filter the sheet data to include only rows with language set to 'hindi'
                const filteredData = sheet_data.filter(row => row['language'] && row['language'].toLowerCase() === 'hindi');

                // Shuffle the filtered data before rendering
                const shuffledData = shuffleArray(filteredData);

                let output = '';
                shuffledData.forEach((row, index) => {
                    const imagePath = row['image_url'] || 'https://via.placeholder.com/300';
                    const title = row['title'] || `Untitled (Row ${index + 1})`;

                    output += `
                        <div class="frame" onclick="window.location.href='video.php?vpcode=${row['vpcode']}'">
                            <img src="${imagePath}" alt="${title}">
                            <div class="title">${title}</div>
                        </div>`;
                });
                document.getElementById('excel_data').innerHTML = output;
            } else {
                document.getElementById('excel_data').innerHTML = 
                '<div class="alert alert-warning">No data found in the Excel file</div>';
            }
        })
        .catch(error => {
            document.getElementById('excel_data').innerHTML = 
            `<div class="alert alert-danger">Error loading file: ${error.message}</div>`;
        });
}

// Load videos.xlsx automatically on page load
window.onload = () => {
    loadExcelFile('videos.xlsx');
};
</script>

</body>
</html>
