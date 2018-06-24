<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Symfony\Component\Finder\Finder;

/**
 * Class TuiEditorPlugin
 * @package Grav\Plugin
 */
class TuiEditorPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 999],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ];
    }

    public function onTwigTemplatePaths() {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Initialize the plugin
     */
    public function onTwigSiteVariables()
    {
        if ($this->isAdmin()) {
            $this->grav['locator']->addPath('blueprints', '', __DIR__ . DS . 'blueprints');

            $scripts = [
                'lib/markdown-it/markdown-it.js',
                'lib/to-mark/to-mark.js',
                'lib/tui-code-snippet/tui-code-snippet.js',
                'lib/codemirror/codemirror.js',
                'lib/highlightjs/highlight.pack.js',
                'lib/squire-rte/squire-raw.js'
            ];

            $styles = [
                'lib/codemirror/codemirror.css',
                'lib/highlightjs/styles/github.css'
            ];

            $tuiEditor = [
                'tui-editor/tui-editor-Editor.js',
                'tui-editor/tui-editor.css',
                'tui-editor/tui-editor-contents.css',
            ];

            $files = array_merge($scripts, $styles, $tuiEditor);
            foreach ($files as $file) {
                $this->grav['assets']->add('plugin://tui-editor/assets/'.$file);
            }
        }
    }

}
