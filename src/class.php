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
    public $usertype;
    public $img;
    public $secret_key;


    public function create($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $usertype, $secret_key)
    {
        //Hash wachtwoord
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        // $hash2 = password_hash($secret_key, PASSWORD_DEFAULT);
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

    public function login($email, $wachtwoord, $code, $usertype)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT * FROM gebruikers WHERE email = :email AND usertype = :usertype";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":usertype", $usertype);
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
                if ($google2fa->verifyKey($secret_key, $code)) {
                    // class variabelen invullen
                    $this->id = $data['id_gebruiker'];
                    $this->voornaam = $data['voornaam'];
                    $this->tussenvoegsel = $data['tussenvoegsel'];
                    $this->achternaam = $data['achternaam'];
                    $this->email = $data['email'];
                    $this->usertype = $data['usertype'];
                    $this->img = $data['image'];
                    $this->secret_key = $data['secretkey'];
                    // status terugsturen
                    return true;
                } else {

                    return "Code is Incorrect let op code veranderd elke 15 seconden";
                }
                // status terugsturen
                return true;
            } else {
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
        unset($_SESSION['admin_data']);
        return true;
    }

    public function update($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $wachtwoordcheck)
    {
        if (!empty($wachtwoord)) {
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
			tussenvoegsel=COALESCE(NULLIF(:tussenvoegsel, ''),tussenvoegsel),
			achternaam=COALESCE(NULLIF(:achternaam, ''),achternaam),
			email=COALESCE(NULLIF(:email, ''),email),
			wachtwoord=COALESCE(NULLIF(:wachtwoord, ''),wachtwoord)			
                    WHERE id_gebruiker = :userid";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':userid', $user_id);
            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':tussenvoegsel', $tussenvoegsel);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':wachtwoord', $hash);

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

            if (password_verify($wachtwoordcheck, $data['wachtwoord'])) {
                //sql uitvoeren
                $stmt->execute();
                return true;
            } else {

                return "wachtwoord onjuist";
            }
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function UserTypeUpdate($usertype, $id_gebruiker, $wachtwoord)
    { 
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `gebruikers` 
                    SET 	
                    usertype=COALESCE(NULLIF(:usertype, ''),usertype),
                    wachtwoord=COALESCE(NULLIF(:wachtwoord, ''),wachtwoord)

					
                    WHERE id_gebruiker = :userid";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':userid', $id_gebruiker);
            $stmt->bindParam(':usertype', $usertype);
            $stmt->bindParam(':wachtwoord', $hash);


            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function GebruikersZien()
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT * FROM gebruikers";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);

                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchAll();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
        }
    }
    public function GebruikerZien($id_gebruiker)
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT * FROM gebruikers WHERE id_gebruiker = :id_gebruiker";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);
                // waardes verbinden met de named placeholders	
                $stmt->bindParam(':id_gebruiker', $id_gebruiker);
                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchAll();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
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
    public function VerwijderGebruiker($id_gebruiker)
    {
        // maak een connectie met de database
        $this->conn();
        // sql query defineren
        $sql = "DELETE FROM `gebruikers` WHERE id_gebruiker = :id_gebruiker";
        // sql voorbereiden
        $stmt = $this->conn->prepare($sql);
        // waardes verbinden met de named placeholders	
        $stmt->bindParam(':id_gebruiker', $id_gebruiker);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
}
class Klanten extends DB
{
    public function KlantCreate($klantnaam, $straatnaam, $telefoon, $woonplaats, $huisnummer, $postcode, $archiveer)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "INSERT INTO klanten (klantnaam, straatnaam, huisnummer, postcode, woonplaats, telefoonnummer, archiveer) VALUES (:klantnaam, :straatnaam, :huisnummer, :postcode, :woonplaats, :telefoonnummer, :archiveer)";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":klantnaam", $klantnaam);
            $stmt->bindParam(":straatnaam", $straatnaam);
            $stmt->bindParam(":huisnummer", $huisnummer);
            $stmt->bindParam(":postcode", $postcode);
            $stmt->bindParam(":telefoonnummer", $telefoon);
            $stmt->bindParam(":woonplaats", $woonplaats);
            $stmt->bindParam(":archiveer", $archiveer);



            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {

            return $e;
        }
    }
    public function klantupdate($klantnaam, $straatnaam, $telefoonnummer, $woonplaats, $huisnummer, $postcode, $id_klant)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `klanten` 
                    SET 
			klantnaam=COALESCE(NULLIF(:klantnaam, ''),klantnaam),
			straatnaam=COALESCE(NULLIF(:straatnaam, ''),straatnaam),
			huisnummer=COALESCE(NULLIF(:huisnummer, ''),huisnummer),
			postcode=COALESCE(NULLIF(:postcode, ''),postcode),
			woonplaats=COALESCE(NULLIF(:woonplaats, ''),woonplaats),	
			telefoonnummer=COALESCE(NULLIF(:telefoonnummer, ''),telefoonnummer)			

                    WHERE id_klant = :id_klant";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_klant', $id_klant);
            $stmt->bindParam(':klantnaam', $klantnaam);
            $stmt->bindParam(':straatnaam', $straatnaam);
            $stmt->bindParam(':huisnummer', $huisnummer);
            $stmt->bindParam(':postcode', $postcode);
            $stmt->bindParam(':woonplaats', $woonplaats);
            $stmt->bindParam(':telefoonnummer', $telefoonnummer);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function klantarchiveer($id_klant, $archiveer)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `klanten` 
                    SET 
			archiveer=COALESCE(NULLIF(:archiveer, ''),archiveer)		
                    WHERE id_klant = :id_klant";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_klant', $id_klant);
            $stmt->bindParam(':archiveer', $archiveer);

            

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }

    public function KlantZien($id_klant)
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT * FROM klanten where id_klant = :id_klant";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);
                // waardes verbinden met de named placeholders
                $stmt->bindParam(":id_klant", $id_klant);
                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchAll();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
        }
    }
    public function KlantenZien()
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT * FROM klanten";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);

            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function VerwijderKlant($id_klant)
    {
        // maak een connectie met de database
        $this->conn();
        // sql query defineren
        $sql = "DELETE FROM `klanten` WHERE id_klant = :id_klant";
        // sql voorbereiden
        $stmt = $this->conn->prepare($sql);
        // waardes verbinden met de named placeholders	
        $stmt->bindParam(':id_klant', $id_klant);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
}
class projecten extends Klanten
{
    public function ProjectAanmaken($id_klant, $projectnaam, $begindatum, $archiveer)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "INSERT INTO projecten (id_klant, projectnaam, begindatum, archiveer) VALUES (:id_klant, :projectnaam, :begindatum, :archiveer)";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_klant", $id_klant);
            $stmt->bindParam(":projectnaam", $projectnaam);
            $stmt->bindParam(":begindatum", $begindatum);
            $stmt->bindParam(":archiveer", $archiveer);



            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {

            return $e;
        }
    }
    public function Projectzien($id_project)
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT * FROM projecten where id_project = :id_project";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);
                // waardes verbinden met de named placeholders
                $stmt->bindParam(":id_project", $id_project);

                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchall();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
        }
    }

    public function Projectenzien($id_klant)
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT * FROM projecten where id_klant = :id_klant";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);
                // waardes verbinden met de named placeholders
                $stmt->bindParam(":id_klant", $id_klant);
                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchAll();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
        }
    }
    public function Projectenzienbydate($id_klant)
    { {
            try {
                // maak een connectie met de database
                $this->conn();
                // sql query defineren
                $sql = "SELECT id_project, projectnaam, begindatum, laatst_gewerkt FROM projecten where id_klant = :id_klant ORDER BY laatst_gewerkt Desc";
                // sql voorbereiden
                $stmt = $this->conn->prepare($sql);
                // waardes verbinden met de named placeholders
                $stmt->bindParam(":id_klant", $id_klant);
                //Voer SQL uit
                $stmt->execute();
                // data ophalen
                $data = $stmt->fetchAll();
                // database connectie sluiten
                $this->conn = NULL;

                // opgehaalde rijen terugsturen
                return $data;
            } catch (PDOException $e) {
                // database connectie sluiten
                $this->conn = NULL;
                //stuur variable terug
                return $e;
            }
        }
    }
    public function projectupdate($id_klant, $projectnaam, $begindatum, $id_project)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `projecten` 
                    SET 
                    projectnaam=COALESCE(NULLIF(:projectnaam, ''),projectnaam),
                    begindatum=COALESCE(NULLIF(:begindatum, ''),begindatum)		

                    WHERE id_klant = :id_klant and id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_klant', $id_klant);
            $stmt->bindParam(':id_project', $id_project);
            $stmt->bindParam(':projectnaam', $projectnaam);
            $stmt->bindParam(':begindatum', $begindatum);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function projectarchiveer($id_project, $archiveer)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `projecten` 
                    SET 
			archiveer=COALESCE(NULLIF(:archiveer, ''),archiveer)		
                    WHERE id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_project', $id_project);
            $stmt->bindParam(':archiveer', $archiveer);

            

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function VerwijderProject($id_project)
    {
        // maak een connectie met de database
        $this->conn();
        // sql query defineren
        $sql = "DELETE FROM `projecten` WHERE id_project = :id_project";
        // sql voorbereiden
        $stmt = $this->conn->prepare($sql);
        // waardes verbinden met de named placeholders	
        $stmt->bindParam(':id_project', $id_project);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
}

class uren extends projecten
{

    public function Urenregistreren($id_gebruiker, $id_project, $bonusmdw, $activiteiten, $declarabel, $uren, $begonnen, $beëindigd, $datum, $archiveer)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "INSERT INTO uren (id_project, id_gebruiker, id_bonusmedewerker, activiteit, declarabel, uren, begonnen, beeindigd, datum, archiveer) VALUES (:id_project, :id_gebruiker, :id_bonusmedewerker, :activiteit, :declarabel, :uren, :begonnen, :beeindigd, :datum, :archiveer)";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_project", $id_project);
            $stmt->bindParam(":id_gebruiker", $id_gebruiker);
            $stmt->bindParam(":id_bonusmedewerker", $bonusmdw);
            $stmt->bindParam(":activiteit", $activiteiten);
            $stmt->bindParam(":declarabel", $declarabel);
            $stmt->bindParam(":uren", $uren);
            $stmt->bindParam(":begonnen", $begonnen);
            $stmt->bindParam(":beeindigd", $beëindigd);
            $stmt->bindParam(":datum", $datum);
            $stmt->bindParam(":archiveer", $archiveer);



            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {

            return $e;
        }
    }
    public function Laatst_gewerkt($id_klant, $id_project, $datum)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            // sql query defineren
            $sql = "UPDATE `projecten` 
                    SET 
                    laatst_gewerkt=COALESCE(NULLIF(:laatst_gewerkt, ''),laatst_gewerkt)
                   

                    WHERE id_klant = :id_klant and id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(':id_klant', $id_klant);
            $stmt->bindParam(':id_project', $id_project);
            $stmt->bindParam(':laatst_gewerkt', $datum);
            // 2de sql
            $sql2 = "SELECT laatst_gewerkt FROM projecten WHERE id_klant = :id_klant and id_project = :id_project";
            //SQL voorbereiden
            $stmt2 = $this->conn->prepare($sql2);
            //Values verbinden met named placeholders
            $stmt2->bindParam(':id_klant', $id_klant);
            $stmt2->bindParam(':id_project', $id_project);
            //SQL query daadwerkelijk uitvoeren
            $stmt2->execute();
            // data ophalen
            $data = $stmt2->fetch();

            if ($data["laatst_gewerkt"] < $datum) {
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            //Zet verbinding op NULL
            $this->conn = NULL;
            return $e;
        }
    }
    public function UrenZien($id_project)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT id_uren, id_project, uren.id_gebruiker, id_bonusmedewerker, activiteit, declarabel, uren, begonnen, beeindigd, uren.archiveer, datum, voornaam, tussenvoegsel, achternaam FROM `uren` INNER JOIN `gebruikers` ON uren.id_gebruiker = gebruikers.id_gebruiker WHERE  id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_project", $id_project);
            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function PersoonlijkeUrenZien($id_project, $id_gebruiker)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT id_uren, id_project, uren.id_gebruiker, id_bonusmedewerker, activiteit, declarabel, uren, begonnen, beeindigd, datum, voornaam, tussenvoegsel, achternaam FROM `uren` INNER JOIN `gebruikers` ON uren.id_gebruiker = gebruikers.id_gebruiker WHERE id_project = :id_project AND gebruikers.id_gebruiker = :id_gebruiker";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_project", $id_project);
            $stmt->bindParam(":id_gebruiker", $id_gebruiker);

            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function TotaleUrenZien($id_project)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT uren, declarabel FROM uren where  id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_project", $id_project);
            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function uurzien($id_uren)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT id_uren, uren.id_project, uren.id_gebruiker, id_bonusmedewerker, activiteit, declarabel, uren, begonnen, beeindigd, datum, voornaam, tussenvoegsel, achternaam, projectnaam, klantnaam, projecten.id_klant, uren.archiveer FROM `uren`
                INNER JOIN `gebruikers` ON uren.id_gebruiker = gebruikers.id_gebruiker 
                INNER JOIN `projecten` ON uren.id_project = projecten.id_project
                INNER JOIN `klanten` ON projecten.id_klant = klanten.id_klant
                WHERE  uren.id_uren = :id_uren";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_uren", $id_uren);
            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function Exportuurzien($id_project)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "SELECT id_uren, activiteit, declarabel, uren, begonnen, beeindigd, datum, voornaam, tussenvoegsel, achternaam, projectnaam, klantnaam, laatst_gewerkt FROM `uren`
                INNER JOIN `gebruikers` ON uren.id_gebruiker = gebruikers.id_gebruiker 
                INNER JOIN `projecten` ON uren.id_project = projecten.id_project
                INNER JOIN `klanten` ON projecten.id_klant = klanten.id_klant
                WHERE  uren.id_project = :id_project";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_project", $id_project);
            //Voer SQL uit
            $stmt->execute();
            // data ophalen
            $data = $stmt->fetchAll();
            // database connectie sluiten
            $this->conn = NULL;

            // opgehaalde rijen terugsturen
            return $data;
        } catch (PDOException $e) {
            // database connectie sluiten
            $this->conn = NULL;
            //stuur variable terug
            return $e;
        }
    }
    public function urenbewerken($id_uren, $bonusmdw, $activiteiten, $declarabel, $uren, $begonnen, $beëindigd, $datum)
    {
        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `uren` 
            SET
            activiteit=COALESCE(NULLIF(:activiteit, ''),activiteit),
            id_bonusmedewerker=COALESCE(NULLIF(:id_bonusmedewerker, ''),id_bonusmedewerker),
            declarabel=COALESCE(NULLIF(:declarabel, ''),declarabel),
            uren=COALESCE(NULLIF(:uren, ''),uren),
            begonnen=COALESCE(NULLIF(:begonnen, ''),begonnen),
            beeindigd=COALESCE(NULLIF(:beeindigd, ''),beeindigd),
            datum=COALESCE(NULLIF(:datum, ''),datum)
                 WHERE id_uren = :id_uren";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders
            $stmt->bindParam(":id_uren", $id_uren);
            $stmt->bindParam(":id_bonusmedewerker", $bonusmdw);
            $stmt->bindParam(":activiteit", $activiteiten);
            $stmt->bindParam(":declarabel", $declarabel);
            $stmt->bindParam(":uren", $uren);
            $stmt->bindParam(":begonnen", $begonnen);
            $stmt->bindParam(":beeindigd", $beëindigd);
            $stmt->bindParam(":datum", $datum);


            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            if(empty($bonusmdw)){
                $sql2 = 'UPDATE `uren` 
                SET id_bonusmedewerker = NULL WHERE id_uren = :id_uren';
                 $stmt2 = $this->conn->prepare($sql2);
                 // waardes verbinden met de named placeholders
                 $stmt2->bindParam(":id_uren", $id_uren);
            $stmt2->execute();

            }
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {

            return $e;
        }
    }
    public function urenarchiveer($id_uren, $archiveer)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `uren` 
                    SET 
			archiveer=COALESCE(NULLIF(:archiveer, ''),archiveer)		
                    WHERE id_uren = :id_uren";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_uren', $id_uren);
            $stmt->bindParam(':archiveer', $archiveer);

            

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function urenDeclarabel($id_uren, $declarabel)
    {

        try {
            // maak een connectie met de database
            $this->conn();
            // sql query defineren
            $sql = "UPDATE `uren` 
                    SET 
                    declarabel=COALESCE(NULLIF(:declarabel, ''),declarabel)		
                    WHERE id_uren = :id_uren";
            // sql voorbereiden
            $stmt = $this->conn->prepare($sql);
            // waardes verbinden met de named placeholders	
            $stmt->bindParam(':id_uren', $id_uren);
            $stmt->bindParam(':declarabel', $declarabel);

            

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->conn = NULL;
            // status terugsturen
            return $e;
        }
    }
    public function VerwijderUren($id_uren)
    {
        // maak een connectie met de database
        $this->conn();
        // sql query defineren
        $sql = "DELETE FROM `uren` WHERE id_uren = :id_uren";
        // sql voorbereiden
        $stmt = $this->conn->prepare($sql);
        // waardes verbinden met de named placeholders	
        $stmt->bindParam(':id_uren', $id_uren);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
}
