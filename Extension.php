<?php
// Livefyre comment thread Extension for Bolt

namespace Bolt\Extension\Bolt\Livefyre;

use Bolt\Extensions\Snippets\Location as SnippetLocation;

class Extension extends \Bolt\BaseExtension
{
    public function getName()
    {
        return "Livefyre";
    }

    public function initialize()
    {
        $this->addTwigFunction('livefyre', 'livefyre');

        if (empty($this->config['site_id'])) { $this->config['site_id'] = "No site id set"; }
    }

    public function livefyre($title="")
    {
        $html = <<< EOM
            <div id="livefyre-comments"></div>
            <script type="text/javascript" src="http://zor.livefyre.com/wjs/v3.0/javascripts/livefyre.js"></script>
            <script type="text/javascript">
            (function () {
                var articleId = fyre.conv.load.makeArticleId(null);
                fyre.conv.load({}, [{
                    el: 'livefyre-comments',
                    network: "livefyre.com",
                    siteId: "'%site_id%'",
                    articleId: '%url%',
                    signed: false,
                    collectionMeta: {
                        articleId: '%url%',
                        url: fyre.conv.load.makeCollectionUrl(),
                    }
                }], function() {});
            }());
            </script>


EOM;


        $html = str_replace("%siteid%", $this->config['site_id'], $html);
        $html = str_replace("%url%", $this->app['paths']['canonicalurl'], $html);
       // $html = str_replace("%title%", $title, $html);

        return new \Twig_Markup($html, 'UTF-8');
    }

    

}
