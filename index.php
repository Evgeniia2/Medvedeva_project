<?php 
include('templates/header.php'); 
session_start();

// Устанавливаем роль по умолчанию, если она не установлена
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 0; 
}
?>
<div class="popup-container" id="cookiePopup">
    <p>Používame súbory cookie na zlepšenie vášho zážitku na webe. Pokračovaním v používaní tohto webu súhlasíte s
      používaním súborov cookie.</p>
    <a href="#" class="popup-button" onclick="hidePopup()">Prijať</a>
</div>
<section>
    <div class="main-container">
        <div class="container">
            <div class="carousel">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                    </div>
                    <?php if (isset($_SESSION['username'])): ?>
                        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
                    <?php endif; ?>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/carousel/cream3k.jpg" class="d-block w-100 " alt="Creams">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Krémy</h5>
                                <p>Krém je základom starostlivosti o pleť! Bez krému to nejde. My ich tiež predávame! Prečítajte si popisy produktov!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="img/carousel/Mydlo2k.jpg" class="d-block w-100 " alt="Mydlo">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Mydla</h5>
                                <p>Predávame úžasné autorské mydlá. Kúpte si ich!</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="img/carousel/Shampoo1k.jpg" class="d-block w-100 " alt="Shampon">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>šampón</h5>
                                <p>Predáme úžasné šampóny, určite si prečítajte ich popisy.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <section>
                <div class="infoblock">
                    <h2>Naše výhody</h2>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    Doručenie do 3 hodín!
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <strong>Rýchla doprava nie je len pohodlie, ale aj úspora času.</strong>
                                    Ak si objednáte mydlo ráno, už večer si ho môžete vychutnať vo svojej kúpeľni. To je obzvlášť
                                    dôležité pre ľudí, ktorí žijú vo veľkých mestách, kde sú často zápchy na cestách.
                                    Okrem toho vám rýchla doprava umožňuje byť si istí, že mydlo bude doručené v poriadku. Používame len
                                    spoľahlivé kuriérske služby, ktoré garantujú bezpečnosť vašich objednávok.
                                    Objednajte si autorské mydlo s rýchlou dopravou a získajte ho už dnes!
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Konštantné zľavy
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Ponúkame našim zákazníkom konštantné zľavy na všetky naše produkty. To znamená, že vždy môžete
                                    ušetriť peniaze, keď nakupujete u nás.
                                    Naše zľavy sú dostupné všetkým našim zákazníkom, bez ohľadu na to, ako často nakupujú. To z nich
                                    robí spravodlivý a dostupný spôsob, ako ušetriť peniaze.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Ručne vyrobené produkty
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Sme hrdí na to, že naše produkty sú vyrábané s láskou. Používame iba prírodné ingrediencie a ručnú
                                    prácu, aby sme vytvorili výrobky, ktoré vás potešia svojou kvalitou a vôňou.
                                    Vieme, že si ceníte jedinečné a vysokokvalitné produkty, preto venujeme osobitnú pozornosť každej
                                    fáze výroby. Používame iba čerstvé, prírodné ingrediencie, ktoré starostlivo vyberáme. Okrem toho
                                    používame ručnú prácu, aby boli naše produkty čo najkvalitnejšie a najuniverzálnejšie.
                                    Veríme, že láska k práci sa odráža v konečnom produkte. Naše produkty sú vyrobené s láskou a to
                                    cítiť už pri prvom dotyku.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="infoblock" id="brands">
                <h2>Naši partneri</h2>
                <div class="brand-cloud">
                    <img src="img/brands1.jpg" alt="Brand 1" class="brand-image">
                    <img src="img/brands2.jpg" alt="Brand 2" class="brand-image">
                    <img src="img/brands3.jpg" alt="Brand 1" class="brand-image">
                    <img src="img/brands4.jpg" alt="Brand 2" class="brand-image">
                    <img src="img/brands5.jpg" alt="Brand 3" class="brand-image">
                    <img src="img/brands6.jpg" alt="Brand 1" class="brand-image">
                    <img src="img/brands7.jpg" alt="Brand 2" class="brand-image">
                    <img src="img/brands8.jpg" alt="Brand 2" class="brand-image">
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="infoblock">
        <h2>Spokojní zákazníci</h2>
        <div class="testimonial-preview">
            <div class="testimonial-content">
                <div class="container">
                    <?php if (isset($_SESSION['username'])): ?>
                        <form action="adddata.php" method="post">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="Meno">Meno</label>
                                    <input type="text" name="Meno" id="Meno" class="form-control" required>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="fakulty">hodnotenia</label>
                                    <select name="fakulty" id="fakulty" class="form-control" required>
                                        <option value="">hodnotenia</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-5">
                                    <label for="text">Text</label>
                                    <textarea name="text" id="text" class="form-control" required></textarea>
                                </div>
                                <div class="form-group col-lg-2" style="display: grid;align-items: flex-end;">
                                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Poslať">
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <p>Ak chcete zanechať recenziu, musíte sa zaregistrovať</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <section style="margin-top: 50px;">
            <div class="container">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Meno</th>
                        <th>Hodnotenie</th>
                        <th>Text</th>
                        <?php if ($_SESSION['role'] == 2): ?>
                            <th>Edit</th>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    require_once "conn.php";
                    $sql_query = "SELECT * FROM recenzije";
                    if ($result = $conn->query($sql_query)) {
                        while ($row = $result->fetch_assoc()) { 
                            $Meno = $row['Meno'];
                            $hodnotenia = $row['hodnotenia'];
                            $text = $row['text'];
                            $id = $row['id'];
                    ?>
                    <tr class="trow">
                        <td><?php echo $Meno; ?></td>
                        <td><?php echo $hodnotenia; ?></td>
                        <td><?php echo $text; ?></td>
                        <?php if ($_SESSION['role'] == 2): ?>
                            <td><a href="adddata.php?id=<?php echo $id; ?>">Edit</a></td>
                            <td><a href="deletedata.php?id=<?php echo $id; ?>">Delete</a></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                        } 
                    } 
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</section>

<?php
require "templates/footer.php"; // Подключаем нижнюю часть (футер) веб-страницы
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>

<script src="js/logo.js"></script>

<script>
    function hidePopup() {
        document.getElementById('cookiePopup').style.display = 'none';
    }

    window.onload = function () {
        document.getElementById('cookiePopup').style.display = 'block';
    };
</script>

</body>
</html>
