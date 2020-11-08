<?php
class Curl
{
    private $user;
    private $apiKey;
    private $instanceName;

    public function __construct($user, $apiKey, $instanceName)
    {
        $this->user = $user;
        $this->apiKey = $apiKey;
        $this->instanceName = "X-Instance-Name:" . $instanceName;
    }

    public function getJson($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD,  $this->user . ':' .  $this->apiKey);
        $headers = array();
        $headers[] =  $this->instanceName;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result["json"] = curl_exec($ch);
        $result["httpCode"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            return $result;
        }
        curl_close($ch);
    }

    public function getTable($obj)
    {
        $output = "<table class='mojeTabulka'><caption><b>KLIENTI</b></caption><thead><tr><th>Název/Jméno</th><th>Stav</th>";
        $output .= "<th>Vztah</th><th>Rating</th><th>Vlastník</th><th>IČ</th><th>Město</th><th>Kategorie</th></tr></thead><tbody>";
        foreach ($obj["data"] as $each) {
            $output .= isset($each["name"]) ? "<tr><td>" . $each["name"] . "</td>" : "<tr><td></td>";
            $output .= isset($each["state"]) ? "<td>" . $each["state"] . "</td>" : "<td></td>";
            $output .= isset($each["role"]) ? "<td>" . $each["role"] . "</td>" : "<td></td>";
            $output .= isset($each["rating"]) ? "<td>" . $each["rating"] . "</td>" : "<td></td>";
            $output .= isset($each["owner"]["fullName"]) ? "<td>" . $each["owner"]["fullName"] . "</td>" : "<td></td>";
            $output .= isset($each["regNumber"]) ? "<td>" . $each["regNumber"] . "</td>" : "<td></td>";
            $output .= isset($each["primaryAddress"]["address"]["city"]) ? "<td>" . $each["primaryAddress"]["address"]["city"] . "</td>" : "<td></td>";
            $output .= isset($each["category"]["value"]) ? "<td>" . $each["category"]["value"] . "</td></tr>" : "<td></td></tr>";
        }
        $output .= "</tbody></table>";
        return $output;
    }
}
?>