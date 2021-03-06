<?php
namespace J6s\PhpArch\Parser\Visitor;

use PhpParser\Node;

/**
 * Visitor that extracts all references to fully qualified names.
 * This includes class extensions, interface usages, instance creations etc.
 *
 * This Visitor is best used in combination with PhpParser\NodeVisitor\NameResolver
 * as that visitor converts imported namespace usages into fully qualified names.
 * In that combination this visitor will extract every direct reference to a class.
 */
class FullyQualifiedReference extends NamespaceCollectingVisitor
{

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Name\FullyQualified) {
            $string = (string) $node;
            $exists = class_exists($string) || interface_exists($string) || trait_exists($string);
            if ($exists) {
                $this->namespaces[] = (string) $node;
            }
        }
    }
}
