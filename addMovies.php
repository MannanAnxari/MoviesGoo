<?php
include_once 'files/apikey.php';
include_once 'files/datafile.php';
include_once 'files/rootDirectory.php';

?>

<head>
    <link rel="stylesheet" href="<?php echo $root_directory ?>/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="m-0">
    <div class="bg-dark vh-100 vw-100 mx-auto align-items-center text-white container">
        <div class="todayEntries">
            Today Entries: <span id="todayEntries">0</span>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 mx-auto vh-100 d-flex align-items-center gap-2 addMovies">
                <input type="text" class="primary" id="movieIds" placeholder="e.g. tt123456789">
                <button class="btn-main btn" id="addMovieBtn" onclick="addMovie()">Add Movie</button>
            </div>
        </div>
    </div>
</body>

<?php
echo '<script src="' . $root_directory . '/js/vanilla-toast.min.js"></script>';
?>

<script>
    function getLanguageName(languageCode) {
        var languageMap = {
            en: 'English',
            af: 'Afrikaans',
            sq: 'Albanian',
            am: 'Amharic',
            ar: 'Arabic',
            hy: 'Armenian',
            az: 'Azerbaijani',
            eu: 'Basque',
            be: 'Belarusian',
            bn: 'Bengali',
            bs: 'Bosnian',
            bg: 'Bulgarian',
            ca: 'Catalan',
            ceb: 'Cebuano',
            ny: 'Chichewa',
            zh: 'Chinese',
            'zh-cn': 'Chinese (Simplified)',
            'zh-tw': 'Chinese (Traditional)',
            co: 'Corsican',
            hr: 'Croatian',
            cs: 'Czech',
            da: 'Danish',
            nl: 'Dutch',
            eo: 'Esperanto',
            et: 'Estonian',
            tl: 'Filipino',
            fi: 'Finnish',
            fr: 'French',
            fy: 'Frisian',
            gl: 'Galician',
            ka: 'Georgian',
            de: 'German',
            el: 'Greek',
            gu: 'Gujarati',
            ht: 'Haitian Creole',
            ha: 'Hausa',
            haw: 'Hawaiian',
            iw: 'Hebrew',
            hi: 'Hindi',
            hmn: 'Hmong',
            hu: 'Hungarian',
            is: 'Icelandic',
            ig: 'Igbo',
            id: 'Indonesian',
            ga: 'Irish',
            it: 'Italian',
            ja: 'Japanese',
            jv: 'Javanese',
            kn: 'Kannada',
            kk: 'Kazakh',
            km: 'Khmer',
            ko: 'Korean',
            ku: 'Kurdish',
            ky: 'Kyrgyz',
            lo: 'Lao',
            la: 'Latin',
            lv: 'Latvian',
            lt: 'Lithuanian',
            lb: 'Luxembourgish',
            mk: 'Macedonian',
            mg: 'Malagasy',
            ms: 'Malay',
            ml: 'Malayalam',
            mt: 'Maltese',
            mi: 'Maori',
            mr: 'Marathi',
            mn: 'Mongolian',
            my: 'Myanmar (Burmese)',
            ne: 'Nepali',
            no: 'Norwegian',
            ps: 'Pashto',
            fa: 'Persian',
            pl: 'Polish',
            pt: 'Portuguese',
            pa: 'Punjabi',
            ro: 'Romanian',
            ru: 'Russian',
            sm: 'Samoan',
            gd: 'Scots Gaelic',
            sr: 'Serbian',
            st: 'Sesotho',
            sn: 'Shona',
            sd: 'Sindhi',
            si: 'Sinhala',
            sk: 'Slovak',
            sl: 'Slovenian',
            so: 'Somali',
            es: 'Spanish',
            su: 'Sundanese',
            sw: 'Swahili',
            sv: 'Swedish',
            tg: 'Tajik',
            ta: 'Tamil',
            te: 'Telugu',
            th: 'Thai',
            tr: 'Turkish',
            uk: 'Ukrainian',
            ur: 'Urdu',
            ug: 'Uyghur',
            uz: 'Uzbek',
            vi: 'Vietnamese',
            cy: 'Welsh',
            xh: 'Xhosa',
            yi: 'Yiddish',
            yo: 'Yoruba',
            zu: 'Zulu'
        };

    }

    function generateSlug(str) {
        const slug = str.replace(/[,_\.]/g, '-');
        const cleanedSlug = slug.replace(/[^-\w\s]/g, '');
        return cleanedSlug.replace(/\s+/g, '-');
    }

    var year = "";

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


    function extractImdbId(input) {
        let imdbId = input;

        const urlPattern = /\/title\/(tt\d+)/;
        const urlMatch = input.match(urlPattern);
        if (urlMatch && urlMatch[1]) {
            imdbId = urlMatch[1];
        }

        const idPattern = /(tt\d+)/;
        const idMatch = input.match(idPattern);
        if (idMatch && idMatch[1]) {
            imdbId = idMatch[1];
        }

        return imdbId;
    }

    const addMovie = async () => {
        let ids = extractImdbId(movieIds.value.trim());

        if (!ids) {
            vt.error("IMDB ID Zaroori Hai Sale! 🥹", {
                position: "top-center",
                duration: 3000
            });
            return;
        }

        addMovieBtn.innerHTML = `
        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="animate-spin text-center" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
        `;

        try {

            let res = await fetch(`https://api.themoviedb.org/3/movie/${ids}?api_key=<?php echo $apikey; ?>`);
            let json = await res.json();

            const url = `https://imdb8.p.rapidapi.com/title/get-ratings?tconst=${ids}`;
            const options = {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': 'c9c0395249msh8dc442935e8520ap11428ajsn2a904e979019',
                    'X-RapidAPI-Host': 'imdb8.p.rapidapi.com'
                }
            };

            const response = await fetch(url, options);
            const {
                rating,
                year
            } = await response.json();

            let imdbId = json.imdb_id;
            let title = json.title;
            let rate = rating || 0;
            let language = getLanguageName(json.original_language) || 'English';

            let data = {
                title: `${title}`,
                year: `${year}`,
                language: `${language}`,
                imdb: `https://www.imdb.com/title/${imdbId}`,
                rating: `${rate}`,
                slug: `${generateSlug(title)}-${year}-watch-online-in-${language}`.trim().toLowerCase()
            };

            addMovieResp = await sendMovieData(data);

            if (addMovieResp?.success) {

                vt.success(addMovieResp.message, {
                    position: "top-center",
                    duration: 3000
                });

                let entriesResponse = await addEntries();

                todayEntries.innerText = entriesResponse;

            } else {
                vt.error(addMovieResp.message, {
                    position: "top-center",
                    duration: 3000
                });
            }

        } catch (error) {
            vt.error(error.message, {
                position: "top-center",
                duration: 3000
            });
        } finally {
            addMovieBtn.innerHTML = "Add Movie"
        }

    }

    async function sendMovieData(data) {
        try {
            const response = await fetch('<?php echo $root_directory ?>/extras/handleAddMovie.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Error: ' + response.status);
                vt.error("Request Failed with Status: " + response.status, {
                    position: "top-center",
                    duration: 3000
                });
            }

            return await response.json();
        } catch (error) {
            vt.error(error.message, {
                position: "top-center",
                duration: 3000
            });
        }
    }
    async function addEntries(data) {
        try {
            const response = await fetch('<?php echo $root_directory ?>/extras/handleTodayEntries.php');

            if (!response.ok) {
                throw new Error('Error: ' + response.status);
                vt.error("Request Failed with Status: " + response.status, {
                    position: "top-center",
                    duration: 3000
                });
            }

            return await response.text();

        } catch (error) {
            vt.error(error.message, {
                position: "top-center",
                duration: 3000
            });
        }
    }
</script>

<!-- Exaple Data.json -->

<!-- {
    "title": "Sound of Freedom",
    "year": "2023",
    "language": "English",
    "imdb": "https://www.imdb.com/title/tt7599146",
    "rating": "8.6",
    "slug": "sound-of-freedom-2023-watch-online-in-english"
}, -->