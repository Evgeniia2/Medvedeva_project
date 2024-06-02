<?php if (isset($errors) && count($errors) > 0): ?>
  // Skontroluje, či premenná existuje a či obsahuje chyby, to znamená, že číslo je väčšie ako 0. Ak je podmienka pravdivá, vykoná sa 
  // kód v tomto bloku, zobrazia sa chyby
  <div class="error">
    <?php foreach ($errors as $error): ?>
      <p><?php echo $error; ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

  // Kontajner na zobrazenie chybových hlásení
  <div class="error"> 
    <?php foreach ($errors as $error): ?> // Vyčíslenie chýb a ich zobrazenie
      <p><?php echo $error; ?></p> // zobrazí sa text aktuálnej chyby
    <?php endforeach; ?>
  </div>
<?php endif; ?> 
<!-- Uzavretie podmieneného bloku if -->
