<?php

namespace Strayker\Foundation\App;

use Laravel\Lumen\Routing\Router as BaseLumenRouter;

class LumenRouter extends BaseLumenRouter
{
    protected function parseAction(array|string $action): array
    {
        if (is_string($action)) {
            return [
                'uses' => $action,
            ];
        } elseif (is_array($action)) {
            if (isset($action['middleware']) && is_string($action['middleware'])) {
                $action['middleware'] = explode('|', $action['middleware']);
            }

            if (
                isset($action['uses'])
                && isset($action['uses'][0])
                && count($action['uses']) === 2
                && class_exists($action['uses'][0])
            ) {
                $action['uses'] = $action['uses'][0] . '@' . $action['uses'][1];
                return $action;
            }

            if (
                isset($action[0])
                && count($action) === 2
                && class_exists($action[0])
            ) {
                return [
                    'uses' => $action[0] . '@' . $action[1],
                ];
            }

            return $action;
        } else {
            return [
                $action,
            ];
        }
    }
}
