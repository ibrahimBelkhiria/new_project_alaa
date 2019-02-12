<?php
/**
 * Created by PhpStorm.
 * User: Logidee
 * Date: 30/01/2019
 * Time: 18:45
 */

namespace AppBundle\Representation;


use JMS\Serializer\Annotation\Type;
use Pagerfanta\Pagerfanta;

class Articles
{


    /**
     * @Type("array<AppBundle\Entity\Article>")
     */
    public $data;

    public $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('offset', $data->getCurrentPageOffsetStart());
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }

}