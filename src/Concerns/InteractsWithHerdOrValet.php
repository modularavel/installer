<?php

namespace Modularavel\Installer\Console\Concerns;

use JsonException;
use Symfony\Component\Process\Exception\ProcessStartFailedException;
use Symfony\Component\Process\Process;

trait InteractsWithHerdOrValet
{
    /**
     * Determine if the given directory is parked using Herd or Valet.
     *
     * @param string $directory
     * @return bool
     * @throws JsonException
     */
    public function isParkedOnHerdOrValet(string $directory): bool
    {
        $output = $this->runOnValetOrHerd('paths');

        $decodedOutput = json_decode($output, false, 512, JSON_THROW_ON_ERROR);

        return is_array($decodedOutput) && in_array(dirname($directory), $decodedOutput, true);
    }

    /**
     * Runs the given command on the "herd" or "valet" CLI.
     *
     * @param  string  $command
     * @return string|bool
     */
    protected function runOnValetOrHerd(string $command): bool|string
    {
        foreach (['herd', 'valet'] as $tool) {
            $process = new Process([$tool, $command, '-v']);

            try {
                $process->run();

                if ($process->isSuccessful()) {
                    return trim($process->getOutput());
                }
            } catch (ProcessStartFailedException) {
            }
        }

        return false;
    }
}
