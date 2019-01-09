<h3>Link do aplikacji: https://educer.midaz.studio/</h3>

<ul>
  <li>Dodano <i>autoloader</i> zgodnie z PSR-4, PSR-0</li>
  <li>Poprawiono działanie MVC</li>
  <li>Zabezpieczono przed SQL Injection</li>
  <li>Zastosowano skrócone <i>instrukcje IF</i></li>
  <li>Wprowadzono kilka innych poprawek</li>
</ul>

<h4>REST API</h4>

Punkt wejścia do API: <i>https://educer.midaz.studio/api</i></li>

<ol>
  Punkty końcowe
  <li>Zwraca listę wszystkich osób</li>
    <i>/persons/?action=GET</i>
  <li>Zwraca listę stron internetowych</li>
    <i>/persons/website/</i>
  <li>Zwraca osobę po <i>ID</i></li>
    <i>/persons/?action=GET&id=:ID</i>
  <li>Aktualizuje osobę po <i>ID</i></li>
    <i>/persons/?action=PUT&id=:ID</i>
  <li>Usuwa osobę po <i>ID</i></li>
    <i>/persons/?action=DELETE&id=:ID</i>
</ol>
