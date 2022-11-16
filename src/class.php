<?php

use PragmaRX\Google2FA\Google2FA;

require_once(__DIR__ . '../../forms/vendor/autoload.php');


class DB
{

    protected $conn;

    public function conn()
    {
        try {
            //Database username
            $username = 'root';
            //Database password
            $password = '';
            //PDO Configuratie
            $options = [
                PDO::ATTR_EMULATE_PREPARES => false, // Zet emulatie uit voor echte prepared statements
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Zet errors aan voor debuggen
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Zet fetch automatisch op array
            ];
            //Host configuratie
            $dsn = "mysql:host=localhost;dbname=dijkstra_urenregistratie;charset=utf8mb4";
            //Maak PDO
            $this->conn = new PDO($dsn, $username, $password, $options);
            //return value boolean
            return true;
            //Zet variable conn op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {
            //Database verbinding error
            exit('Er ging iets mis...');
            //Stuur variable terug
            return $e;
        }
    }
}

class Gebruikers extends DB
{

    public $id;
    public $voornaam;
    public $tussenvoegsel;
    public $achternaam;
    public $email;

    public function create($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $secret_key){
        //Hash wachtwoord
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        // $hash2 = password_hash($secret_key, PASSWORD_DEFAULT);
        $usertype = 0;
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "INSERT INTO gebruikers (voornaam, tussenvoegsel, achternaam, email, wachtwoord, usertype, secretkey) VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, :usertype, :secretkey)";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":voornaam", $voornaam);
            $stmt->bindParam(":tussenvoegsel", $tussenvoegsel);
            $stmt->bindParam(":achternaam", $achternaam);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":wachtwoord", $hash);
            $stmt->bindParam(":usertype", $usertype);
            $stmt->bindParam(":secretkey", $secret_key);

            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {

            return $e;
        }
    }

    public function login($email, $wachtwoord, $code)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT * FROM gebruikers WHERE email = :email";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":email", $email);
            // sql query daadwerkelijk uitvoeren
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetch();

            $this->conn = NULL;
            // controleren of het ingetypte wachtwoord overeenkomt met die in de database
            if (password_verify($wachtwoord, $data['wachtwoord'])) {
                // zet de secret key van database in variable secret key
                $secret_key = $data['secretkey'];
                # Create the 2FA class
                $google2fa = new PragmaRX\Google2FA\Google2FA();
                // controleren of het ingetypte code overeenkomt met die in de database
                if($google2fa->verifyKey($secret_key, $code)){
                // class variabelen invullen
                $this->id = $data['id_gebruiker'];
                $this->voornaam = $data['voornaam'];
                $this->tussenvoegsel = $data['tussenvoegsel'];
                $this->achternaam = $data['achternaam'];
                $this->email = $data['email'];
                }
                else{
                
                    return "Code is Incorrect let op code veranderd elke 15 seconden";
                }
                // status terugsturen
                return true;
            }
            else{
                
                return "Email of wachtwoord is fout";
            }
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function is_loggedin()
    {
        if (isset($_SESSION['gebruiker_data'])) {
            return true;
        }
    }
    public function doLogout()
    {
        session_destroy();
        unset($_SESSION['gebruiker_data']);
        return true;
    }

    public function update($voornaam, $tussenvoegsel, $achternaam, $email, $oudewachtwoord, $wachtwoord)
    {
        if (empty($wachtwoord)) {
        } else {
            //Hash wachtwoord
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        }
        try {
            //Pak sessie data uit
            $user = unserialize($_SESSION['gebruiker_data']);
            //Fetch gebruiker id uit sessie
            $user_id = $user->id;
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `gebruikers` 
                    SET 
			voornaam=COALESCE(NULLIF(:voornaam, ''),voornaam),
			tussenvoegsels=COALESCE(NULLIF(:tussenvoegsels, ''),tussenvoegsels),
			achternaam=COALESCE(NULLIF(:achternaam, ''),achternaam),
			email=COALESCE(NULLIF(:email, ''),email),
			wachtwoord=COALESCE(NULLIF(:nww1, ''),wachtwoord)			
                    WHERE id_gebruiker = :userid";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':userid', $user_id);
            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':tussenvoegsels', $tussenvoegsel);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nww1', $hash);

            //Tweede SQL defineren voor oude wachtwoord fetchen
            $sql2 = "SELECT wachtwoord FROM gebruikers WHERE id_gebruiker = :id";
            //SQL voorbereiden
            $stmt2 = $this->conn->prepare($sql2);
            //Values verbinden met named placeholders
            $stmt2->bindParam(":id", $user_id);

            // sql query daadwerkelijk uitvoeren
            $stmt2->execute();
            // data ophalen
            $data = $stmt2->fetch();

            if (password_verify($oudewachtwoord, $data['wachtwoord'])) {
                //sql uitvoeren
                $stmt->execute();
                return true;
            }
            else{
               
                return "wachtwoord onjuist";
            }
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }

    public function delete($user_id, $email, $wachtwoord)
    {
        // maak een connectie met de database
        $this->conn();
        $sql2 = "SELECT * FROM gebruikers WHERE email = :email";
        // sql voorbereiden
        $stmt2 = $this->conn->prepare($sql2);
        // waardes verbinden met de named placeholders
        $stmt2->bindParam(":email", $email);
        // sql query daadwerkelijk uitvoeren
        $stmt2->execute();
        // data ophalen
        $data = $stmt2->fetch();

        // controleren of het ingetypte wachtwoord overeenkomt met die in de database
        if (password_verify($wachtwoord, $data['wachtwoord'])) {
            // class variabelen invullen
            $this->id = $data['id_gebruiker'];
            $this->voornaam = $data['voornaam'];
            $this->tussenvoegsel = $data['tussenvoegsels'];
            $this->achternaam = $data['achternaam'];
            $this->email = $data['email'];
            // status terugsturen


            // sql query defineren
            $sql = "DELETE FROM `gebruikers` WHERE id_gebruiker = :userid AND email = :email";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(':userid', $user_id);
            $stmt->bindParam(':email', $email);
            //Data ophalen
            $stmt->execute();

            session_destroy();
            return true;
        } else {
            // status terugsturen
            return "Het ingevoerde email en/of wachtwoord is onjuist.";
        }
        $this->conn = NULL;
    }
}
// ik wil pushe