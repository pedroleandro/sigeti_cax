<?php

use App\Models\School;

require __DIR__ . "/vendor/autoload.php";

require __DIR__ . "/routes/web.php";

try {

    $schools = School::all();

    /** @var School $school */
    foreach ($schools as $school) {
        var_dump($school->getAttributes());
    }

    $school = School::find(1);
    var_dump($school->getAttributes());

    $newSchool = new School();
    $newSchool->fill([
        "name" => "ESCOLA COMUNI PRESIDENTE DOMINGOS MACHADO",
        "code" => "21156204",
        "address" => "RUA SANTA INES, 1242 VILA LOBAO. 65605-547 Caxias - MA"
    ]);

    $newSchool->save();
    var_dump("Escola adicionada: " . $newSchool->getId());

    $existsSchool = School::find($newSchool->getId());
    $existsSchool->fill([
        "name" => "ESCOLA COMUNITÁRIA PRESIDENTE DOMINGOS MACHADO",
    ]);
    $existsSchool->save();
    var_dump("Escola atualizada: " . $newSchool->getId());

    var_dump("Nova pesquisa!");
    $schools = (new School())
        ->where("name", "LIKE", "%U.I.M%")
        ->orderBy("name", "DESC")
        ->limit(5)
        ->offset(1)
        ->get();

    foreach ($schools as $school) {
        var_dump($school->getAttributes());
    }

} catch (Exception $exception) {
    echo "Erro: " . $exception->getMessage();
}
