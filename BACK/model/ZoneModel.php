<?php
class ZoneModel
{
    private ?string $reference_zone = null;
    private ?string $nom = null;
    private ?string $type_zone = null;
    private ?float $superficie_zone = null;
    private ?string $culture = null;
    private ?string $reference_f = null;

    public function __construct($reference_zone = null, $nom = null, $type_zone = null, $superficie_zone = null, $culture = null, $reference_f = null)
    {
        $this->reference_zone = $reference_zone;
        $this->nom = $nom;
        $this->type_zone = $type_zone;
        $this->superficie_zone = $superficie_zone;
        $this->culture = $culture;
        $this->reference_f = $reference_f;
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

    public function getReferenceF()
    {
        return $this->reference_f;
    }

    public function setReferenceF($reference_f)
    {
        $this->reference_f = $reference_f;
        return $this;
    }
}
?>
