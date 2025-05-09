<?php

$acesso = $_SESSION['user'];
$nivel = $_SESSION['nivel'];



if ($nivel == 'Administrador') {
    $render('header');
} elseif($nivel == 'Professor') {
    $render('headerProfessor');
}elseif($nivel == 'Secretaria'){
    $render('headerSecretaria');
}elseif($nivel == 'Pedagogo'){
    $render('headerPedagogo');
}elseif($nivel == 'Aluno'){
    $render('headerAluno');
}
 ?>
 <?php
// Lógica para obter mês e ano selecionados
$month = isset($_GET['month']) ? (int) $_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int) $_GET['year'] : date('Y');

// Primeiro dia do mês e número de dias
$firstDay = date('w', strtotime("$year-$month-01"));
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Nomes dos meses
$monthNames = [
  1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
  5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
  9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

// Feriados fixos por mês (exemplo)
$feriados = [
  '01-01', // Confraternização Universal
  '21-04', // Tiradentes
  '01-05', // Dia do Trabalhador
  '07-09', // Independência
  '12-10', // Nossa Senhora Aparecida
  '02-11', // Finados
  '15-11', // Proclamação da República
  '25-12', // Natal
];

// Gera feriados do mês atual
$feriadosDoMes = [];
foreach ($feriados as $feriado) {
  list($dia, $mes) = explode('-', $feriado);
  if ((int)$mes == $month) {
    $feriadosDoMes[] = (int)$dia;
  }
}
?>



<main class="app-main">
<div class="container mt-4">
  <div class="row">

    <!-- Coluna do calendário -->
    <div class="col-md-6">
      <!-- Formulário com onchange automático -->
      <form method="get" class="row mb-4" id="calendarForm">
        <div class="col-md-6">
          <select name="month" class="form-select" onchange="document.getElementById('calendarForm').submit()">
            <?php foreach ($monthNames as $num => $name): ?>
              <option value="<?= $num ?>" <?= ($num == $month) ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <select name="year" class="form-select" onchange="document.getElementById('calendarForm').submit()">
            <?php for ($y = 2020; $y <= 2030; $y++): ?>
              <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </form>

      <!-- Calendário -->
      <div class="card">
        <div class="card-header text-center">
          <h5><?= $monthNames[$month] . " $year"; ?></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered text-center small">
            <thead class="table-light">
              <tr>
                <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                $day = 1;
                for ($i = 0; $i < $firstDay; $i++) echo "<td></td>";

                for ($i = $firstDay; $i < 7; $i++) {
                  $class = in_array($day, $feriadosDoMes) ? 'table-danger' : '';
                  echo "<td class=\"$class\">$day</td>";
                  $day++;
                }
                echo "</tr>";

                while ($day <= $daysInMonth) {
                  echo "<tr>";
                  for ($i = 0; $i < 7; $i++) {
                    if ($day <= $daysInMonth) {
                      $class = in_array($day, $feriadosDoMes) ? 'table-danger' : '';
                      echo "<td class=\"$class\">$day</td>";
                      $day++;
                    } else {
                      echo "<td></td>";
                    }
                  }
                  echo "</tr>";
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>


</main>





<?php $render('footer'); ?>
