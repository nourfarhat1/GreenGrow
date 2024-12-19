<?php
class FarmModel
{
    private ?string $reference_f = null;
    private ?string $localisation = null;
    private ?float $superficie_totale = null;

    public function __construct($reference_f = null, $localisation = null, $superficie_totale = null)
    {
        $this->reference_f = $reference_f;
        $this->localisation = $localisation;
        $this->superficie_totale = $superficie_totale;
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
}
?>
