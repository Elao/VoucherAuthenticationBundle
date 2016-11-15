<?php

$header = <<<EOF
This file is part of the Voucher Authentication bundle.

Copyright © élao <contact@elao.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-concat_without_spaces',
        '-phpdoc_short_description',
        '-pre_increment',
        'concat_with_spaces',
        'header_comment',
        'ordered_use',
        'phpdoc_order',
        'short_array_syntax',
    ])
    ->setUsingCache(true)
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in('.')
    )
;
