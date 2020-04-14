<?php
/**
 * @author Alexey Yashin <alx@ayashin.ru>
 * Date: 20/03/2020
 * Time: 17:34
 */
namespace AlexeyYashin\Codegen\Php\Traits;

trait ClassMember
{
    protected $Visibility = 'public';
    protected $Static = false;

    public function getVisibility()
    {
        return $this->Visibility;
    }

    public function setVisibility($value = 'public')
    {
        $this->Visibility = $value;

        return $this;
    }

    public function public()
    {
        $this->setVisibility('public');

        return $this;
    }

    public function protected()
    {
        $this->setVisibility('protected');

        return $this;
    }

    public function private()
    {
        $this->setVisibility('private');

        return $this;
    }

    public function static()
    {
        $this->Static = true;

        return $this;
    }

    public function nonstatic()
    {
        $this->Static = false;

        return $this;
    }
}