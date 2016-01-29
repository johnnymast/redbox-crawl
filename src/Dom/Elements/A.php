<?php
namespace Redbox\Crawl\Dom\Elements;

class A extends DomElementAbstract
{

    /**
     * @var string
     */
    protected $href;


    public function __construct(\DOMElement $element, $domain = '')
    {

        if ($element) {

            if (!($this->href = $element->getAttribute('href'))) {
                $this->error = 'Required parameter url was not set.';
                $this->setIsValid(false);
            }

            $this->setDomain($domain);

            if ($this->isIsValid()) {
                $info = parse_url($this->href);

                if (is_array($info) == true) {

                    if (isset($info['scheme']) == true) $this->setScheme($info['scheme']);
                    if (isset($info['path']) == true)   $this->setPath($info['path']); // FIXME: needed ??
                    if (isset($info['host']) == true)   $this->setHost($info['host']);

                    $this->setIsSecure((bool)($this->getHost() === $domain));
                }
            }
        }

    }

    public function verifyImplementation()
    {
        if ($this->error == true) {
            throw new \Exception($this->error);
        }
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }


    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'a';
    }
}