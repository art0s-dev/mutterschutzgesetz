<?php

namespace motherProtectionLaw;

/*
Das Mutterschutz gesetz ist dazu da, die Gesundheit der Frau zu schützen.
Und sie vor möglichen Benachteiligungen vor und nach der Entbindung zu schützen.
*/

function hasProtectionFromLaw(Women $women):bool
{
    if($women->isPregnant() || $woment->hasGivenBirthRecently() || $women->isBreastfeeding()){
        return true;
    }
    return false;
}

function getsMoneyFromState(Women $women):bool
{
    if($women->isWorkingAs('civilServant') || $women->isWorkingAs('soldier') || $women->isWorkingAs('judge')){
        return false;
    }
    if($women->isPregnant() && $women->isWorking()){
        return true;
    }
    return false;
}

function canDoSomething(Action $action):bool
{
    $notAllowedActionList = yaml::get("NotAllowedActionListDuringPregnancy");
    if(in_array($action, $notAllowedActionList)){
        return false;
    }
    return true;
}

function getProhibitionOfEmployment(Women $women, int $individualStart = 6, int $individualEnd = 12 ):array
{
    $date = $woman->getDateforChildbirth();
    $child = $woman->getChild();
    $start = DateTime($date)->modify("- 6 weeks");
    $end = DateTime($date)->modify("+ 8 weeks");

    //TODO: Hier sollte eigentlich noch ne genauere Frühchenreglung rein
    if($woman->getChildren($date) > 2 || $woman->hasEarlyBirth()){
        $end = DateTime($date)->modify("+ 12 weeks");
    }

    if($woman->hasBadHealthConditions() || $child->hasBadHealthConditions()){
        $start = DateTime($date)->modify("+ $individualStart weeks");
        $end = DateTime($date)->modify("+ $individualEnd weeks");
    }

    return [$start , $end];
}

function calculateAmount(Women $women, array $earnings):float
{
    $amount = 0;
    $count = count($earnings);
    foreach($earnings as $earning){
        $amount = $amount + $earning;
    }
    return $amount / $count;
}