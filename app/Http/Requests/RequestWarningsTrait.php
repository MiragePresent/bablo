<?php

namespace App\Http\Requests;


use Illuminate\Support\MessageBag;

trait RequestWarningsTrait
{
    /** @var \Illuminate\Support\MessageBag $warningsBag */
    protected $warningsBag;

    public function __construct()
    {
        parent::__construct();

        $this->warningsBag = new MessageBag;
    }

    /**
     *  Get warnings bag
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function warnings()
    {
        return $this->warningsBag;
    }

    /**
     *  Add warning
     *
     * @param $field
     * @param $message
     * @return \Illuminate\Support\MessageBag
     */
    public function add($field, $message)
    {
        return $this->warningsBag->add($field, $message);
    }

    /**
     *  Determine whether exists warnings
     *
     * @return bool
     */
    public function hasWarnings()
    {
        return $this->warningsBag->isNotEmpty();
    }

    /**
     *  Get warnings
     *
     * @return array
     */
    public function all()
    {
        return $this->warningsBag->messages();
    }

}