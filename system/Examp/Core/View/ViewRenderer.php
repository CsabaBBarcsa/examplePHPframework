<?php
/**
 * S.D.G.! P.G.A.! :)
 * 
 * based on Devanych View Renderer, Thank you Devanych
 * * https://github.com/devanych/view-renderer
 * @copyright - (partly) - (c) 2020, Evgeniy Zyubin,
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions
 */

namespace Examp\Core\View;

use Examp\Core\Handlers\Files;

use function extract;
use function ob_end_clean;
use function ob_get_level;
use function ob_start;
/**
 * Description of ViewRenderer
 */
class ViewRenderer
{
    private $templatePath;

    private $block = [];
    private $blockName;
    private $layout;
    private $contentPartNames = [];

    public function __construct(string $basePath)
    {
        $this->templatePath = $basePath.DIRECTORY_SEPARATOR.'templates';
    }

    public function render(string $viewName, array $viewData = []): string
    {
        $level = ob_get_level();
        if ($level)
        {
            ob_get_clean();
        }

        $this->layout = NULL;

        try
        {
            // if there is a layout setted up, then it will be reachable
            // and if there a block setted up it will be also reachable,
            //    but it was not nulled like the layout
            $content =  $this->getViewContent( $viewName, $viewData);
        }
        catch( \Throwabel $error)
        {
            while ($level < ob_get_level())
            {
                ob_end_clean();
            }
            throw $error;
        }

        //if no more layout, then return the hole content
        if ( !$this->layout )
        {
            return $content;
        }

        return $this->render( $this->layout, $viewData );
    }

    public function getViewContent(string $viewFileName, array $viewData = [])
    {
        $checkedViewFile = $this->checkViewFile($viewFileName);

        extract($viewData, EXTR_PREFIX_SAME, 'vd_');
        //unsetting the incomming variables
        unset($viewData, $viewFileName);

        ob_start();
        include_once $checkedViewFile['path'];
        $viewContent = ob_get_clean();

        if(!empty($this->contentPartNames))
        {
            foreach($this->contentPartNames as $partName )
            {
                ob_start();

                include $this->checkViewFile($partName)['path'];
                $viewContentPart = ob_get_clean();

                $viewContent = str_replace('¤'.$partName, $viewContentPart, $viewContent);
            }
        }

        return  $viewContent;
    }

    /**
     * @desc - it is set a template part to process it, to -- include -- it
     * @param string $contentPartName
     * @return type
     */
    public function setContentPart(string $contentPartName)
    {
        $this->contentPartNames[] = $contentPartName;

        return '¤'.$contentPartName;
    }

    public function checkViewFile(string $viewFileName)
    {
        $searchFile = (new Files())->searchFile($viewFileName, $this->templatePath);

        if( $searchFile === '' || !file_exists($searchFile['path']) )
        {
            throw new \Exception("There is no such view file ".$viewFileName."!");
        }

        return $searchFile;
    }

    /**/
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**/
    public function startBlock(string $blockName)
    {
        if ( $this->blockName )
        {
            throw new \RuntimeException("Don't nesting the blocks");
        }
        $this->blockName = $blockName;
        ob_start();
    }

    /**/
    public function endBlock(): void
    {
        if(!$this->blockName)
        {
            throw new \RuntimeException("There is no block begining!");
        }
        $this->setBlock($this->blockName, ob_get_clean());
        $this->blockName = NULL;
    }

    /**/
    public function setBlock(string $blockKey, $blockContent): void
    {
        if(array_key_exists($blockKey, $this->block))
        {
            throw new \Exception("This view block key, has already been set!");
        }

        $this->block[$blockKey] = $blockContent;
    }

    /**/
    public function getBlock(string $blockKey): string
    {
        return $this->block[$blockKey] ?? '';
    }

}
