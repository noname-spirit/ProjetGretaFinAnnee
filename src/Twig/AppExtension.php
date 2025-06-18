<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('regex_match', [$this, 'regexMatch']),
            new TwigFilter('regex_replace', [$this, 'regexReplace']),
        ];
    }

    public function regexMatch(string $subject, string $pattern): bool
    {
        return preg_match($pattern, $subject);
    }

    public function regexReplace(string $subject, string $pattern, string $replacement): string
    {
        return preg_replace($pattern, $replacement, $subject);
    }
}
