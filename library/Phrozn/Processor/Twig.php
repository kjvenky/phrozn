<?php
/**
 * Copyright 2011 Victor Farazdagi
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at 
 *
 *          http://www.apache.org/licenses/LICENSE-2.0 
 *
 * Unless required by applicable law or agreed to in writing, software 
 * distributed under the License is distributed on an "AS IS" BASIS, 
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. 
 * See the License for the specific language governing permissions and 
 * limitations under the License. 
 *
 * @category    Phrozn
 * @package     Phrozn\Processor
 * @author      Victor Farazdagi
 * @copyright   2011 Victor Farazdagi
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Phrozn\Processor;

/**
 * Twig templates processor
 *
 * @category    Phrozn
 * @package     Phrozn\Processor
 * @author      Victor Farazdagi
 */
class Twig
    extends BaseProcessor
    implements \Phrozn\Processor 
{
    /**
     * Reference to twig engine environment object
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * If configuration options are passes then twig environment 
     * is initialized right away
     *
     * @param array $options Processor options
     *
     * @return void
     */
    public function __construct($options = array())
    {
        if (count($options)) {
            $this->setConfig($optsions)
                 ->getEnvironment();
        }
    }

    /**
     * Parse the incoming template
     *
     * @param string $tpl Source template file
     * @param array $vars List of variables passed to template engine
     *
     * @return string Processed template
     */
    public function render($tpl, $vars)
    {
        return $this->getEnvironment()
                    ->loadTemplate($tpl)
                    ->render($vars);
    }

    private function getEnvironment($reset = false)
    {
        if ($reset === true || null === $this->twig) {
            $this->twig = new \Twig_Environment(
                $this->getLoader(), $this->getConfig());
        }

        return $this->twig;
    }

    private function getLoader()
    {
        $config = $this->getConfig();
        if (!isset($config['loader_paths'])) {
            throw new \Exception('Twig loader paths not set');
        }

        $loader = new \Twig_Loader_Filesystem($config['loader_paths']);
        return $loader;
    }
}