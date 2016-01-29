<?php
namespace Redbox\Crawl\Dom\Elements;

class Img extends DomElementAbstract {

    /**
     * @var
     */
    protected $src;

    public function __construct(\DOMElement $element, $domain = '')
    {

        if ($element) {

            if (!($this->src = $element->getAttribute('src'))) {
                $this->error = 'Required parameter url was not set.';
                $this->setIsValid(false);
            }

            $this->setDomain($domain);

            if ($this->isIsValid()) {
                $info = parse_url($this->src);

                if (is_array($info) == true) {

                    if (isset($info['scheme']) == true) $this->setScheme($info['scheme']);
                    if (isset($info['path']) == true)   $this->setPath($info['path']);
                    if (isset($info['host']) == true)   $this->setHost($info['host']);

                    $this->setIsSecure((bool)($this->getHost() === $domain));
                }
            }

        }
    }

    public function getTag()
    {
        return 'img';
    }

    public function verifyImplementation()
    {
        // TODO: Implement verifyImplementation() method.
    }


}