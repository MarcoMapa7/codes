exemplo

```$ar = [
    "src" => [
        "user" => "",
        "host" => ".db.4855800.hostedresource.com",
        "pass" => "@",
        "database" => ""
    ],
    "clone" => [
        "user" => "dev",
        "host" => "localhost",
        "pass" => "@",
        "database" => ""
    ],
];
$migdb = new Migration_Database($ar);
$migdb->migrate(["table"=>"qualidade", "pk"=>['pk1', 'pk2'], "where"=>["key"=>"value"]]);```
