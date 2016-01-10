<?php
namespace Redbox\Crawl\Dom\Elements;

class IMG extends DomElementAbstract {

    /**
     * @var
     */
    protected $src;

    public function __construct($args)
    {
        extract($args);

        if (isset($url) == false) {
            $this->error = 'Required parameter url was not set.';
            $this->setIsValid(false);
        }

        if (isset($domain) == false) {
            $this->error = 'required parameter domain was not set.';
            $this->setIsValid(false);
        }

        if ($this->isIsValid()) {
            $this->setUrl($url);

            $info = parse_url($url);
            if (is_array($info) == true) {

                if (isset($info['scheme']) == true) $this->setScheme($info['scheme']);
                if (isset($info['path']) == true) $this->setPath($info['path']);
                if (isset($info['host']) == true) $this->setHost($info['host']);

                $this->setIsOnDomain((bool)($this->getHost() === $domain));
            }
        }
    }

    public function getTag()
    {
        return 'IMG';
    }

    public function verifyImplementation()
    {
        // TODO: Implement verifyImplementation() method.
    }


}