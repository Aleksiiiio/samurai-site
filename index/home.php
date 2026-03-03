<?php
$db = mysqli_connect("localhost","root","","samurai");
if(!$db){
  echo "Nie udało połączyć się z bazą danych";
  mysqli_close($db);
}
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="imgs/samurailogo.ico" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Play&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <title>Samurai</title>
  </head>
  <body>
    <header>
      <div id="logos">
        <a href="#banner"><img src="imgs/samurailogo.png" alt="logo" id="logo" /></a>
        <a href="#banner"
          ><img src="imgs/samurai.png" alt="samurai" id="samurai"
        /></a>
      </div>
      <nav id="menu">
        <a href="#musicarticle">muzyka</a>
        <div class="dropdown">
          <button class="membersmenu">członkowie ⮟</button>
          <div class="dropdown-content">
            <a href="#johnny">johnny</a>
            <a href="#kerry">kerry</a>
            <a href="#nancy">nancy</a>
            <a href="#denny">denny</a>
            <a href="#henry">henry</a>
          </div>
        </div>
        <a href="#newsletter">newsletter</a>
      </nav>
    </header>
    <main>
      <section id="banner">
        <p>Samurai</p>
        <p>legendarny zespół rockowy, który burzy wieże</p>
        <p>następny koncert za:</p>
        <p id="nextconcert"></p>
        <script>
          let nextconcert = document.getElementById("nextconcert");

          function updateCountdown(){
            const date = new Date("Aug 7, 2026 17:00:00").getTime();
            const now = new Date().getTime();
            let difference = date - now;
            let days = Math.floor(difference / (1000 * 60 * 60 * 24));
            let hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((difference % (1000 * 60)) / 1000);

            if (days< 10) days = '0'+days;
            if (hours< 10) hours = '0'+hours;
            if (minutes< 10) minutes = '0'+minutes;
            if (seconds< 10) seconds = '0'+seconds;
            nextconcert.textContent = days+"d "+hours+"h "+minutes+"m "+seconds+"s ";
          }

          setInterval(updateCountdown, 1000);
          updateCountdown();

        </script>
      </section>
      <hr />
      <article id="musicarticle">
        <div id="musicdice">
          <div id="box-card">
            <div class="face front">
              <img src="imgs/neverfadeaway.jpg" alt="neverfadeaway" />
            </div>
            <div class="face back">
              <img src="imgs/chippinin.jpg" alt="chippinin" />
            </div>
            <div class="face right">
              <img src="imgs/theballad.jpg" alt="theballad" />
            </div>
            <div class="face left">
              <img src="imgs/archangel.jpg" alt="archangel" />
            </div>
            <div class="face top">
              <img src="imgs/blackdog.jpg" alt="blackdog" />
            </div>
            <div class="face bottom">
              <img src="imgs/alikesupreme.jpg" alt="alikesupreme" />
            </div>
          </div>
        </div>
        <div id="musicorigin">
          <p>
            W latach 2003-2008 wydano łącznie sześć albumów. Trzy z nich to
            nagrania studyjne, a pozostałe trzy to nagrania koncertowe i jam
            sessions.
          </p>
        </div>
      </article>
      <section id="songs">
          <?php
            $query1 = "SELECT id, nazwa, zdjecie FROM piosenka";
            $result1 = mysqli_query($db, $query1);

            while($row = mysqli_fetch_assoc($result1)){
              echo '<div class="card">';
              echo '<img src="imgs/'.$row['zdjecie'].'" alt="'.$row['nazwa'].'" id="'.$row['id'].'"/>';
              echo '</div>';
            }
          ?>
          
      </section>
      <section id="songinfo">
        <img src="imgs/neverfadeaway.jpg" alt="neverfadeaway" id="songimg"/>
        <div id="songdescription">
          <p id="title">Never Fade Away</p>
          <p id="authors">Johnny Silverhand</p>
          <p id="description">
            Napisany i skomponowany przez Johnny'ego Silverhanda utwór „Never
            Fade Away” był częścią jego solowego albumu z 2013 roku, „A Cool
            Metal Fire”, wydanego przez wytwórnię Universal Media. Jakiś czas
            później wydał ten utwór ponownie na albumie zatytułowanym „Never
            Fade Away”. Ostatecznie, po reaktywacji Samurai'a, nagrano kolejną
            wersję z resztą zespołu.
          </p>
        </div>
        <script>
          let images = document.querySelectorAll(".card img")
          let songimg = document.getElementById("songimg")
          let title = document.getElementById("title");
          let authors = document.getElementById("authors")
          let description = document.getElementById("description")

          images.forEach(img =>{
              img.addEventListener('click', (e)=>{
                  <?php
                    $query2 = "SELECT 
                              p.id AS songid, 
                              p.nazwa AS songname,
                              p.opis AS description,
                              p.zdjecie AS image,
                              GROUP_CONCAT(a.nazwa SEPARATOR ', ') AS artistnames
                              FROM artysta_piosenka AS ap
                              JOIN artysta AS a ON a.id = ap.artysta_id 
                              JOIN piosenka AS p ON p.id = ap.piosenka_id
                              GROUP BY p.id, p.nazwa, p.opis, p.zdjecie;";
                    $result2 = mysqli_query($db,$query2);

                    while ($row = mysqli_fetch_assoc($result2)){
                      echo 'if(e.target.id == "'.$row['songid'].'") {';
                      echo 'songimg.src = "imgs/'.$row['image'].'";';
                      echo 'songimg.alt = "'.$row['songname'].'";';
                      echo 'title.textContent = "'.$row['songname'].'";';
                      echo 'authors.textContent = "'.$row['artistnames'].'";';
                      echo 'description.textContent = "'.$row['description'].'";';
                      echo "}\n";
                    }
                  ?>
            });
          }) 
          </script>
      </section>
      <hr />
      <section id="members">
        <?php
          $query3 = "SELECT id, nazwa, nazwa_skrot, biografia, zdjecie FROM artysta";
          $result3 = mysqli_query($db,$query3);
          $i = 0;
          while ($row = mysqli_fetch_assoc($result3)){
            if($i % 2 == 0){
              echo '<div class="member" id="'.$row['nazwa_skrot'].'">';
              echo '<img src="imgs/'.$row['zdjecie'].'" alt="'.$row['nazwa'].'"/>';
              echo '<p>'.$row['biografia'].'</p>';
              echo '</div>';
            } else {
              echo '<div class="member" id="'.$row['nazwa_skrot'].'">';
              echo '<p>'.$row['biografia'].'</p>';
              echo '<img src="imgs/'.$row['zdjecie'].'" alt="'.$row['nazwa'].'"/>';
              echo '</div>';
            }
            $i++;
          }
        ?>
      </section>
    </main>
    <hr>
    <footer id="newsletter">
        <p>Zapisz się do newslettera</p>
        <form method="GET">
          <input type="email" name="email" id="email">
          <button type="submit" id="signup">Zapisz się</button>
        </form>
        <script>
          let signup = document.getElementById('signup');
          signup.addEventListener("click", (e)=>{
          <?php
          $email = $_GET['email'];
          $query4 = "INSERT INTO newsletter(email) VALUES ('$email')";
          if(empty($email)){
            echo 'alert("Proszę podać email");';
          } else{
            $result4 = mysqli_query($db, $query4);
            if($result4){
              echo 'alert("Dziękujemy za zapisanie się do newslettera!");';
            }
          }
          ?>
          })
        </script>
    </footer>
  </body>
</html>
