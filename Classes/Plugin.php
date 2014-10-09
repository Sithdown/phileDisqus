<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Sithdown\Disqus;

/**
 * PhileDisqus
 *
 * Originally a pico plugin by Philipp Schmitt: https://github.com/pschmitt/pico_disqus
 * Embeds Disqus comments to Phile.
 *
 * @author  Sithdown S.
 * @link    http://sithdown.es
 * @link    https://github.com/sithdown/phileDisqus
 * @license http://opensource.org/licenses/MIT
 * @package Phile\Plugin\Sithdown\Disqus
 */

class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {

	private $disqus_id;

	private $config;

	public function __construct() {
		\Phile\Event::registerEvent('config_loaded', $this);
		\Phile\Event::registerEvent('after_parse_content', $this);
		$this->config = \Phile\Registry::get('Phile_Settings');
	}

	private function disqus() {

		$d = '';

		if (!empty($this->disqus_id)) {
			$d = '
		    <div id="disqus_thread"></div>
            <script type="text/javascript">
                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                var disqus_shortname = \''. $this->disqus_id .'\';

                /* * * DON\'T EDIT BELOW THIS LINE * * */
                (function() {
                    var dsq = document.createElement(\'script\'); dsq.type = \'text/javascript\'; dsq.async = true;
                    dsq.src = \'//\' + disqus_shortname + \'.disqus.com/embed.js\';
                    (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
            ';
		}

		return $d;
	}

    private function config_loaded() {
        // merge the arrays to bind the settings to the view
        // Note: this->config takes precedence
        $this->config = array_merge($this->settings, $this->config);

        if (isset ($this->config['disqus_id'])) {
            $this->disqus_id = $this->config['disqus_id'];
        }
    }

    private function export_twig_vars() {
        if (\Phile\Registry::isRegistered('templateVars')) {
            $twig_vars = \Phile\Registry::get('templateVars');
        } else {
            $twig_vars = array();
        }
        $twig_vars['disqus_comments'] = $this->disqus();
        \Phile\Registry::set('templateVars', $twig_vars);
    }

	public function on($eventKey, $data = null) {
		switch ($eventKey){
			case 'config_loaded':
				$this->config_loaded();
				break;
			case 'after_parse_content':
				$this->export_twig_vars();
				break;
		}
	}
}
