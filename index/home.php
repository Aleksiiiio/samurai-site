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
                      echo "}";
                    }
                  ?>
            });
          }) 
          </script>
      </section>
      <hr />
      <section id="members">
        <div class="member" id="johnny">
          <img src="imgs/johnny.jpg" alt="johnny" />
          <p>
            Johnny Silverhand był legendarnym rockerboyem i frontmanem zespołu
            Samurai. Jego muzyka była agresywnie antykorporacyjna i rewolucyjna.
            Samurai zyskał ogromną popularność, zanim rozpadł się w 2008 roku.
            Johnny później kontynuował karierę solową, wydając albumy o
            zabarwieniu politycznym. Utwory takie jak Chippin' In i Never Fade
            Away stały się hymnami rebeliantów.
          </p>
        </div>
        <div class="member" id="kerry">
          <p>
            Kerry Eurodyne był rockerboyem, wokalistą i gitarzystą w zespole
            Samurai. Pomógł ukształtować wizję zespołu, by zmieniać świat za
            pomocą muzyki. Po rozpadzie Samurai, kontynuował karierę solową, z
            wieloma hitami i platynowymi albumami. Intensywnie koncertował i
            przez całe życie wywierał wpływ na muzykę rockową.
          </p>
          <img src="imgs/kerry.jpg" alt="kerry" />
        </div>
        <div class="member" id="nancy">
          <img src="imgs/nancy.jpg" alt="nancy" />
          <p>
            Nancy Hartley była klawiszowcem zespołu Samurai przed 2008 rokiem.
            Grała w Samurai u boku Johnny'ego Silverhanda i Kerry Eurodyne.
            Zespół Samurai rozpadł się, gdy Nancy spędziła siedem miesięcy w
            więzieniu w 2008 roku. Po wyjściu na wolność przyjęła pseudonim Bes
            Isis i porzuciła muzykę na rzecz mediów.
          </p>
        </div>
        <div class="member" id="denny">
          <p>
            Denny była perkusistką i rockerboyem zespołu Samurai. Grała z
            Samurai aż do rozpadu zespołu w 2008 roku. Po rozpadzie dołączyła do
            zespołu Mastermind. Jej kariera muzyczna koncentruje się na jej roli
            w Samurai i późniejszych projektach.
          </p>
          <img src="imgs/denny.jpg" alt="denny" />
        </div>
        <div class="member" id="henry">
          <img src="imgs/henry.jpg" alt="henry" />
          <p>
            Henry był basistą i rockerem zespołu Samurai aż do jego rozpadu w
            2008 roku. Grał na basie u boku Johnny'ego Silverhanda i reszty
            zespołu Samurai. Po rozpadzie Samurai porzucił muzykę, aby pracować
            nad prototypem, co uszkodziło mu mózg. Jego kariera muzyczna
            koncentruje się na czasie spędzonym w Samurai'u.
          </p>
        </div>
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
          $query3 = "INSERT INTO newsletter(email) VALUES ('$email')";
          $result = mysqli_query($db, $query3);
          if($result){
            echo 'alert("Dziękujemy za zapisanie się do newslettera!");';
          }
          ?>
          })
        </script>
    </footer>
  </body>
</html>
