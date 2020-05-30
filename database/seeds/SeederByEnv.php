<?php

namespace Seed;

use Illuminate\Database\Seeder;

/**
 * Class SeedByEnvironment
 */
abstract class SeederByEnv extends Seeder
{
    private const ENV = [
        'LOCAL' => 'local',
        'DEVELOP' => 'dev',
        'STAGE' => 'stage',
        'PRODUCTION' => 'production'
    ];

    public function run() : void
    {
        switch (\App::environment()) {

            case self::ENV['LOCAL']:
                $this->localSeeds();
                break;

            case self::ENV['DEVELOP']:
                $this->developSeeds();
                break;

            case self::ENV['STAGE']:
                $this->stageSeeds();
                break;

            case self::ENV['PRODUCTION']:
                $this->productionSeeds();
                break;

            default:
                throw new \Exception('Error run seeds');
        }
    }

    public function localSeeds() {
        $this->developSeeds();
    }

    abstract public function developSeeds() : void;
    abstract public function stageSeeds() : void;
    abstract public function productionSeeds() : void;
}
