<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Dashboard;

use UnexpectedValueException;

/**
 * \Playground\Matrix\AbstractDashboard
 */
class AbstractDashboard
{
    /**
     * @var array<string, string>
     */
    protected array $labels = [];

    /**
     * @var array<string, array<int, DashboardLink>>
     */
    protected array $links = [];

    /**
     * Counts may be positive or negative and null if untallied or the key does not exist.
     *
     * @var array<string, int|null>
     */
    protected array $counts = [];

    public function getCount(string $key): int|null
    {
        if (empty($key)
            || !array_key_exists($key, $this->counts)
            || !is_int($this->counts[$key])
        ) {
            return null;
        }

        return $this->counts[$key];
    }

    public function setCount(string $key, int|null $value): self
    {
        if (!empty($key) ) {
            $this->counts[$key] = $value;
        }

        return $this;
    }

    public function decrementCount(string $key, int $value = -1): self
    {
        if ($value > -1) {
            throw new UnexpectedValueException(sprintf(
                'Expecting the decrement value to be an integer of -1 or less. Provided: [%d]',
                $value
            ));
        }
        if (!empty($key) ) {
            if (!array_key_exists($key, $this->counts)) {
                $this->counts[$key] = 0;
            }
            $this->counts[$key] -= $value;
        }

        return $this;
    }

    public function incrementCount(string $key, int $value = 1): self
    {
        if ($value < 1) {
            throw new UnexpectedValueException(sprintf(
                'Expecting the decrement value to be an integer of 1 or more. Provided: [%d]',
                $value
            ));
        }
        if (!empty($key) ) {
            if (!array_key_exists($key, $this->counts)) {
                $this->counts[$key] = 0;
            }
            $this->counts[$key] -= $value;
        }

        return $this;
    }

    public function setLabel(string $key, string $label): self
    {
        if (!empty($key) && !empty($label)) {
            $this->labels[$key] = $label;
        }

        return $this;
    }

    public function hasLinks(string $key): bool
    {
        return !empty($key)
            && array_key_exists($key, $this->links)
            && !empty($this->links[$key])
        ;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function addLink(string $key, array $options = []): self
    {
        if (!empty($key)) {
            if (!array_key_exists($key, $this->links)) {
                $this->links[$key] = [];
            }
            $this->links[$key][] = new DashboardLink($options);
        }

        return $this;
    }

    /**
     * @return array<int, DashboardLink>
     */
    public function getLinks(string $key): array
    {
        if (empty($key)
            || !array_key_exists($key, $this->links)
            || empty($this->links[$key])
        ) {
            return [];
        }

        return $this->links[$key];
    }
}
