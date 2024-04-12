<?php

namespace App\Contracts\Scale;

use Socket;

interface ScaleApiServiceInterface
{
    public function crc16(string $data): string;
    public function getScaleInfo(string $ip, int $port): array;
    public function sendCommandToSocket(\Socket $socket): array;
    public function convertHexToDec(array $stringHex, array $positionList): array;
    public function convertHexArrayDataToWeightForScale(array $hexArrayData): int;
    public function getSocket(string $ip, int $port): Socket;
}
