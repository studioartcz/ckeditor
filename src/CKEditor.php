<?php

namespace App\Components;

use Nette;

class CKEditor {

    private $editorPath;
    public $fman;
    public $head;
    public $footer;
    private $url;

    public function __construct(Nette\Http\Request $request, $url)
    {
        $this->editorPath = $request->getUrl()->baseUrl . "js/admin/ckeditor";
        $this->fman       = "./api/fman";
        $this->head       = $this->init();
        $this->footer     = $this->setup();
    }

    public function init()
    {
        $editor = "
        <script src='{$this->editorPath}/ckeditor.js'></script>
        <style>
            .cke_chrome {
                box-shadow: none!important;
                border: 1px solid #eee!important;
                overflow: hidden;
            }
            .cke_bottom {
                background: #edf0f0!important;
            }
            .cke_path_item, .cke_path_empty {
                color: gray!important;
            }
        </style>";

        return $editor;
    }

    public function setup()
    {
        $editor="
        <script type='text/javascript'>
        
        function _x(STR_XPATH) {
            var xresult = document.evaluate(STR_XPATH, document, null, XPathResult.ANY_TYPE, null);
            var xnodes = [];
            var xres;
            while (xres = xresult.iterateNext()) {
                xnodes.push(xres);
            }

            return xnodes;
        }
        
        /* <![CDATA[ */
        $(document).ready(function(){
            CKEDITOR.config.language = 'cs';
            CKEDITOR.config.defaultLanguage = 'cs';
            CKEDITOR.config.baseHref = '/';
            CKEDITOR.config.height = 400;
            CKEDITOR.config.ignoreEmptyParagraph = true;
            CKEDITOR.config.entities = false;
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.forcePasteAsPlainText = true;     
                   
        
            CKEDITOR.config.format_tags = 'h2;h3;pre;div,block';   
            CKEDITOR.config.format_block = { 
                name: 'Blok - modrý',
                element: 'div', 
                attributes: { 
                    'class': 'normalPara' 
                } 
            };                   
                   
            CKEDITOR.config.extraPlugins = 'image2,widget,widgetcommon,dialogui'; // oembed
            CKEDITOR.config.removePlugins = 'colorbutton';

                        
            CKEDITOR.config.skin = 'office2013';

             CKEDITOR.config.filebrowserBrowseUrl = '" . $this->fman . "';
             CKEDITOR.config.filebrowserImageBrowseUrl = '" . $this->fman . "';
             CKEDITOR.config.filebrowserFlashBrowseUrl = '" . $this->fman . "';
             CKEDITOR.config.filebrowserUploadUrl = '" . $this->fman . "';
             CKEDITOR.config.filebrowserImageUploadUrl = '" . $this->fman . "';
             CKEDITOR.config.filebrowserFlashUploadUrl = '" . $this->fman . "';
            
            // run
            $('textarea[name=content].areabig, textarea.editor').each(function()
            {
                var attr = $(this).attr('data-editor-mode');
                var eHgt = $(this).attr('data-editor-height');
                 
                if(typeof attr !== typeof undefined && attr !== false)
                {
                    // here is code mirror
                }else 
                {
                    if(eHgt){CKEDITOR.config.height = eHgt;}                    
                    CKEDITOR.replace(this);
                } 
            });
        });
        /* ]]> */</script>";

        return $editor;
    }

}
