<?php
if (isset($_COOKIE['cookie'])){
    $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $dbname = "HackMe";

    // Crea la connessione al database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se la connessione ha avuto successo
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }
    $cookieValue = $_COOKIE['cookie'];
    $starttime = microtime(true);
    if(strpos($cookieValue, "UNION") == false){
    $sql = "SELECT * FROM users WHERE cookie = '$cookieValue'";
    $result = $conn->query($sql);
    $endtime = microtime(true);
    $duration = $endtime - $starttime;
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }
    }else{
      $row['title'] = "Vietato hackerare!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>HackMe</title>
</head>

<style>
    .terminal {
        background-color: #1a202c;
        color: #a0aec0;
        padding: 1rem;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
    }
    @font-face {
    font-family: PixelOperator;
    src: url(../font/PixelOperatorMono.ttf);
}
.font-pixel {
    font-family: PixelOperator;
    font-size: 1.5rem;
}

@keyframes rotate {
  from {
    rotate: 0deg;
  }
  
  50% {
    scale: 1 1.5;
  }
  
  to {
    rotate: 360deg;
  }
}

#blob {
  background-color: white;
  height: 20vmax;
  aspect-ratio: 1;
  position: absolute;
  left: 50%;
  top: 50%;
  translate: -50% -50%;
  border-radius: 50%;
  background: linear-gradient(to right, aquamarine, mediumpurple);
  animation: rotate 20s infinite;
  opacity: 0.8;
}

#blur {
  height: 100%;
  width: 100%;
  position: fixed;
  z-index: 2;
  backdrop-filter: blur(12vmax);
} 

html, body {
  height: 100%;
  margin: 0;
}
</style>

<body class="bg-gray-900 font-pixel">
<div id="blob"></div>
<div id="blur"></div>
<div class ="z-10 relative">
    <nav>
        <div class="container p-6 mx-auto">
            <div class="flex items-center justify-center mt-6 text-white capitalize">
                <a href="#" data-dropdown-toggle="dropdownSQL" class="transition transform hover:scale-105 ease-in-out border-b-2 border-blue-500 mx-1.5 sm:mx-6">SQL Injection</a>
                <div id="dropdownSQL" class="z-10 hidden font-normal bg-gray-800 divide-y divide-gray-100 rounded-lg shadow w-44">
                <ul class="py-2 text-sm text-white " aria-labelledby="dropdownLargeButton">
                  <li>
                    <a href="./union.php" class="block px-4 py-2 hover:bg-gray-900 ">Union</a>
                  </li>
                  <li>
                    <a href="./blind.php?id=1" class="block px-4 py-2 hover:bg-gray-900 ">Blind</a>
                  </li>
                  <li>
                    <a href="./time.php" class="block px-4 py-2 hover:bg-gray-900 ">Time</a>
                  </li>
                </ul>
            </div>
                <a href="#" data-dropdown-toggle="dropdownXSS" class="transition transform hover:scale-105 ease-in-out border-b-2 border-transparent hover:border-blue-500 mx-1.5 sm:mx-6">XSS</a>
                <div id="dropdownXSS" class="z-10 hidden font-normal bg-gray-800 divide-y divide-gray-100 rounded-lg shadow w-44">
                <ul class="py-2 text-sm text-white " aria-labelledby="dropdownLargeButton">
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-900 ">Reflected</a>
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-900 ">Stored</a>
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-900 ">DOM-based</a>
                  </li>
                </ul>
            </div>
                <a href="#" class="transition transform hover:scale-105 ease-in-out border-b-2 border-transparent hover:border-blue-500 mx-1.5 sm:mx-6">Command Injection</a>
                
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-8 text-white">
        <h1 id="obiettivi" data-value="[OBIETTIVI]" class="text-4xl font-bold text-green-500 mb-8">[OBIETTIVI]</h1>
        <h2>- Trovare la password dell'utente manuelFabiano</h2>
        <div class="mt-4 flex w-full ">
        <div class="mb-4 flex flex-grow">
            <div class="text-green-400 mt-1 w-1/10">Cookie > </div>
            <input type="text" id="cookieInput" class="bg-gray-900 text-white w-full border border-gray-700 rounded-xl px-2 focus:outline-none mr-3">
        </div>
        <button onclick="setCookie()" class="mr-2 bg-green-500 rounded-xl px-1 mb-4">Vai</button>
        <div class="flex right-3 items-center mb-4">
                <label for="showQuery" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="showQuery" name="showQuery" class="hidden">
                        <div class="w-12 h-6 bg-gray-300 rounded-full shadow-inner"></div>
                        <div id="switchKnob" class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow transition-transform transform translate-x-0"></div>
                    </div>
                    <div class="ml-3 text-gray-200 font-bold text-sm">
                        Mostra Query SQL
                    </div>
                </label>
            </div>
        </div>
        <div id="queryBox" class="terminal p-4 rounded-3xl opacity-0 transition duration-300">
            <span class="text-white" id="queryText"></span>
        </div>
        <h1 class="text-4xl font-bold text-white mt-4 mb-8">In questa pagina viene eseguita una query che verifica se i cookie impostati sono presenti nel database</h1>
        <h1 class="text-4xl font-bold text-white mt-4 mb-8">Tempo impiegato dalla query: <?echo $duration;?></h1>
        
    </div>
</div>
    <script>  
    
    // Ottieni l'elemento di input dal DOM
var cookieInput = document.getElementById("cookieInput");

// Imposta il valore predefinito come URL corrente
cookieInput.value = getCookie();
        const queryElement = document.getElementById('queryText');
        const switchKnob = document.getElementById('switchKnob');
        const showQueryCheckbox = document.getElementById('showQuery');
        const queryBox = document.getElementById('queryBox');

        function getCookie() {
          cookieString = document.cookie;
          var cookiesArray = cookieString.split(";");

          // Preleva il primo cookie
          var firstCookie = cookiesArray[0];

          var cookieValue = firstCookie.substring(7);
          return cookieValue
        }

        function setCookie() {
            const cookie = cookieInput.value;
            document.cookie = "cookie=" + cookie;
            location.reload;
        }

        function generateSQLQuery() {
            const cookie = cookieInput.value;

            const query = `SELECT * FROM users WHERE cookie = '${cookie}';`;
            queryElement.innerHTML = highlightQuery(query);
        }

        function highlightQuery(query) {
            const keywords = ['SELECT', 'FROM', 'WHERE', 'AND', 'OR', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE', 'UNION'];

            const highlightedQuery = query.replace(
                /( -- -)([\s\S]*)$/,
                (match, group1, group2) => `${group1} <span class="text-gray-500">${group2}</span>`
            );
        
            var normalQuery = "";
            var commentedQuery = "";
            if (highlightedQuery.includes('<span class="text-gray-500">')){
                const splittedQuery = highlightedQuery.split('<span class="text-gray-500">');
                normalQuery = splittedQuery[0];
                commentedQuery = '<span class="text-gray-500">' + splittedQuery[1];
            }else normalQuery = highlightedQuery;
            
            console.log(normalQuery);
            console.log(commentedQuery);

            const highlightedNormalQuery = normalQuery.replace(
                new RegExp(keywords.join('|'), 'g'),
                (match) => `<span class="text-blue-500">${match}</span>`
            );

            return highlightedNormalQuery + commentedQuery;
        }

        function toggleQueryBox() {
            queryBox.classList.toggle('opacity-0');
            if (!queryBox.classList.contains('opacity-0')) {
                generateSQLQuery();
            }
        }



        function toggleSwitch() {
            if (showQueryCheckbox.checked) {
                switchKnob.classList.add('translate-x-6');
            } else {
                switchKnob.classList.remove('translate-x-6');
            }
        }

        showQueryCheckbox.addEventListener('change', toggleSwitch);



        showQueryCheckbox.addEventListener('change', toggleQueryBox);

        cookieInput.addEventListener('input', generateSQLQuery);

        /* -- Glow effect -- */

const blob = document.getElementById("blob");

window.onpointermove = event => { 
  const { clientX, clientY } = event;
  
  blob.animate({
    left: `${clientX}px`,
    top: `${clientY}px`
  }, { duration: 3000, fill: "forwards" });
}

//Hacker effect
const letters = "ABCDEFGHILMNOPQRSTUVZabcdefghilmnopqrstuvz123456789[]";
        document.getElementById("obiettivi").onmouseover = event => {
            let iterations = 0;

            const interval = setInterval(() => {
            event.target.innerText = event.target.innerText.split("")
            .map((letter, index) => {
                if(index < iterations){
                    return event.target.dataset.value[index];
                }
                
                return letters[Math.floor(Math.random() * 26)]
            })
            .join("");

            if(iterations >= event.target.dataset.value.length) clearInterval(interval);

            iterations += 1 / 3;
            }, 30);
        
        }


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>