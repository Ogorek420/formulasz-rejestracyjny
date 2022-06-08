<style>
.cs {
    font-family: "Arial";
    text-align: center;
    background-color: pink;
    padding: 20px;
    margin: 40px;
}
body {
    background-color: lightpink;
}
</style>
<div class="cs">

<h1>Zaloguj się</h1>
<form action="index.php" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>
<h1>Zarejestruj się</h1>
<form action="index.php" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <label for="passwordRepeatInput">Hasło ponownie:</label>
    <input type="password" name="passwordRepeat" id="passwordRepeatInput">
    <label for="imieinput">imie:</label>
    <input type="imie" name="imie" id="imieinput">
    <label for="nazwiskoinput">nazwisko:</label>
    <input type="nazwisko" name="nazwisko" id="nazwiskointup">
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj">
</form>

<?php
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "login") { // login
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$db = new mysqli("localhost", "root", "", "auth");
$q= $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
$q->bind_param("s", $email,);
$q->execute();
$result = $q->get_result();
$userRow = $result->fetch_assoc();
if($userRow == null) {
echo "Błędny login lub hasło <br>";
} else {
if (password_verify($password, $userRow['passwordHASH'])) {
echo "Zalogowano <br>";
} else {
echo "Błędny login lub hasło <br>";
}
}
?>

<?php
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "register") { // nowy uzytkownik
$db = new mysqli("localhost", "root", "", "auth");

$email = $_REQUEST['email'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL); // czysc mail

$password = $_REQUEST['password'];
$passwordRepeat = $_REQUEST['passwordRepeat'];

$imie = $_REQUEST['imie'];
$nazwisko = $_REQUEST['nazwisko'];

if($password == $passwordRepeat) { // hasła identico = go next
$passwordHASH = password_hash($password, PASSWORD_ARGON2I);
$q = $db->prepare("INSERT INTO user VALUES (id, email, passwordHASH, imie, nazwisko");
$q->bind_param("ss",NULL, $email, $passwordHASH, $imie, $nazwisko);

$result = $q->execute();
if($result) {
echo "Konto utworzono poprawnie"; }
else {
echo "Coś poszło nie tak!"; } }
else {    
echo "Hasła nie są zgodne - spróbuj ponownie!"; }
}

?>

</div>