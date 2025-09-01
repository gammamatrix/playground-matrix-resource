<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Resource\Dashboard;

/**
 * \Playground\Matrix\DashboardLink
 */
class DashboardLink
{
    public ?string $description = null;

    public ?string $label = null;

    public ?string $target = null;

    public ?string $uri = null;

    /**
     * @param  array<string, mixed>  $options
     */
    public function __construct(array $options = [])
    {
        if (array_key_exists('description', $options)
            && is_string($options['description'])
        ) {
            $this->setDescription($options['description']);
        }

        if (array_key_exists('label', $options)
            && is_string($options['label'])
        ) {
            $this->setLabel($options['label']);
        }

        if (array_key_exists('target', $options)
            && is_string($options['target'])
        ) {
            $this->setTarget($options['target']);
        }

        if (array_key_exists('uri', $options)
            && is_string($options['uri'])
        ) {
            $this->setUri($options['uri']);
        }
    }

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'label' => $this->label,
            'target' => $this->target,
            'uri' => $this->uri,
        ];
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }
}
