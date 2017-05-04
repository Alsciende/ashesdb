<?php

namespace AppBundle\Query;

/**
 * Description of QueryTemplating
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryTemplating
{
    /**
     *
     * @var \Twig_Environment
     */
    private $twig;
    
    /**
     *
     * @var QueryBuilder
     */
    private $builder;
    
    public function __construct ($twig, $builder)
    {
        $this->twig = $twig;
        $this->builder = $builder;
    }
    
    public function render(QueryInput $input)
    {
        $query = $this->builder->getQuery($input->getClauses());
        $result = $query->getResult();
        $template = "cards/view-" . $input->getView() . ".html.twig";
        $context = [
            "cards" => $result
        ];
        
        return $this->twig->render($template, $context);
    }
}
