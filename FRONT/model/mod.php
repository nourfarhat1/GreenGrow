<?php
class FarmModel
{
    private ?string $reference_f = null;
    private ?string $localisation = null;
    private ?float $superficie_totale = null;
    private ?string $reference_zone = null;
    private ?string $nom = null;
    private ?string $type_zone = null;
    private ?float $superficie_zone = null;
    private ?string $culture = null;
    private ?float $metric1 = null;
    private ?float $metric2 = null;
    private ?float $metric3 = null;

    public function __construct(
        $reference_f = null,
        $localisation = null,
        $superficie_totale = null,
        $reference_zone = null,
        $nom = null,
        $type_zone = null,
        $superficie_zone = null,
        $culture = null,
        $metric1 = null,
        $metric2 = null,
        $metric3 = null
    ) {
        $this->reference_f = $reference_f;
        $this->localisation = $localisation;
        $this->superficie_totale = $superficie_totale;
        $this->reference_zone = $reference_zone;
        $this->nom = $nom;
        $this->type_zone = $type_zone;
        $this->superficie_zone = $superficie_zone;
        $this->culture = $culture;
        $this->metric1 = $metric1;
        $this->metric2 = $metric2;
        $this->metric3 = $metric3;
    }

    public function getReferenceF()
    {
        return $this->reference_f;
    }

    public function setReferenceF($reference_f)
    {
        $this->reference_f = $reference_f;
        return $this;
    }

    public function getLocalisation()
    {
        return $this->localisation;
    }

    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
        return $this;
    }

    public function getSuperficieTotale()
    {
        return $this->superficie_totale;
    }

    public function setSuperficieTotale($superficie_totale)
    {
        $this->superficie_totale = $superficie_totale;
        return $this;
    }

    public function getReferenceZone()
    {
        return $this->reference_zone;
    }

    public function setReferenceZone($reference_zone)
    {
        $this->reference_zone = $reference_zone;
        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getTypeZone()
    {
        return $this->type_zone;
    }

    public function setTypeZone($type_zone)
    {
        $this->type_zone = $type_zone;
        return $this;
    }

    public function getSuperficieZone()
    {
        return $this->superficie_zone;
    }

    public function setSuperficieZone($superficie_zone)
    {
        $this->superficie_zone = $superficie_zone;
        return $this;
    }

    public function getCulture()
    {
        return $this->culture;
    }

    public function setCulture($culture)
    {
        $this->culture = $culture;
        return $this;
    }

    public function getMetric1()
    {
        return $this->metric1;
    }

    public function setMetric1($metric1)
    {
        $this->metric1 = $metric1;
        return $this;
    }

    public function getMetric2()
    {
        return $this->metric2;
    }

    public function setMetric2($metric2)
    {
        $this->metric2 = $metric2;
        return $this;
    }

    public function getMetric3()
    {
        return $this->metric3;
    }

    public function setMetric3($metric3)
    {
        $this->metric3 = $metric3;
        return $this;
    }
}
?>
